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

        Route::get('/users','users')
            ->name('users');

        Route::get('/addUsers','addUsers')
            ->name('addUsers');

        Route::post('/storageUsers','storageUsers')
            ->name('storageUsers');

        Route::get('/editUsers/{id}','editUsers')
            ->name('editUsers');

        Route::post('/updateUsers','updateUsers')
            ->name('updateUsers');

        Route::get('/passwords/{id}','passwords')
            ->name('passwords');

        Route::post('/updatePasswords','updatePasswords')
            ->name('updatePasswords');

        Route::get('/deleteUsers/{id}','deleteUsers')
            ->name('deleteUsers');

        Route::get('/activateUsers/{id}','activateUsers')
            ->name('activateUsers');

        Route::get('/cuadrilleros','cuadrilleros')
            ->name('cuadrilleros');

        Route::get('/addCuadrilleros','addCuadrilleros')
        ->name('addCuadrilleros');

        Route::post('/storageCuadrilleros','storageCuadrilleros')
            ->name('storageCuadrilleros');

        Route::get('/editCuadrilleros/{id}','editCuadrilleros')
            ->name('editCuadrilleros');

        Route::post('/updateCuadrilleros','updateCuadrilleros')
            ->name('updateCuadrilleros');

        Route::get('/deleteCuadrilleros/{id}','deleteCuadrilleros')
            ->name('deleteCuadrilleros');

        Route::get('/activateCuadrilleros/{id}','activateCuadrilleros')
            ->name('activateCuadrilleros');

        Route::get('/locations','locations')
            ->name('locations');
        
        Route::get('/assistanceHik','assistanceHik')
            ->name('assistanceHik'); 
        
        Route::get('/assistanceFS','assistanceFS')
            ->name('assistanceFS');
        
        Route::get('/getDataFS','getDataFS')
            ->name('getDataFS'); 
    
        Route::get('/FSData','fsdata')
            ->name('fsdata'); 
    
        Route::get('/FSDataEdit','fsdata_edit')
            ->name('fsdata-edit'); 
    
        Route::post('/FSDataUpdate','fsdata_update')
            ->name('fsdata-update'); 
        
        Route::get('/ldap','ldap')
            ->name('ldap');
        
        Route::get('/editLdap','editLdap')
            ->name('editLdap');
        
        Route::post('/updateLdap','updateLdap')
            ->name('updateLdap');
        
        Route::get('/testLdap','testLdap')
            ->name('testLdap');
});
