<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserRole;
use App\Models\User\UserStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class StaffController extends Controller
{
    public function index()
    {
        $merchantId = Auth::guard('web')->user()->id;
        $data['staffs'] = UserStaff::with('role')->where('user_id', $merchantId)->get();
        $data['roles'] = UserRole::where('user_id', $merchantId)->get();
        return view('user.staff.index', $data);
    }

    public function create()
    {
        $merchantId = Auth::guard('web')->user()->id;
        $data['roles'] = UserRole::where('user_id', $merchantId)->get();
        return view('user.staff.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:255|unique:user_staff,username|unique:users,username',
            'email' => 'required|email|max:255|unique:user_staff,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:user_roles,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $merchantId = Auth::guard('web')->user()->id;

        $staff = new UserStaff();
        $staff->user_id = $merchantId;
        $staff->role_id = $request->role_id;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->username = $request->username;
        $staff->email = $request->email;
        $staff->password = Hash::make($request->password);
        $staff->phone = $request->phone;
        $staff->status = 1;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/front/img/user/'), $imageName);
            $staff->image = $imageName;
        }

        $staff->save();

        Session::flash('success', __('Staff Member Created Successfully'));
        return response()->json(['status' => 'success'], 200);
    }

    public function edit($id)
    {
        $merchantId = Auth::guard('web')->user()->id;
        $data['staff'] = UserStaff::where('user_id', $merchantId)->where('id', $id)->firstOrFail();
        $data['roles'] = UserRole::where('user_id', $merchantId)->get();
        return view('user.staff.edit', $data);
    }

    public function update(Request $request)
    {
        $merchantId = Auth::guard('web')->user()->id;
        $staff = UserStaff::where('user_id', $merchantId)->where('id', $request->staff_id)->firstOrFail();

        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:255|unique:user_staff,username,' . $staff->id . '|unique:users,username',
            'email' => 'required|email|max:255|unique:user_staff,email,' . $staff->id,
            'role_id' => 'required|exists:user_roles,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $staff->role_id = $request->role_id;
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->username = $request->username;
        $staff->email = $request->email;
        $staff->phone = $request->phone;

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            @unlink(public_path('assets/front/img/user/' . $staff->image));
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/front/img/user/'), $imageName);
            $staff->image = $imageName;
        }

        $staff->save();

        Session::flash('success', __('Staff Member Updated Successfully'));
        return response()->json(['status' => 'success'], 200);
    }

    public function status(Request $request)
    {
        $merchantId = Auth::guard('web')->user()->id;
        $staff = UserStaff::where('user_id', $merchantId)->where('id', $request->staff_id)->firstOrFail();
        $staff->status = $request->status;
        $staff->save();

        Session::flash('success', __('Staff Status Updated Successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $merchantId = Auth::guard('web')->user()->id;
        $staff = UserStaff::where('user_id', $merchantId)->where('id', $request->staff_id)->firstOrFail();
        @unlink(public_path('assets/front/img/user/' . $staff->image));
        $staff->delete();

        Session::flash('success', __('Staff Member Deleted Successfully'));
        return back();
    }
}
