<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//MODULE VISITAS
Route::group(['prefix'=>'visitas','as'=>'visitas.'], function(){
    Route::get('/', [App\Http\Controllers\VisitaController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::get('/selects', [App\Http\Controllers\VisitaController::class, 'selects'])->name('selects')->middleware('auth:sanctum');
    
    Route::get('/edit/{id}', [App\Http\Controllers\VisitaController::class, 'edit'])->name('edit')->middleware('auth:sanctum');
    

    //POST

    Route::post('/marcar', [App\Http\Controllers\VisitaController::class, 'marcar'])->name('marcar')->middleware('auth:sanctum');
    Route::post('/create', [App\Http\Controllers\VisitaController::class, 'store'])->name('create')->middleware('auth:sanctum');
    Route::post('/update', [App\Http\Controllers\VisitaController::class, 'update'])->name('update')->middleware('auth:sanctum');
    Route::post('/delete', [App\Http\Controllers\VisitaController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});

//MODULE HERRAMIENTA COMPLEX BY VISITAS
Route::group(['prefix'=>'herramientas','as'=>'herramientas.'], function(){

    //POST
    Route::post('/delete', [App\Http\Controllers\HerramientaController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});
