<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Label;
use App\Models\User\Language;
use Auth;
use Illuminate\Http\Request;
use Session;
use Validator;

class ItemLabelController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $langCode = $request->language;
        $language = null;
        if (!empty($langCode)) {
            $language = Language::where([['user_id', $user_id], ['code', $langCode]])->first();
        }
        if (empty($language)) {
            $language = Language::where([['user_id', $user_id], ['is_default', 1]])->first() 
                ?? Language::where('user_id', $user_id)->first();
        }
        $data['userLanguages'] = Language::where('user_id', $user_id)->get();
        $data['labels'] = $language 
            ? Label::where([['user_id', $user_id], ['language_id', $language->id]])->orderBy('created_at','DESC')->get()
            : collect([]);
        $data['user_id'] = $user_id;
        return view('user.item.label.index', $data);
    }

    public function store(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        if (!$request->filled('user_language_id')) {
            $defaultLang = Language::where([['user_id', $user_id], ['is_default', 1]])->first()
                ?? Language::where('user_id', $user_id)->first();
            if ($defaultLang) {
                $request->merge(['user_language_id' => $defaultLang->id]);
            }
        }
        $rules = [
            'user_language_id' => 'required',
            'name' => 'required',
            'color' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $in = $request->all();
        $in['language_id'] = $request->user_language_id;
        $in['user_id'] = $user_id;
        Label::create($in);
        Session::flash('success', __('Created successfully'));
        return 'success';
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'color' => 'required',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $data = Label::findOrFail($request->id);
        $input = $request->all();
        $data->update($input);

        Session::flash('success', __('Updated Successfully'));
        return "success";
    }

    public function delete(Request $request)
    {
        $label = Label::findOrFail($request->label_id);
        $label->delete();

        Session::flash('success', __('Deleted successfully'));
        return back();
    }
}
