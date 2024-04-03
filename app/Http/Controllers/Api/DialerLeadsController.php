<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dialer_leads;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Imports\LeadImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class DialerLeadsController extends Controller
{
    public function index($uid = null)
    {
        if (!empty($uid)) {
            $email_temp = User::where('uid', '=', $uid)->first();
            $user = $email_temp->id;
        } else {
            $user = auth()->user()->id;
        }
        $leads = Dialer_leads::where('user_id', '=', $user)->get();

        return response()->json([
            'status' => true,
            'data' => $leads,
            'message' => "Leads Successfully Get.",
        ]);
    }

    public function show($id)
    {
        $leads = Dialer_leads::find($id);

        return response()->json([
            'status' => true,
            'data' => $leads,
            'message' => "Lead Successfully Get.",
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'email' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }
        $uid = uniqid() . "_1";

        $leads = new Dialer_leads();
        $leads->uid = $uid;
        $leads->first_name = $request->first_name;
        $leads->last_name = $request->last_name;
        $leads->birth_date = $request->birth_date;
        $leads->email = $request->email;
        $leads->street_address_1 = $request->address;
        $leads->city = $request->city;
        $leads->state = $request->state;
        $leads->county = $request->county;
        $leads->zip = $request->zip;
        $leads->phone = $request->phone;
        $leads->status = "New Lead";
        $leads->lead_type = $request->lead_type;
        $leads->cell_phone = $request->cell_phone;
        $leads->user_id = \Auth::user()->id;
        $leads->created_by = \Auth::user()->created_by;
        $leads->save();

        return response()->json([
            'status' => true,
            'data' => $leads,
            'message' => "Lead Successfully Created.",
        ]);
    }
    public function excelimport(Request $request)
    {
        $rules = [
            'file' => 'required|file|mimes:csv'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }

        if ($request->hasFile('file')) {
            try {
                $uid = uniqid();
                $request_data['uid'] = $uid;
                Excel::import(new LeadImport($uid, $request), $request->file);
                return ['status' => true, 'message' => 'Lead uploaded successfully'];
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        } else {
            throw new Exception('No file uploaded');
        }
    }
    public function update(Request $request, $id)
    {

        $leads = Dialer_leads::find($id);

        $rules = [
            'first_name' => 'required',
            'email' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                "success" => false,
                "message" => "All field required.$messages",
            ]);
        }

        $leads->first_name = $request->first_name;
        $leads->last_name = $request->last_name;
        $leads->birth_date = $request->birth_date;
        $leads->email = $request->email;
        $leads->street_address_1 = $request->address;
        $leads->city = $request->city;
        $leads->state = $request->state;
        $leads->county = $request->county;
        $leads->zip = $request->zip;
        $leads->phone = $request->phone;
        $leads->lead_type = $request->lead_type;
        $leads->cell_phone = $request->cell_phone;
        $leads->save();

        return response()->json([
            'status' => true,
            'data' => $leads,
            'message' => "Lead Successfully updated.",
        ]);
    }
    public function delete($id)
    {
        $leads = Dialer_leads::find($id);
        if (!empty($leads)) {
            $leads->delete();
            return response()->json([
                'status' => true,
                'message' => "Lead Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Lead not found.",
            ], 500);
        }
    }
    public function delete_leades(Request $request)
    {
        $user_id = $request->ids;
        if (!empty($user_id)) {
            foreach($user_id as $id) {
                $leads = Dialer_leads::where('id' ,'=',$id)->first();
                if (!empty($leads)) {
                    $leads->delete();
                }
            }
            return response()->json([
                'status' => true,
                'message' => "Lead Successfully deleted.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Array is empty.",
            ], 500);
        }
    }
}
