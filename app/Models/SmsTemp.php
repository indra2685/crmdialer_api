<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemp extends Model
{
    use HasFactory;
    protected $table = 'tbl_sms_template';
    protected $fillable = [
        'id_user',
        'name',
        'template',
        'characters',
        'fid',
        'created_by'
    ];
}
