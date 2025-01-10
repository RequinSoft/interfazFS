<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\Assistance;
use App\Models\ReadHik;
use App\Models\Fsdata;
use App\Models\Locations;
use App\Models\Personal;
use App\Models\Ldap;
use App\Models\User;
use App\Models\Cuadrilleros;

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
        $usuarios = User::all();
        $contador = 1;

        return view('admin.users.usuarios', compact('usuarios', 'user', 'contador'));
    }

    public function passwords($id){        
        $user = Auth::user();
        $usuario = User::find($id);

        return view('admin.users.passwords', compact('usuario', 'user'));
    }
    
    public function updatePasswords(Request $request){
        

        $validated = $request->validate(
            [
                'password' => 'required|min:12',
                'password1' => 'required|min:12',
                'password1' => 'same:password',
            ],
            [
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe ser de 12 caracteres mínimo',
                'password.same' => 'Las contraseñas no coinciden',
                'password1.same' => 'Las contraseñas no coinciden',
            ]
        );

        $usuario = User::find($request->id);
        $id = $request->id;
        $updatePassword = User::query()->where(['id' => $id])->update([
            'password' => bcrypt($request->password),
        ]); 
        
        $msg_pass = 'Se actualizó la contraseña del usuario '.$usuario->user;

        return  redirect()->route('users')->with('msg_pass', $msg_pass);
    }

    public function addUsers(){
        $user = Auth::user();

        return view('admin.users.addUsers', compact('user'));
    }

    public function storageUsers(Request $request){

        $validated = $request->validate(
            [
                'user' => 'required|unique:users',
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:12',
                'password1' => 'required|same:password',
            ],
            [
                'user.required' => 'El usuario es obligatorio',
                'user.unique' => 'Usuario Duplicado',
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es obligatorio',
                'email.unique' => 'El email ya está en uso',
                'password.required' => 'La contraseña es obligatoria',
                'password1.required' => 'La validación de la contraseña es obligatoria',
                'password1.same' => 'Las contraseñas deben de coincidir',
                'password.min' => 'La contraseña debe ser de 12 caracteres mínimo',
            ]
        );

        $user = User::create([
            'user' => $request->user,
            'name' => $request->name,
            'password' => $request->password,
            'rol' => $request->rol,
            'authen' => $request->authen,
            'email' => $request->email,
            'active' => 1,
        ]);

        $msg_addUser = 'Se creó el usuario '.$user->user;

        return redirect()->route('users')->with('msg_pass', $msg_addUser);
    }

    public function editUsers($id){
        $user = Auth::user();
        $usuario = User::find($id);

        return view('admin.users.editUsers', compact('user', 'usuario'));
    }

    public function updateUsers(Request $request){

        $validated = $request->validate(
            [
                'user' => [
                        'required',
                        Rule::unique('users')->ignore($request->id),
                ],
                'name' => 'required',
                'email' => [
                        'required',
                        Rule::unique('users')->ignore($request->id),
                ],
            ],
            [
                'user.required' => 'El usuario es obligatorio',
                'user.unique' => 'Usuario Duplicado',
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es obligatorio',
                'email.unique' => 'El email ya está en uso',
            ]
        );

        $usuario = User::where('id', $request->id)->update([
            'user' => $request->user,
            'name' => $request->name,
            'rol' => $request->rol,
            'authen' => $request->authen,
            'email' => $request->email,
            'active' => 1,
        ]);

        return redirect()->route('users');
    }

    public function deleteUsers($id){

        $updateUsuario = User::where('id', $id)->update([
            'active' => 0,
        ]);

        $usuario = User::find($id);
        $msg_deactive = 'Se desactivó el usuario '.$usuario->user;
        
        return redirect()->route('users')->with('msg_deactive', $msg_deactive);
    }

    public function activateUsers($id){

        $updateUsuario = User::where('id', $id)->update([
            'active' => 1,
        ]);
        
        $usuario = User::find($id);
        $msg_active = 'Se activó el usuario '.$usuario->user;

        return redirect()->route('users')->with('msg_active', $msg_active);
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

        return view('admin.ldap.ldap', compact('ldap', 'user', 'hoy'));
    }

    public function editLdap(){
        $user = Auth::user();
        $fecha = Carbon::now();
        $hora = $fecha->format('H:i:s');

        $ldap = Ldap::find(1);

        return view('admin.ldap.ldap-edit', compact('ldap', 'user'));        
    }

    public function updateLdap(Request $request){
        //Reglas de los campos 
        $validated = $request->validate([
            'servers' => 'required',
            'port' => 'required',
            'user' => 'required',
            'password' => 'required',
            'domain' => 'required',
        ],
        [
            'servers.required' => 'El servidor es obligatorio',
            'port.required' => 'El puerto es obligatorio',
            'user.required' => 'El usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'domain.required' => 'El dominio es obligatorio',
        ]); 
        
        $ldap = Ldap::updateOrCreate(
            ['id' => 1],
            [
                'servers' => $request->servers,
                'port' => $request->port,
                'user' => $request->user,
                'password' => $request->password,
                'domain' => $request->domain,
            ]
        );
        
        $msg = '¡La configuración se editó exitosamente!';
        return redirect()->route('ldap')->with('updatedLDAP', $msg);
    }

    public function testLdap(Request $request){
        
        $ldap = Ldap::find(1);
        $ldap_user = $ldap->user.'@'.$ldap->domain;

        $ldap_conn = ldap_connect($ldap->servers, $ldap->port);
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        if(@ldap_bind($ldap_conn, $ldap_user, $ldap->password)){
            $msg = '¡La conexión es exitosa!';
            return redirect()->route('ldap')->with('successLDAP', $msg);
        }else{
            $msg = '¡La conexión no se pudo realizar!';
            return redirect()->route('ldap')->with('failureLDAP', $msg);
        }
    }

    /***************************************************** */
    /***************************************************** */
    /*************************** Cuadrilleros ************ */ 

    public function cuadrilleros(){
        $user = Auth::user();
        $cuadrilleros = Cuadrilleros::with('asistioCuadrillero')->get();
        $contador = 1;
        
        return view('admin.cuadrilleros.cuadrilleros', compact('cuadrilleros', 'user', 'contador'));
    }

    public function addCuadrilleros(){
        $user = Auth::user();

        return view('admin.cuadrilleros.addCuadrilleros', compact('user'));
    }

    public function storageCuadrilleros(Request $request){
        
        $validated = $request->validate(
            [
                'name' => 'required',
                'sdn' => 'required',
                'RFC' => 'required|min:13|max:13|unique:cuadrilleros',
            ],
            [
                'name.required' => 'El nombre es obligatorio',
                'sdn.required' => 'El SDN es obligatorio',
                'RFC.required' => 'El RFC es obligatorio',
                'RFC.min' => 'El RFC debe tener 13 dígitos',
                'RFC.max' => 'El RFC debe tener 13 dígitos',
                'RFC.unique' => 'El RFC ya existe',
            ]
        );

        $user = Cuadrilleros::create([
            'name' => $request->name,
            'sdn' => $request->sdn,
            'work_role' => $request->work_role,
            'work_place' => $request->work_place,
            'RFC' => $request->RFC,
            'active' => 1,
        ]);

        $msg_addUser = 'Se creó el usuario '.$user->name;

        return redirect()->route('cuadrilleros')->with('msg_addUser', $msg_addUser);
    }

    public function editCuadrilleros($id){
        $user = Auth::user();
        $cuadrillero = Cuadrilleros::find($id);

        return view('admin.cuadrilleros.editCuadrilleros', compact('user', 'cuadrillero'));
    }

    public function updateCuadrilleros(Request $request){

        $validated = $request->validate(
            [
                'RFC' => [
                        'required',
                        Rule::unique('cuadrilleros')->ignore($request->id),
                ],
                'name' => 'required',
            ],
            [
                'name.required' => 'El nombre es obligatorio',
                'RFC.required' => 'El RFC es obligatorio',
                'RFC.unique' => 'El RFC ya está en uso',
            ]
        );


        $usuario = Cuadrilleros::where('id', $request->id)->update([
            'name' => $request->name,
            'work_role' => $request->work_role,
            'work_place' => $request->work_place,
            'sdn' => $request->sdn,
            'RFC' => $request->RFC,
            'active' => 1,
        ]);
        $cuadrillero = Cuadrilleros::find($request->id);

        $msg_editUser = 'Se editó el usuario '.$cuadrillero->name;
        return redirect()->route('cuadrilleros')->with('msg_editUser', $msg_editUser);
    }

    public function deleteCuadrilleros($id){

        $updateUsuario = Cuadrilleros::where('id', $id)->update([
            'active' => 0,
        ]);

        $usuario = Cuadrilleros::find($id);
        $msg_deactive = 'Se desactivó el usuario '.$usuario->user;
        
        return redirect()->route('cuadrilleros')->with('msg_deactive', $msg_deactive);
    }

    public function activateCuadrilleros($id){

        $updateUsuario = Cuadrilleros::where('id', $id)->update([
            'active' => 1,
        ]);
        
        $usuario = Cuadrilleros::find($id);
        $msg_active = 'Se activó el usuario '.$usuario->user;

        return redirect()->route('cuadrilleros')->with('msg_active', $msg_active);
    }
    /***************************************************** */
    /***************************************************** */
    /*************************** Cuadrilleros ************ */ 
}
