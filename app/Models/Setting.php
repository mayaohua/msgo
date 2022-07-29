<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'value', 'key'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
