<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ldap extends Model
{
    
    protected $table = 'ldap';

    protected $fillable = [
        'id',
        'servers',
        'port',
        'user',
        'password',
    ];
}
