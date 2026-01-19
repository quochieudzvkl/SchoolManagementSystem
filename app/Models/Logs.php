<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table =['auth_logs'];
    protected $fillable = [
        'user_id',
        'role',
        'action',
        'ip_address',
        'user_agent',
        'is_success',
        'note',
    ];
}
