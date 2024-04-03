<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead_script;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LeadScriptController extends Controller
{
    public function index($uid = null)
    {
        if (!empty($uid)) {
            $lead_script = User::where('uid', '=', $uid)->first();
            $user = $lead_script->id;
        } else {
            $user = auth()->user()->id;
        }
        $lead_scripts = Lead_script::where('id_user', '=', $user)->get();
        return response()->json([
            'status' => true,
            'data' => $lead_scripts,
            'message' => "Lead Script Successfully Get.",
        ]);
    }

    public function show($id)
    {
        $lead_scripts = Lead_script::find($id);
        
        return response()->json([
            'status' => true,
            'data' => $lead_scripts,
            'message' => "Lead Script Successfully Get.",
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'script' => 'required',
            'script_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                'status' => true,
                'message' => "All fields are required.",
                'error' => $messages,
            ], 500);
        }
        $lead_scripts              = new Lead_script();
        $lead_scripts->script_name = $request->script_name;
        $lead_scripts->script      = $request->script;
        $lead_scripts->desc        = $request->script_name;
        $lead_scripts->id_user     = \Auth::user()->id;
        $lead_scripts->created_by  = \Auth::user()->created_by;
        $lead_scripts->save();

        return response()->json([
            'status' => true,
            'data' => $lead_scripts,
            'message' => "Lead Script Successfully Created.",
        ]);
    }

    public function update(Request $request, $id)
    {
        $lead_scripts = Lead_script::find($id);

        if (!empty($lead_scripts)) {
            $rules = [
                'script' => 'required',
                'script_name' => 'required',

            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return response()->json([
                    'status' => true,
                    'message' => "All fields are required.",
                    'error' => $messages,
                ]);
            }

            $lead_scripts->script_name = $request->script_name;
            $lead_scripts->script      = $request->script;
            $lead_scripts->desc        = $request->script_name;
            $lead_scripts->save();

            return response()->json([
                'status' => true,
                'data' => $lead_scripts,
                'message' => "Lead Script Successfully updated.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Lead Script id not found",
            ], 500);
        }
    }

    public function delete($id)
    {
        $lead_scripts = Lead_script::find($id);
        if (!empty($lead_scripts)) {
            $lead_scripts->delete();

            return response()->json([
                'status' => true,
                'message' => "Lead Script Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Lead Script id not found.",
            ], 500);
        }
    }
}
