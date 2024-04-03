<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialer_leads extends Model
{
    use HasFactory;
    protected $table = 'tbl_leads';
    protected $fillable = [
        'uid',
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'age',
        'street_address_1',
        'city',
        'state',
        'county',
        'zip',
        'phone',
        'cell_phone',
        'status',
        'lead_type',
        'created_by'
    ];
}
