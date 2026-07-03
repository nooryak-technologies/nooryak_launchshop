<?php

namespace App\Http\Controllers\User;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\UserShippingGateway;
use App\Models\User\UserOrder;
use App\Models\Customer;
use App\Http\Helpers\BasicMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ShippingGatewayController extends Controller
{
    public function index()
    {
        $user_id = Auth::guard('web')->user()->id;
        $data['aftership'] = UserShippingGateway::where([['user_id', $user_id], ['keyword', 'aftership']])->first();
        $data['shiprocket'] = UserShippingGateway::where([['user_id', $user_id], ['keyword', 'shiprocket']])->first();
        $data['shippo'] = UserShippingGateway::where([['user_id', $user_id], ['keyword', 'shippo']])->first();
        return view('user.settings.shipping_gateway.index', $data);
    }

    public function aftershipUpdate(Request $request)
    {
        $gateway = UserShippingGateway::where([['user_id', Auth::guard('web')->user()->id], ['keyword', 'aftership']])->first();
        if (empty($gateway)) {
            $gateway = new UserShippingGateway();
            $gateway->name = 'AfterShip';
            $gateway->keyword = 'aftership';
            $gateway->user_id = Auth::guard('web')->user()->id;
        }
        $gateway->status = $request->status;
        $information = [
            'api_key' => $request->api_key,
        ];
        $gateway->information = json_encode($information);
        $gateway->save();
        
        Session::flash('success', __('Updated Successfully'));
        return back();
    }

    public function shiprocketUpdate(Request $request)
    {
        $gateway = UserShippingGateway::where([['user_id', Auth::guard('web')->user()->id], ['keyword', 'shiprocket']])->first();
        if (empty($gateway)) {
            $gateway = new UserShippingGateway();
            $gateway->name = 'Shiprocket';
            $gateway->keyword = 'shiprocket';
            $gateway->user_id = Auth::guard('web')->user()->id;
        }
        $gateway->status = $request->status;
        $information = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $gateway->information = json_encode($information);
        $gateway->save();
        
        Session::flash('success', __('Updated Successfully'));
        return back();
    }

    public function shippoUpdate(Request $request)
    {
        $gateway = UserShippingGateway::where([['user_id', Auth::guard('web')->user()->id], ['keyword', 'shippo']])->first();
        if (empty($gateway)) {
            $gateway = new UserShippingGateway();
            $gateway->name = 'Shippo';
            $gateway->keyword = 'shippo';
            $gateway->user_id = Auth::guard('web')->user()->id;
        }
        $gateway->status = $request->status;
        $information = [
            'api_key' => $request->api_key,
        ];
        $gateway->information = json_encode($information);
        $gateway->save();
        
        Session::flash('success', __('Updated Successfully'));
        return back();
    }

    public function trackingUpdate(Request $request)
    {
        $rules = [
            'order_id' => 'required',
            'courier_name' => 'required',
            'tracking_number' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $order = UserOrder::findOrFail($request->order_id);
        $order->courier_name = $request->courier_name;
        $order->tracking_number = $request->tracking_number;
        $order->shipping_gateway_keyword = $request->shipping_gateway_keyword;

        $tracking_url = null;

        if ($request->shipping_gateway_keyword == 'aftership') {
            $gateway = UserShippingGateway::where([['user_id', $order->user_id], ['keyword', 'aftership'], ['status', 1]])->first();
            if ($gateway) {
                $info = json_decode($gateway->information, true);
                $apiKey = $info['api_key'] ?? '';
                if ($apiKey) {
                    try {
                        $client = new \GuzzleHttp\Client();
                        $response = $client->post('https://api.aftership.com/v4/trackings', [
                            'headers' => [
                                'aftership-api-key' => $apiKey,
                                'Content-Type' => 'application/json',
                            ],
                            'json' => [
                                'tracking' => [
                                    'tracking_number' => $request->tracking_number,
                                    'title' => 'Order #' . $order->order_number,
                                ]
                            ]
                        ]);
                        $resData = json_decode($response->getBody()->getContents(), true);
                        if (isset($resData['data']['tracking']['tracking_url'])) {
                            $tracking_url = $resData['data']['tracking']['tracking_url'];
                        }
                    } catch (\Exception $e) {
                        \Log::error('AfterShip Tracking Error: ' . $e->getMessage());
                    }
                }
            }
        } elseif ($request->shipping_gateway_keyword == 'shippo') {
            $gateway = UserShippingGateway::where([['user_id', $order->user_id], ['keyword', 'shippo'], ['status', 1]])->first();
            if ($gateway) {
                $info = json_decode($gateway->information, true);
                $apiKey = $info['api_key'] ?? '';
                if ($apiKey) {
                    try {
                        $client = new \GuzzleHttp\Client();
                        $carrierSlug = strtolower(str_replace(' ', '-', $request->courier_name));
                        $response = $client->post('https://api.goshippo.com/tracks/', [
                            'headers' => [
                                'Authorization' => 'ShippoToken ' . $apiKey,
                                'Content-Type' => 'application/json',
                            ],
                            'json' => [
                                'carrier' => $carrierSlug,
                                'tracking_number' => $request->tracking_number,
                            ]
                        ]);
                        $resData = json_decode($response->getBody()->getContents(), true);
                        if (isset($resData['tracking_status']['tracking_url'])) {
                            $tracking_url = $resData['tracking_status']['tracking_url'];
                        }
                    } catch (\Exception $e) {
                        \Log::error('Shippo Tracking Error: ' . $e->getMessage());
                    }
                }
            }
        } elseif ($request->shipping_gateway_keyword == 'shiprocket') {
            $tracking_url = 'https://shiprocket.co/tracking/' . $request->tracking_number;
        }

        if (empty($tracking_url)) {
            $tracking_url = 'https://www.google.com/search?q=' . urlencode($request->courier_name . ' tracking ' . $request->tracking_number);
        }

        $order->tracking_url = $tracking_url;
        $order->save();

        $customer = Customer::where('id', $order->customer_id)->first();
        $email = $customer ? $customer->email : $order->billing_email;
        $name = $customer ? ($customer->first_name . ' ' . $customer->last_name) : ($order->billing_fname . ' ' . $order->billing_lname);
        
        $root_user = \App\Models\User::find($order->user_id);
        
        if ($email) {
            try {
                $mail_subject = __('Shipment Shipped - Tracking Details');
                $mail_body = '<p>' . __('Hi') . ' ' . $name . ',</p>' .
                            '<p>' . __('Your order') . ' <strong>#' . $order->order_number . '</strong> ' . __('has been shipped via') . ' <strong>' . $request->courier_name . '</strong>.</p>' .
                            '<p>' . __('Tracking Number') . ': <strong>' . $request->tracking_number . '</strong></p>' .
                            '<p>' . __('You can track your shipment using the link below:') . '</p>' .
                            '<p><a href="' . $tracking_url . '" target="_blank" style="padding: 8px 16px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">' . __('Track Order') . '</a></p>';

                $info = DB::table('basic_extendeds')
                    ->select('is_smtp', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
                    ->first();

                $data = [];
                $data['smtp_status'] = $info->is_smtp;
                $data['smtp_host'] = $info->smtp_host;
                $data['smtp_port'] = $info->smtp_port;
                $data['encryption'] = $info->encryption;
                $data['smtp_username'] = $info->smtp_username;
                $data['smtp_password'] = $info->smtp_password;
                $data['from_mail'] = $info->from_mail;
                $data['recipient'] = $email;
                $data['subject'] = $mail_subject;
                $data['body'] = $mail_body;
                BasicMailer::sendMail($data);
            } catch (\Exception $e) {
                \Log::error('Tracking Email Error: ' . $e->getMessage());
            }
        }

        Session::flash('success', __('Tracking Details Saved & Customer Notified!'));
        return back();
    }
}
