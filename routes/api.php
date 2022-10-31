<?php

use Illuminate\Support\Facades\Route;

/*
Route::group(['prefix' => 'public'], function () {
    
    //create token
    //Route::post('/getClientCrendentialsGrantToken'  , 'App\Http\Controllers\Auth\FuckingAuthController@getClientCrendentialsGrantToken');
    //Route::post('/getPersonalAccessToken'           , 'App\Http\Controllers\Auth\FuckingAuthController@getPersonalAccessToken');
    
    Route::post('/getPasswordGrantToken'              , [App\Http\Controllers\Auth\FuckingAuthController::class, 'getPasswordGrantToken']);
    Route::post('/getRegister'                        , [App\Http\Controllers\Auth\FuckingAuthController::class, 'getRegister']);
    Route::post('/getLogin'                           , [App\Http\Controllers\Auth\FuckingAuthController::class, 'getLogin']);
    
});

// se definen todos los endpoints de cualquier REST estaran con un middleware de checktoken
Route::group(['prefix' => 'secure/rest', 'middleware' => 'auth:api'], function () {
    
    //administracion de usuario
    Route::get('/obtenerPosts'                        ,[App\Http\Controllers\ClientsResourcesController::class,  'obtenerPosts']);
    
});
//->middleware('auth:api');

Route::group(['prefix' => 'secure/auth', 'middleware' => 'auth:api'], function () {
    Route::post('/getLogout'                          , [App\Http\Controllers\Auth\FuckingAuthController::class, 'getLogout']);
});
*/