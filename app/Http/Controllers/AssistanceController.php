<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Assistance;
use App\Models\ReadHik;
use Carbon\Carbon;
use DateTime;

class AssistanceController extends Controller
{    
    public function index(){
        $fecha = Carbon::now();
        $assistencia = [];
        $hora = $fecha->format('H:i:s');


        if($hora >= '00:00:00' && $hora < '07:00:00'){
            $fecha->subDay(1);
            $dia = $fecha->format('Y-m-d');
        }else{
            $dia = $fecha->format('Y-m-d');
        }

        $assistencia = Assistance::query()->where('date', $dia)->orderBy('time')->get();
        $cuenta = $assistencia->count();

        return view('dashboard', compact('assistencia', 'cuenta'));
    }

    public function indexFS(){
        $fecha = Carbon::now();
        $assistencia = [];
        $hora = $fecha->format('H:i:s');


        if($hora >= '00:00:00' && $hora < '07:00:00'){
            $fecha->subDay(1);
            $dia = $fecha->format('Y-m-d');
        }else{
            $dia = $fecha->format('Y-m-d');
        }

        $assistencia = Assistance::query()->where('date', $dia)->where('exist_fs', 1)->orderBy('time')->get();
        $cuenta = $assistencia->count();

        return view('dashboardFS', compact('assistencia', 'cuenta'));
    }

    public function syncAssistance(){
        $fecha = Carbon::now();
        $lugar = 'default';

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
            if($assis->device == '10.74.25.3' || $assis->device == '10.74.25.4' || $assis->device == '10.74.25.7'){
                $lugar = 'Juanicipio';
            }else if($assis->device == '10.74.25.8' || $assis->device == '10.74.25.9' || $assis->device == '10.74.25.67'){
                $lugar = 'Valle';
            }

            if($verificarRegistro == 0){
                $createLocal = Assistance::create([
                    'id_hik' => $assis->ID,
                    'datetime' => $assis->datetime,
                    'date' => $assis->date,
                    'time' => $assis->time,
                    'name' => $assis->Name,
                    'accessgroup' => $assis->AccessGroup,
                    'device' => $assis->device,
                    'ingreso' => $lugar,
                ]);
            }
        }
        
        return redirect()->route('dashboard')->with('msg', $msg);
    }

    public function syncFS(){
        $fecha = Carbon::now();
        $dia = $fecha->format('Y-m-d');
        $client_id = '4e8764057ab419a88324fbdcbdbaeadda2cef2a8fa8ad9caf73f3d05486e6f4f';
        $client_secret = 'dd4fa6e9e45857d1ff57db8580bacdc8f6128561a4fbbc3dee47f15e67bbb8f5';
        $authCode = '';

        // Obtenemos las asistencias del día que no ha sido sincronizadas a FS, también obtenemos la cantidad de registros.
        $sync = Assistance::query()->where('sync', 0)->where('date', $dia)->get();
        $sync_count = $sync->count();
        //git add .return $sync_count;

        //Realizamos la petición a la API de FS para obtener código de autorización.
        $responseClientId = Http::get('https://app.fatiguescience.com/oauth/authorize?response_type=code&client_id={'.$client_id.'}4.&scope=E&redirect_uri={'.$client_secret.'}');
        return $responseClientId;

        //Realizamos una petición a la API de FS 
        $dataToSync = [
            "grand_type" => 'authorization_code',
            "servidor" => $responseClientId['code']
        ];
        $responseAuthCode = Http::post('https://app.fatiguescience.com/oauth/token', $dataToSync);
        $authCode = $responseAuthCode['access_token'];
        return $responseAuthCode;
        return $authCode;
    }
}
