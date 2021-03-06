<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

/*
 * Métodos HTTP
 * 
 * GET: Conseguir datos o recursos
 * POST: Guardar datos o recursos, como lógica
 * PUT: Actualizar recursos o datos
 * DELETE: Eliminar datos o recursos
 * 
 */

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/register',[UserController::class,'register']);
Route::post('api/login',[UserController::class,'login']);
ROute::post('api/client/update', [UserController::class, 'update']);