<?php

namespace App\Console\Commands;

use App\Models\Membership;
use App\Models\User;
use App\Models\User\BasicSetting as UserBasicSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RestoreEcomGroceryTemplate extends Command
{
    protected $signature = 'template:restore-ecomgrocery';
    protected $description = 'Restore and re-enable the Ecom Grocery (grocery2) demo template for launchshop.in';

    public function handle()
    {
        $this->info('Starting Ecom Grocery Demo Theme restoration...');

        $sqlPath = base_path('database/restore_ecomgrocery.sql');

        // Check if user exists
        $user = User::where('username', 'ecomgrocery')->first();

        if (!$user) {
            $this->info('User "ecomgrocery" not found in database. Importing full template data from database/restore_ecomgrocery.sql...');
            if (File::exists($sqlPath)) {
                $sql = File::get($sqlPath);
                DB::unprepared($sql);
                $this->info('SQL data imported successfully.');
            } else {
                $this->error('restore_ecomgrocery.sql file not found!');
                return self::FAILURE;
            }
            $user = User::where('username', 'ecomgrocery')->first();
        }

        if ($user) {
            // Ensure all template preview flags are active
            $user->preview_template = 1;
            $user->status = 1;
            $user->online_status = 1;
            $user->featured = 1;
            $user->template_img = 'grocery2.png';
            $user->template_serial_number = 3;
            $user->save();

            // Ensure active membership
            $membership = Membership::where('user_id', $user->id)->first();
            if ($membership) {
                $membership->status = 1;
                $membership->start_date = Carbon::now()->subDay()->format('Y-m-d');
                $membership->expire_date = '2036-12-31';
                $membership->save();
            } else {
                Membership::create([
                    'user_id' => $user->id,
                    'package_id' => 10,
                    'status' => 1,
                    'start_date' => Carbon::now()->subDay()->format('Y-m-d'),
                    'expire_date' => '2036-12-31',
                    'price' => 0,
                    'currency' => 'INR',
                    'currency_symbol' => '₹',
                    'payment_method' => 'Offline',
                    'transaction_id' => 'template_ecomgrocery',
                ]);
            }

            // Ensure basic settings theme is grocery2
            $ubs = UserBasicSetting::where('user_id', $user->id)->first();
            if ($ubs) {
                $ubs->theme = 'grocery2';
                $ubs->save();
            } else {
                UserBasicSetting::create([
                    'user_id' => $user->id,
                    'theme' => 'grocery2',
                    'website_title' => 'Ecom Grocery',
                    'base_color' => '253D4E',
                ]);
            }

            $this->info("SUCCESS: Ecom Grocery demo theme restored! User ID: {$user->id}, Theme: grocery2, Preview Template: active, Serial: 3");
            return self::SUCCESS;
        }

        $this->error('Failed to restore Ecom Grocery template.');
        return self::FAILURE;
    }
}
