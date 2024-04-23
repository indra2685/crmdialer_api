<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;


class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (Auth::check()) {
            if (auth()->user()->role == 'MANAGER' || auth()->user()->role == 'ADMIN') {
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                ]);

                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors());
                }
                $rand = strtolower(Str::random(10));
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                if(auth()->user()->role == 'ADMIN'){
                    $input['role'] = 'MANAGER';

                    
                } else {
                    $input['role'] = 'AGENT';
                }
                $input['uid'] = Uuid::uuid4()->toString();
                $input['username'] = "dialer_" . $rand;
                $input['created_by'] = auth()->user()->id;
                $input['status'] = 1;
                $user = User::create($input);
                // $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                // $success['name'] =  $user->name;

                // return $this->sendResponse($success, 'User register successfully.');

                return response()->json([
                    'status' => true,
                    "data" => $user,
                    'message' => "User register successfully.",
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => "Agent Not allow",
                ], 500);
            }
        } else {
            return response()->json([
                'status' => true,
                'message' => "Unauthorised",
            ], 500);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (!empty($request->username)) {
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                // $success['name'] =  $user->first_name . " " . $user->last_name;

                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        }
        // if (!empty($request->username)) {
        //     if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        //         $user = Auth::user();
        //         $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        //         $success['name'] =  $user->first_name . " " . $user->last_name;

        //         return $this->sendResponse($success, 'User login successfully.');
        //     } else {
        //         return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        //     }
        // }
    }
}
