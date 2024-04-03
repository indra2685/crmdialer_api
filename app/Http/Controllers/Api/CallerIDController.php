<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Caller_ID;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CallerIDController extends Controller
{
    public function index($uid = null)
    {
        if (!empty($uid)) {
            $caller = User::where('uid', '=', $uid)->first();
            $user = $caller->id;
        } else {
            $user = auth()->user()->id;
        }
        $caller_id = Caller_ID::where('user_id', '=', $user)->get();

        return response()->json([
            'status' => true,
            'data' => $caller_id,
            'message' => "caller_id Successfully Get.",
        ]);
    }
    public function show($id)
    {
        $caller = Caller_ID::find($id);
        if (!empty($caller)) {
            return response()->json([
                'status' => true,
                'data' => $caller,
                'message' => "Caller_id Successfully Get.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Caller_id not found.",
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $rules = [
            'number' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }

        $caller = new Caller_ID();
        $caller->number = $request->number;
        $caller->country_code = @$request->country_code;
        $caller->country_name = @$request->country_name;
        $caller->area_code = @$request->area_code;
        $caller->status = "Success";
        $caller->assign_to = auth()->user()->id;
        $caller->user_id = auth()->user()->id;
        $caller->save();

        return response()->json([
            'status' => true,
            'data' => $caller,
            'message' => "Caller_id Successfully Created.",
        ]);
    }
    public function update(Request $request, $id)
    {
        $caller = Caller_ID::find($id);
        if (!empty($caller)) {
            $rules = [
                'number' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return response()->json([
                    "success" => false,
                    "message" => "All field required.$messages",
                ]);
            }

            $caller->number = $request->number;
            $caller->country_code = @$request->country_code;
            $caller->country_name = @$request->country_name;
            $caller->area_code = @$request->area_code;
            $caller->status = "Success";
            $caller->assign_to = auth()->user()->id;
            $caller->user_id = auth()->user()->id;
            $caller->save();

            return response()->json([
                'status' => true,
                'data' => $caller,
                'message' => "Caller_id Successfully Updated.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Caller_id not found.",
            ], 500);
        }
    }
    public function delete($id)
    {
        $caller = Caller_ID::find($id);
        if (!empty($caller)) {
            $caller->delete();
            return response()->json([
                'status' => true,
                'message' => "Caller_id Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Caller_id not found.",
            ], 500);
        }
    }
}
