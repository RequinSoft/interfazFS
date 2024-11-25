<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Assistance;
use App\Models\ReadHik;

class AdministratorController extends Controller
{
    public function index(){
        $ruta = '';
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');

        if($hora >= '00:00:00' && $hora < '07:00:00'){
            $fecha->subDay(1);
            $dia = $fecha->format('Y-m-d');
        }else{
            $dia = $fecha->format('Y-m-d');
        }

        $contarHik = Assistance::query()->where('date', $dia)->distinct('ID')->count();

        return view('admin.index', compact('ruta', 'user', 'contarHik'));
    }

    public function assistanceHik(){
        $ruta = '';
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');


        if($hora >= '00:00:00' && $hora < '07:00:00'){
            $fecha->subDay(1);
            $dia = $fecha->format('Y-m-d');
        }else{
            $dia = $fecha->format('Y-m-d');
        }

        $asistencia = Assistance::query()->where('date', $dia)->orderBy('time', 'asc')->get();
        $cuenta = $asistencia->count();

        return view('admin.asistenciaHik', compact('ruta', 'asistencia', 'cuenta', 'user'));
    }

    public function assistanceFS(){
        $fecha = Carbon::now();
        $dia = $fecha->format('Y-m-d');

        return Socialite::driver('fatigue')->redirect();
    }

    public function syncAssistance(){

        $fecha = Carbon::now();

        //$hora_actual = $fecha->format('H:i:s');

        $dia = $fecha->format('Y-m-d');

        $deviceIn = [
            '10.74.25.3',
            '10.74.25.4',
            '10.74.25.7',
            '10.74.25.8',
            '10.74.25.9',
            '10.74.25.67'
        ];
        
        $assistanceHik = ReadHik::query()->where('date', '=', $dia)->whereIn('device', $deviceIn)->get();

        foreach($assistanceHik as $assis){

            $verificarRegistro = Assistance::query()->where('id_hik', $assis->ID)->where('date', '=', $dia)->count();

            if($verificarRegistro == 0){
                $createLocal = Assistance::create([
                    'id_hik' => $assis->ID,
                    'datetime' => $assis->datetime,
                    'date' => $assis->date,
                    'time' => $assis->time,
                    'name' => $assis->Name,
                    'accessgroup' => $assis->AccessGroup,
                    'device' => $assis->device,
                ]);
            }
        }
        
        return redirect()->route('index');
    }
}
