<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    
    protected $table = 'assistance';

    protected $fillable = [
        'id',
        'id_hik',
        'id_fs',
        'datetime',
        'date',
        'time',
        'device',
        'name',
        'accessgroup',
        'exist_fs',
        'sync',
    ];

    public function sync_data(){

        return $this->belongsTo(Personal::class, 'id_hik', 'identifier');
    }
}
