<?php
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido');
});
Route::get('/producto',[ ProductoController::class,'index']); 
Route::post('/producto/registrar',[ ProductoController::class,'store']); //Registrar
Route::put('/producto/actualizar',[ ProductoController::class,'update']);//Actualizar
Route::put('/producto/desactivar',[ ProductoController::class,'desactivar']); //Desactivar
Route::put('/producto/activar',[ ProductoController::class,'activar']); //Activar
