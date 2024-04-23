<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\EmailTemp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class EmailTempController extends Controller
{
    public function index($uid = null)
    {
        if (!empty($uid)) {
            $email_temp = User::where('uid', '=', $uid)->first();
            $user = $email_temp->id;
        } else {
            $user = auth()->user()->id;
        }
        $email_temp = EmailTemp::where('id_user', '=', $user)->get();

        return response()->json([
            'status' => true,
            'data' => $email_temp,
            'message' => "Email_Template Successfully Get.",
        ]);
    }

    public function show($id)
    {
        $email_temp = EmailTemp::find($id);

        return response()->json([
            'status' => true,
            'data' => $email_temp,
            'message' => "Email_Template Successfully Get.",
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

        $email_temp = new EmailTemp();
        $email_temp->name = $request->name;
        $email_temp->template = $request->template;
        $email_temp->type = "other";
        $email_temp->id_user = \Auth::user()->id;
        $email_temp->created_by = \Auth::user()->created_by;
        $email_temp->save();

        return response()->json([
            'status' => true,
            'data' => $email_temp,
            'message' => "Email_Template Successfully Created.",
        ]);
    }
    public function update(Request $request, $id)
    {

        $email_temp = EmailTemp::find($id);


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

        $email_temp->name = $request->name;
        $email_temp->template = $request->template;
        $email_temp->save();

        return response()->json([
            'status' => true,
            'data' => $email_temp,
            'message' => "Email_Template Successfully updated.",
        ]);
    }
    public function delete($id)
    {
        $email_temp = EmailTemp::find($id);
        if (!empty($email_temp)) {
            $email_temp->delete();
            return response()->json([
                'status' => true,
                'message' => "Email_Template Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Email_Template not found.",
            ], 500);
        }
    }
}
