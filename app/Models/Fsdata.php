<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fsdata extends Model
{    
    protected $table = 'fstoken';

    protected $fillable = [
        'id',
        'username',
        'password',
        'grand_type',
        'access_token',
        'token_type',
        'expires_in',
        'refresh_token',
        'grand_type_refresh_token',
    ];
}
