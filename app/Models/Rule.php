<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'ze_name', 'ze_order', 'ze_rule','ze_status'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
