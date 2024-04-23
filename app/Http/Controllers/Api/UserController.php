<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getuser($uid = null)
    {
        if (!empty($uid)) {
            $user = $uid;
        } else {
            $user = auth()->user()->uid;
        }
        $user_details = User::where('uid', '=', $user)->first();

        return response()->json([
            'status' => true,
            'data' => $user_details,
            'message' => "Successfully get user details."
        ]);
        // return new UserResource($user_details);

    }

    public function getallusers()
    {
        $user = auth()->user()->id;
        $user_details = User::where('created_by', '=', $user)->get();
        return response()->json([
            'status' => true,
            'data' => $user_details,
            'message' => "Successfully get user details."
        ]);
    }
    public function update(Request $request, $uid)
    {
        $user = User::where('uid', '=', $uid)->first();
        if (!empty($user)) {

            $user->first_name  = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email   = $request->email;
            $user->date_of_birth   = $request->dob;
            $user->contact_no   = $request->contact_no;
            $user->address1  = $request->address1;
            $user->post_code  = $request->post_code;
            $user->country   = $request->country;
            $user->state   = $request->state;
            $user->city   = $request->city;
            $user->save();

            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => "Successfully user update."
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "User Not found."
            ], 500);
        }
    }
    public function updatePassword(Request $request)
    {
        if (Auth::Check()) {
            $request->validate(
                [
                    'old_password' => 'required',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );

            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;

            if (Hash::check($request_data['old_password'], $current_password)) {

                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);
                $obj_user->save();

                return response()->json([
                    'status' => true,
                    'message' => "Password successfully updated.",
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => "Please enter current password.",
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'message' => "Something is wrong.",
            ]);
        }
    }
    public function delete($uid)
    {
        $user = User::where('uid', '=', $uid)->first();

        if (auth()->user()->role == 'MANAGER' || auth()->user()->role == 'ADMIN') {
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => "Successfully user Delete."
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Permission denied"
            ]);
        }
    }
}
