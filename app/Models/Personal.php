<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Personal extends Model
{
    protected $table = 'personal';
    
    protected $fillable = [
        'id_fs',
        'name',
        'identifier',
        'email',
    ];

    public function exist_fs(){
        $fecha = Carbon::now();
        $today = $fecha->format('Y-m-d');

        return $this->belongsTo(Assistance::class, 'identifier', 'id_hik')->where('date', $today);
    }
}
