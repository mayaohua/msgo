<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $fillable = [
        'kui_content', 'kui_openid', 'kui_from' ,'kui_user','kui_contact','kui_file'
    ];
    protected $hidden = [
         'updated_at',
    ];
}