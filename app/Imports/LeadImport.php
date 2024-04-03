<?php

namespace App\Imports;

use App\Http\Requests\LeadCreateRequest;
use Illuminate\Support\Collection;
use App\Models\Dialer_leads;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class LeadImport implements ToCollection, WithHeadingRow
{

    private $uid;
    private $request;

    public function __construct($uid,$request) {
        $this->uid = $uid;
        $this->request = $request;
    }

    public function collection(Collection $rows)
    {
        $index = 0;
        $authUser = Auth::user();

        foreach ($rows as $row)
        {
            $index++;
            
            Dialer_leads::create([
                'uid'               => $this->uid . '_' . $index,
                'user_id'           => $authUser->id,
                'first_name'        => @$row['first_name'],
                'last_name'         => @$row['last_name'],
                'birth_date'        => @$row['dob'],
                'email'             => @$row['email'],
                'street_address_1'  => @$row['address'],
                'city'              => @$row['city'],
                'state'             => @$row['state'],
                'county'            => @$row['county'],
                'zip'               => @$row['zip_code'],
                'phone'             => @$row['mobile'],
                'cell_phone'        => @$row['phone'],
                'status'            => "New Lead",
                'lead_type'            => $this->request->lead_script,
                'created_by'        => $authUser->created_by
            ]);
        }
    }
}
