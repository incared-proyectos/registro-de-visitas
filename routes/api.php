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



//MODULE PERFIL USUARIO
Route::group(['prefix'=>'perfil','as'=>'perfil.'], function(){
    Route::get('/', [App\Http\Controllers\PerfilController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::post('/save', [App\Http\Controllers\PerfilController::class, 'store'])->name('save')->middleware('auth:sanctum');
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

//MODULE ENTIDAD 
Route::group(['prefix'=>'entidad','as'=>'entidad.'], function(){
    Route::get('/', [App\Http\Controllers\EntidadController::class, 'index'])->name('index')->middleware('auth:sanctum');
    //POST
    Route::post('/save', [App\Http\Controllers\EntidadController::class, 'store'])->name('save')->middleware('auth:sanctum');

    Route::post('/update', [App\Http\Controllers\EntidadController::class, 'update'])->name('update')->middleware('auth:sanctum');

    Route::post('/delete', [App\Http\Controllers\EntidadController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});

//MODULE ROLES 
Route::group(['prefix'=>'rol','as'=>'rol.'], function(){
    Route::get('/', [App\Http\Controllers\RolController::class, 'index'])->name('index')->middleware('auth:sanctum');
    //POST
    Route::post('/save', [App\Http\Controllers\RolController::class, 'store'])->name('save')->middleware('auth:sanctum');

    Route::post('/update', [App\Http\Controllers\RolController::class, 'update'])->name('update')->middleware('auth:sanctum');
});

//MODULE OFICINAS 
Route::group(['prefix'=>'oficinas','as'=>'oficinas.'], function(){
    Route::get('/', [App\Http\Controllers\OficinaController::class, 'index'])->name('index')->middleware('auth:sanctum');
    //POST
    Route::post('/save', [App\Http\Controllers\OficinaController::class, 'store'])->name('save')->middleware('auth:sanctum');

    Route::post('/update', [App\Http\Controllers\OficinaController::class, 'update'])->name('update')->middleware('auth:sanctum');

    Route::post('/delete', [App\Http\Controllers\OficinaController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});

//MODULE MOTIVOS 
Route::group(['prefix'=>'motivos','as'=>'motivos.'], function(){
    Route::get('/', [App\Http\Controllers\MotivoController::class, 'index'])->name('index')->middleware('auth:sanctum');
    //POST
    Route::post('/save', [App\Http\Controllers\MotivoController::class, 'store'])->name('save')->middleware('auth:sanctum');

    Route::post('/update', [App\Http\Controllers\MotivoController::class, 'update'])->name('update')->middleware('auth:sanctum');

    Route::post('/delete', [App\Http\Controllers\MotivoController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});

//MODULE SEDES 
Route::group(['prefix'=>'sedes','as'=>'sedes.'], function(){
    Route::get('/', [App\Http\Controllers\SedeController::class, 'index'])->name('index')->middleware('auth:sanctum');
    //POST
    Route::post('/save', [App\Http\Controllers\SedeController::class, 'store'])->name('save')->middleware('auth:sanctum');

    Route::post('/update', [App\Http\Controllers\SedeController::class, 'update'])->name('update')->middleware('auth:sanctum');

    Route::post('/delete', [App\Http\Controllers\SedeController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});

//MODULE USERS 
Route::group(['prefix'=>'users','as'=>'users.'], function(){

    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::get('/rolesall', [App\Http\Controllers\UserController::class, 'rolesAll'])->name('rolesall')->middleware('auth:sanctum');
    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edituser'])->name('edituser')->middleware('auth:sanctum');

    //POST
    Route::post('/save', [App\Http\Controllers\UserController::class, 'store'])->name('save')->middleware('auth:sanctum');
    Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])->name('update')->middleware('auth:sanctum');
    Route::post('/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete')->middleware('auth:sanctum');

});
