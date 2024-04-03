<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SmsTemp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SmsTempController extends Controller
{
    public function index($uid = null)
    {
        if (!empty($uid)) {
            $smstemp = User::where('uid', '=', $uid)->first();
            $user = $smstemp->id;
        } else {
            $user = auth()->user()->id;
        }
        $smstemp = SmsTemp::where('id_user', '=', $user)->get();

        return response()->json([
            'status' => true,
            'data' => $smstemp,
            'message' => "Sms_Template Successfully Get.",
        ]);
    }

    public function show($id)
    {
        $smstemp = SmsTemp::find($id);
        
        return response()->json([
            'status' => true,
            'data' => $smstemp,
            'message' => "Sms_Template Successfully Get.",
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'template' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }

        $smstemp = new SmsTemp();
        $smstemp->name = $request->name;
        $smstemp->template = $request->template;
        $smstemp->characters = strlen($request->template);
        $smstemp->id_user = \Auth::user()->id;
        $smstemp->created_by = \Auth::user()->created_by;
        $smstemp->save();

        return response()->json([
            'status' => true,
            'data' => $smstemp,
            'message' => "Sms_Template Successfully Created.",
        ]);
    }
    public function update(Request $request, $id)
    {

        $smstemp = SmsTemp::find($id);


        $rules = [
            'name' => 'required',
            'template' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }

        $smstemp->name = $request->name;
        $smstemp->template = $request->template;
        $smstemp->characters = strlen($request->template);
        $smstemp->save();

        return response()->json([
            'status' => true,
            'data' => $smstemp,
            'message' => "Sms_Template Successfully updated.",
        ]);
    }
    public function delete($id)
    {
        $smstemp = SmsTemp::find($id);
        if (!empty($smstemp)) {
            $smstemp->delete();
            return response()->json([
                'status' => true,
                'message' => "Sms_Template Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Sms_Template not found.",
            ], 500);
        }
    }
}
