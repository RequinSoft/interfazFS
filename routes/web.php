<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdministratorController;

Route::controller(LoginController::class)
    ->group(function(){
        Route::get('/','index')
            ->name('index');
        
        Route::post('/login','login')
            ->name('login');
        
        Route::get('/destroy','destroy')
            ->name('destroy');  
});

Route::controller(AdministratorController::class)
    ->group(function(){
        Route::get('/indexAsistencia','indexAsistencia')
            ->name('indexAsistencia');
        
        Route::get('/indexFS','indexFS')
            ->name('indexFS'); 
});
