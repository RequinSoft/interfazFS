<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cuadrilleros extends Model
{
    protected $table = 'cuadrilleros';
    
    protected $fillable = [
        'name',
        'work_role',
        'work_place',
        'sdn',
        'RFC',
        'cel',
        'active',
    ];
    
    public function asistioCuadrillero(){
        $fecha = Carbon::now();
        $today = $fecha->format('Y-m-d');

        return $this->belongsTo(Assistance::class, 'RFC', 'id_hik')->where('date', $today);
    }
}
