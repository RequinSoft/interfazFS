<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadHik extends Model
{
    
    protected $connection = 'hik';

    protected $table = 'hik';

    protected $fillable = [
        'id',
        'datetime',
        'date',
        'time',
        'device',
        'name',
        'accessgroup',
    ];
}
