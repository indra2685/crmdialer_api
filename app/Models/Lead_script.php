<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead_script extends Model
{
    use HasFactory;

    protected $table = 'tbl_lead_status';
    protected $fillable = [
        'id_user',
        'script_name ',
        'script',
        'desc',
        'filename',
        'created_by'
    ];

}
