<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdministratorController;

Route::controller(LoginController::class)
    ->group(function(){
        Route::get('/','index')
            ->name('home');
        
        Route::post('/login','login')
            ->name('login');
        
        Route::get('/destroy','destroy')
            ->name('logout');  
});

Route::controller(AdministratorController::class)
    ->middleware('SessionExpired')
    ->group(function(){
        Route::get('/index','index')
            ->name('index');
        
        Route::get('/assistanceHik','assistanceHik')
            ->name('assistanceHik'); 
        
        Route::get('/assistanceFS','assistanceFS')
            ->name('assistanceFS'); 
});
