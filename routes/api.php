<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', function () {
    return Post::all();
})->middleware('auth:api');

//solo los clientes autorizados
Route::get('/client/posts', function () {
    return Post::all();
})->middleware('client');

//solo los clientes autorizados
Route::post('/client/posts', function (Request $request) {
    Post::create([
        'title' => $request -> input('title'),
        'body'  => $request -> input('body')
    ]);
    return ['status' => 200];
})->middleware('client');


Route::get('/posts-all', [App\Http\Controllers\PostController::class, 'index']);


//definir metodos para los clientes
Route::group(['middleware' => 'client'], function () {
    Route::post('/logout', [App\Http\Controllers\PostController::class, 'logout']);    
});