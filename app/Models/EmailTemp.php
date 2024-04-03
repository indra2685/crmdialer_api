<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemp extends Model
{
    use HasFactory;
    protected $table = 'tbl_email_template';
    protected $fillable = [
        'id_user',
        'name',
        'template',
        'type',
        'fid',
        'created_by'
    ];
}
