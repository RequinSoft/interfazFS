<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    
    protected $fillable = [
        'id_fs',
        'name',
        'identifier',
        'email',
    ];
}