<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Language;
use App\Models\User\UserHeader;
use Illuminate\Http\Request;
use Auth;
use Session;
use Validator;

class HeaderSectionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $lang = null;
        if (!empty($request->language)) {
            $lang = Language::where('code', $request->language)->where('user_id', $userId)->first();
        }
        if (empty($lang)) {
            $lang = Language::where('is_default', 1)->where('user_id', $userId)->first()
                ?? Language::where('user_id', $userId)->first();
        }
        if (!$lang) {
            abort(404);
        }
        $data['lang_id'] = $lang->id;
        $data['header'] = UserHeader::where('language_id', $lang->id)->where('user_id', $userId)->first();

        return view('user.header.index', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'header_text' => 'nullable|max:1000',
            'header_middle_text' => 'nullable|max:255',
            'icon' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        
        $bs = UserHeader::where('language_id', $langid)->where('user_id', Auth::guard('web')->user()->id)->first();
        if ($bs == NULL) {
            $bs = new UserHeader();
            $bs->language_id = $langid;
            $bs->user_id = Auth::guard('web')->user()->id;
            $bs->save();
        }
        $bs->header_text = $request->header_text;
        $bs->header_middle_text = $request->header_middle_text;
        $bs->header_logo = $request->icon;
        $bs->save();
        Session::flash('success', __('Updated Successfully'));
        return 'success';
    }
}
