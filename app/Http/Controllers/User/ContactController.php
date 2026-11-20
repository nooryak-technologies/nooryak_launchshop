<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\UserContact;
use App\Models\User\BasicSetting;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Session;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();
        $language = null;
        if ($request->filled('language')) {
            $language = Language::where('code', $request->language)->where('user_id', $user->id)->first();
        }
        if (empty($language)) {
            $language = Language::where('is_default', 1)->where('user_id', $user->id)->first()
                ?? Language::where('user_id', $user->id)->first();
        }

        $dummyPhones = ['72007 70351', '7200770351', '6374913298', '1234567890'];
        $dummyEmails = ['nooryaktechnologies@gmail.com', 'admin@launchshop.in'];
        $dummyAddresses = ['Triplicane, Chennai, IND', 'Triplicane, Chennai'];

        $contact = null;
        if ($language) {
            $contact = UserContact::where('language_id', $language->id)->where('user_id', $user->id)->first();
        }

        // Auto-initialize with user's real profile data if missing or holding old demo template data
        if (empty($contact)) {
            $contact = new UserContact();
            $contact->user_id = $user->id;
            $contact->language_id = $language ? $language->id : 0;
            $contact->contact_numbers = $user->phone;
            $contact->contact_mails = $user->email;
            $contact->contact_addresses = $user->address;
            if ($language) {
                $contact->save();
            }
        } else {
            $needsSave = false;
            if (empty(trim((string)$contact->contact_numbers)) || in_array(trim((string)$contact->contact_numbers), $dummyPhones)) {
                if (!empty($user->phone)) {
                    $contact->contact_numbers = $user->phone;
                    $needsSave = true;
                }
            }
            if (empty(trim((string)$contact->contact_mails)) || in_array(trim((string)$contact->contact_mails), $dummyEmails)) {
                if (!empty($user->email)) {
                    $contact->contact_mails = $user->email;
                    $needsSave = true;
                }
            }
            if (empty(trim((string)$contact->contact_addresses)) || in_array(trim((string)$contact->contact_addresses), $dummyAddresses)) {
                if (!empty($user->address)) {
                    $contact->contact_addresses = $user->address;
                    $needsSave = true;
                }
            }
            if ($needsSave) {
                $contact->save();
            }
        }

        \App\Models\User\ContactMessage::ensureTableExists();
        $information['contact_messages'] = \App\Models\User\ContactMessage::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->get();
        $information['data'] = $contact;
        return view('user.contact', $information);
    }

    public function deleteMessage($id)
    {
        $user = Auth::guard('web')->user();
        \App\Models\User\ContactMessage::ensureTableExists();
        \App\Models\User\ContactMessage::where('user_id', $user->id)->where('id', $id)->delete();
        Session::flash('success', __('Message deleted successfully'));
        return back();
    }

    public function update(Request $request, $language)
    {
        $user = Auth::guard('web')->user();
        $lang = Language::where('code', $language)->where('user_id', $user->id)->first();
        if (empty($lang)) {
            $lang = Language::where('is_default', 1)->where('user_id', $user->id)->first()
                ?? Language::where('user_id', $user->id)->first();
        }

        $rules = [
            'contact_form_title' => 'nullable|max:255',
            'contact_form_subtitle' => 'nullable|max:255',
            'contact_addresses' => 'nullable',
            'contact_numbers' => 'nullable',
            'contact_mails' => 'nullable|max:255',
            'latitude' => 'nullable|max:255',
            'longitude' => 'nullable|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $cleanAddress = clean($request->contact_addresses);
        $cleanPhone = $request->contact_numbers;
        $cleanEmail = $request->contact_mails;

        // 1. Update/Save UserContact for all languages of this merchant to keep them unified
        $languages = Language::where('user_id', $user->id)->get();
        if ($languages->isEmpty() && $lang) {
            $languages = collect([$lang]);
        }

        foreach ($languages as $l) {
            $item = UserContact::where([
                ['user_id', $user->id],
                ['language_id', $l->id]
            ])->first();

            if (is_null($item)) {
                $item = new UserContact();
                $item->user_id = $user->id;
                $item->language_id = $l->id;
            }

            $item->contact_form_title = $request->contact_form_title;
            $item->contact_form_subtitle = $request->contact_form_subtitle;
            $item->contact_addresses = $cleanAddress;
            $item->contact_numbers = $cleanPhone;
            $item->contact_mails = $cleanEmail;
            $item->latitude = $request->latitude;
            $item->longitude = $request->longitude;
            $item->save();
        }

        // 2. Synchronize to User Profile (primary phone & address)
        $primaryPhone = null;
        if (!empty($cleanPhone)) {
            $phoneParts = explode(',', $cleanPhone);
            $primaryPhone = trim($phoneParts[0]);
        }
        $primaryAddress = null;
        if (!empty($cleanAddress)) {
            $addrLines = preg_split('/\r\n|\r|\n/', trim(strip_tags($cleanAddress)));
            $primaryAddress = !empty($addrLines[0]) ? trim($addrLines[0]) : trim(strip_tags($cleanAddress));
        }

        if ($primaryPhone) {
            $user->phone = $primaryPhone;
        }
        if (!empty($cleanAddress)) {
            $user->address = trim(strip_tags($cleanAddress));
        }
        $user->save();

        // 3. Synchronize to User Basic Settings
        if (Schema::hasTable('user_basic_settings')) {
            $userBs = BasicSetting::where('user_id', $user->id)->first();
            if ($userBs) {
                if (Schema::hasColumn('user_basic_settings', 'contact_number') && $primaryPhone) {
                    $userBs->contact_number = $primaryPhone;
                }
                if (Schema::hasColumn('user_basic_settings', 'address') && !empty($cleanAddress)) {
                    $userBs->address = trim(strip_tags($cleanAddress));
                }
                if (Schema::hasColumn('user_basic_settings', 'email') && !empty($cleanEmail)) {
                    $emailParts = explode(',', $cleanEmail);
                    $userBs->email = trim($emailParts[0]);
                }
                $userBs->save();
            }
        }

        Session::flash('success', __('Updated Successfully'));
        return back();
    }
}
