<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSetting;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WhatsAppOtpController extends Controller
{
    /**
     * Ensure database columns exist on basic_settings table.
     */
    public static function ensureColumnsExist(): void
    {
        try {
            if (!Schema::hasTable('basic_settings')) {
                return;
            }

            if (!Schema::hasColumn('basic_settings', 'whatsapp_status')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN whatsapp_status TINYINT(1) NOT NULL DEFAULT 1");
            }
            if (!Schema::hasColumn('basic_settings', 'whatsapp_endpoint')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN whatsapp_endpoint VARCHAR(255) NULL DEFAULT 'http://localhost:8000'");
            }
            if (!Schema::hasColumn('basic_settings', 'whatsapp_access_token')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN whatsapp_access_token VARCHAR(255) NULL DEFAULT 'token_6005c0f6de385fe7'");
            }
            if (!Schema::hasColumn('basic_settings', 'whatsapp_instance_id')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN whatsapp_instance_id VARCHAR(255) NULL DEFAULT 'E6C34AF85064'");
            }
            if (!Schema::hasColumn('basic_settings', 'dual_otp_status')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN dual_otp_status TINYINT(1) NOT NULL DEFAULT 1");
            }
            if (!Schema::hasColumn('basic_settings', 'whatsapp_otp_template')) {
                DB::statement("ALTER TABLE basic_settings ADD COLUMN whatsapp_otp_template TEXT NULL");
            }
        } catch (\Throwable $e) {
            Log::warning('WhatsAppOtpController ensureColumnsExist warning: ' . $e->getMessage());
        }
    }

    /**
     * Display WhatsApp Gateway & Dual OTP configuration screen.
     */
    public function index()
    {
        self::ensureColumnsExist();

        $bs = BasicSetting::first();
        if (!$bs) {
            $bs = new BasicSetting();
        }

        // Apply sensible defaults matching active WhatsApp instance if not yet set
        if (empty($bs->whatsapp_endpoint)) {
            $bs->whatsapp_endpoint = env('WHATSAPP_SERVER_URL', 'http://localhost:8000');
        }
        if (empty($bs->whatsapp_access_token)) {
            $bs->whatsapp_access_token = env('WHATSAPP_ACCESS_TOKEN', 'token_6005c0f6de385fe7');
        }
        if (empty($bs->whatsapp_instance_id)) {
            $bs->whatsapp_instance_id = env('WHATSAPP_INSTANCE_ID', 'E6C34AF85064');
        }
        if (!isset($bs->whatsapp_status)) {
            $bs->whatsapp_status = 1;
        }
        if (!isset($bs->dual_otp_status)) {
            $bs->dual_otp_status = 1;
        }
        if (empty($bs->whatsapp_otp_template)) {
            $bs->whatsapp_otp_template = WhatsAppNotificationService::DEFAULT_OTP_TEMPLATE;
        }

        return view('admin.basic.whatsapp_otp', compact('bs'));
    }

    /**
     * Update WhatsApp Gateway & Dual OTP settings.
     */
    public function update(Request $request)
    {
        self::ensureColumnsExist();

        $validator = Validator::make($request->all(), [
            'whatsapp_status'       => 'nullable|in:0,1',
            'dual_otp_status'       => 'nullable|in:0,1',
            'whatsapp_endpoint'     => 'required|string|max:255',
            'whatsapp_access_token' => 'required|string|max:255',
            'whatsapp_instance_id'  => 'required|string|max:255',
            'whatsapp_otp_template' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bs = BasicSetting::first();
        if (!$bs) {
            $bs = new BasicSetting();
        }

        $endpoint = rtrim(trim($request->input('whatsapp_endpoint')), '/');
        // If admin passed /send_message in the endpoint, strip it so the base remains clean
        if (str_ends_with($endpoint, '/send_message')) {
            $endpoint = substr($endpoint, 0, -13);
        }

        $data = [
            'whatsapp_status'       => $request->has('whatsapp_status') ? 1 : 0,
            'dual_otp_status'       => $request->has('dual_otp_status') ? 1 : 0,
            'whatsapp_endpoint'     => $endpoint,
            'whatsapp_access_token' => trim($request->input('whatsapp_access_token')),
            'whatsapp_instance_id'  => trim($request->input('whatsapp_instance_id')),
            'whatsapp_otp_template' => trim($request->input('whatsapp_otp_template') ?: WhatsAppNotificationService::DEFAULT_OTP_TEMPLATE),
        ];

        try {
            if ($bs->exists) {
                $bs->update($data);
            } else {
                $data['language_id'] = 1;
                BasicSetting::create($data);
            }

            // Invalidate cache immediately so new credentials are active
            Cache::forget('whatsapp_gateway_config_launchshop');

            // Pre-warm the cache with updated credentials
            WhatsAppNotificationService::getWhatsAppConfig();

            Session::flash('success', __('WhatsApp & Dual OTP Settings updated successfully!'));
        } catch (\Throwable $e) {
            Session::flash('warning', __('Error updating settings: ') . $e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Send a live test OTP message from the admin panel to verify connection.
     */
    public function testSend(Request $request)
    {
        $request->validate([
            'test_phone' => 'required',
        ]);

        $phone = preg_replace('/[^0-9]/', '', (string)$request->input('test_phone'));
        if (empty($phone)) {
            return response()->json([
                'success' => false,
                'message' => __('Please enter a valid phone number with country code (e.g. 918667702473).'),
            ]);
        }

        // Add 91 if only 10 digits
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        $testOtp = (string) rand(100000, 999999);

        try {
            $result = WhatsAppNotificationService::sendOtp($phone, $testOtp, 'LaunchShop');

            if ($result['success'] ?? false) {
                return response()->json([
                    'success'  => true,
                    'message'  => __('Test OTP sent successfully to ') . $phone . __('! (Code: ' . $testOtp . ')'),
                    'response' => $result,
                ]);
            }

            return response()->json([
                'success'  => false,
                'message'  => $result['message'] ?? __('Failed to send test OTP. Please verify endpoint, token, and instance ID.'),
                'response' => $result,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error: ') . $e->getMessage(),
            ]);
        }
    }
}
