<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Assistance;
use App\Models\ReadHik;
use App\Models\Fsdata;
use App\Models\Locations;
use App\Models\Personal;
use App\Models\Ldap;

class AdministratorController extends Controller
{
    public function index(){
        $ruta = '';
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');
        $system = ['SYSTEM', 'System', 'system'];

        if($hora >= '00:00:00' && $hora < '07:00:00'){
            $fecha->subDay(1);
            $dia = $fecha->format('Y-m-d');
        }else{
            $dia = $fecha->format('Y-m-d');
        }

        $contarHik = Assistance::query()->where('date', $dia)->distinct('ID')->count();
        $contarFS = Personal::query()->whereNotIn('identifier', $system)->count();
        $asistenciaReloj = Assistance::query()->where('date', $dia)->where('exist_fs', 1)->distinct('ID')->count();

        return view('admin.index', compact('ruta', 'user', 'contarHik', 'contarFS', 'asistenciaReloj'));
    }

    public function assistanceHik(){
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

        return view('admin.asistenciaHik', compact('asistencia', 'cuenta', 'user'));
    }

    public function assistanceFS(){
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');
        $system = ['SYSTEM', 'System', 'system'];

        $responseUsers = Personal::with('exist_fs')->whereNotIn('identifier', $system)->get();

        //return $responseUsers;
        return view('admin.asistenciaFS', compact('responseUsers', 'user'));
    }

    public function users(){
        $user = Auth::user();
        $usuarios = [];

        return view('admin.usuarios', compact('usuarios', 'user'));
    }

    public function locations(){
        $ruta = '';
        $user = Auth::user();

        $locations = Locations::query()->where('id_fs', '<>', 3226)->orderBy('name', 'asc')->get();

        return view('admin.locations', compact('ruta', 'user', 'locations'));
    }

    public function getDataFS(){
        $fecha = Carbon::now();

        $dataFS = Fsdata::find(1);

        if(!isset($dataFS->username) || !isset($dataFS->password)){
            return back()->withErrors([
                'message' => 'Usuario y Contraseña son obligatorios',
            ]);
        }

        if(isset($dataFS->access_token)){
            $dataToGetToken = [
                "username" => $dataFS->username,
                "password" => $dataFS->password,
                "grant_type" => 'refresh_token',
                "refresh_token" => $dataFS->refresh_token
            ];
            $responseDataToken = Http::post('https://app.fatiguescience.com/oauth/token', $dataToGetToken);
            
            $updateFSData = Fsdata::query()->where('id', 1)->update([
                'access_token' => $responseDataToken['access_token'],
                'token_type' => $responseDataToken['token_type'],
                'expires_in' => $responseDataToken['expires_in'],
                'refresh_token' => $responseDataToken['refresh_token'],
                'created' => $responseDataToken['created_at'],
                'first_login' => $responseDataToken['first_login'],
            ]);
        }else{
            $dataToGetToken = [
                "username" => $dataFS->username,
                "password" => $dataFS->password,
                "grant_type" => $dataFS->grand_type
            ];
            $responseDataToken = Http::post('https://app.fatiguescience.com/oauth/token', $dataToGetToken);
            //return $responseDataToken;
            $updateFSData = Fsdata::query()->where('id', 1)->update([
                'access_token' => $responseDataToken['access_token'],
                'token_type' => $responseDataToken['token_type'],
                'expires_in' => $responseDataToken['expires_in'],
                'refresh_token' => $responseDataToken['refresh_token'],
                'created' => $responseDataToken['created_at'],
                'first_login' => $responseDataToken['first_login'],
            ]);
        }

        return redirect()->route('fsdata');
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

    public function fsdata(){
        $ruta = '';
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');
        $hoy = $fecha->valueOf();

        $fsdata = Fsdata::find(1);

        return view('admin.fsdata', compact('ruta', 'fsdata', 'user', 'hoy'));
    }

    public function fsdata_edit(){
        
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');

        $fsdata = FsData::find(1);

        return view('admin.fsdata-edit', compact('fsdata', 'user'));
    }

    public function fsdata_update(Request $request){
        //Reglas de los campos 
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],
        [
            'username.required' => 'El email es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]); 
        $fsdata = Fsdata::updateOrCreate(
            ['id' => 1],
            [
                'username' => $request->username,
                'password' => $request->password,
                'grand_type' => 'password'
            ]
        );

        return redirect()->route('fsdata');
    }

    public function ldap(){
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');
        $hoy = $fecha->valueOf();

        $ldap = Ldap::find(1);

        return view('admin.ldap', compact('ldap', 'user', 'hoy'));
    }

    public function editLdap(){
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');

        $ldap = Ldap::find(1);

        return view('admin.ldap-edit', compact('ldap', 'user'));        
    }

    public function updateLdap(Request $request){
        //Reglas de los campos 
        $validated = $request->validate([
            'servers' => 'required',
            'port' => 'required',
            'user' => 'required',
            'password' => 'required',
        ],
        [
            'servers.required' => 'El servidor es obligatorio',
            'port.required' => 'El puerto es obligatorio',
            'user.required' => 'El usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]); 
        
        $ldap = Ldap::updateOrCreate(
            ['id' => 1],
            [
                'servers' => $request->servers,
                'port' => $request->port,
                'user' => $request->user,
                'password' => $request->password,
            ]
        );
        
        return redirect()->route('ldap');
    }

    public function testLdap(Request $request){
        
        return 'Test';
    }
}
