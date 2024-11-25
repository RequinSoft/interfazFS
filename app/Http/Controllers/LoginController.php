<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;


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
        //return $userdb;
        
        if($userdb->count() == 0){
            return back()->withErrors([
                'message' => '¡Verifica tu usuario!',
            ]);
        }

        if(auth()->attempt(request(['user', 'password'])) == false){
            return back()->withErrors([
                'message' => 'El Usuario y/o la Contraseña son incorrectos',
            ]);
        }else{
            return redirect()->route('index');
        }
    }

    public function destroy(Request $request){
        //Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
