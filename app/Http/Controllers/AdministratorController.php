<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index(){
        $ruta = '';

        return view('admin.index', compact('ruta'));
    }

    public function assistanceHik(){
        return 'Lista Hik';
    }

    public function assistanceFS(){
        return 'Lista FS';
    }
}
