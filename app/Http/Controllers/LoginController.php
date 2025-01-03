<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ldap;


class LoginController extends Controller
{
    public function index(){
        $ruta = '';

        return view('welcome', compact('ruta'));
    }

    public function login(Request $request){
        ///Reglas de los campos 
        $validated = $request->validate([
            'user' => 'required',
            'password' => 'required',
        ],
        [
            'user' => 'El usuario es obligatorio',
            'password' => 'La contraseña es obligatoria',
        ]);  

        $hoy = Carbon::now();
        
        $usuario = request()->user;
        $userdb = User::query()->where('user', $usuario)->get();
        $ldap = Ldap::find(1);

        $ldap_user = $request->user.'@'.$ldap->domain;
        $ldap_pass =  $request->password;
        //return $ldap->port;
        
        // Validamos que el usuario exista en la DB
        // Si no existe volvemos a la página de Login con mensaje de error
        if($userdb->count() == 0){
            return back()->withErrors([
                'message' => '¡Verifica tu usuario!',
            ]);
        }
        // Si existe continuamos las validaciones
        else{
            // Si el usuario está desactivado
            if($userdb[0]->active == 0){
                return back()->withErrors([
                    'message' => 'El Usuario está desactivado, contacte al Administrador del Sistema',
                ]);
            }else{
                // Si el método de autenticación es 1 (Local) comparamos usuarios y contraseña con la DB
                if($userdb[0]->authen == 1){
                    if(auth()->attempt(request(['user', 'password'])) == false){
                        return back()->withErrors([
                            'message' => 'El Usuario y/o la Contraseña son incorrectos',
                        ]);
                    }else{
                        return redirect()->route('index');
                    }
                }
                // Si el método de autenticación es 2 (LDAP) preguntasmos al LDAP
                else{
                    $ldap_conn = ldap_connect($ldap->servers, $ldap->port);
                    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
                    ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);
    
                    if(@ldap_bind($ldap_conn, $ldap_user, $ldap_pass)){
                        //return 'Funciona LDAP';
                        $update_pass = User::query()->where(['id' => $userdb[0]->id])->update(['password' => bcrypt($request->password)]);
    
                        if(auth()->attempt(request(['user', 'password'])) == false){
                            return back()->withErrors([
                                'message' => 'El Usuario y/o la Contraseña son incorrectos',
                            ]);
                        }else{
                            return redirect()->route('index');
                        }
                    }
                }
            }
        }
        

        
    }

    public function destroy(Request $request){
        //Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
