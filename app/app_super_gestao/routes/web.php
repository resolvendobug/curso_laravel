<?php

use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PrincipalController::class,'principal']);

Route::get('/sobre-nos',[SobreNosController::class,'sobreNos']);

Route::get('/contato', [ContatoController::class,'contato']);

Route::get('/contato/{nome}/{opcional}' , function(string $nome,int $id) { 
    echo 'Estamos aqui:'.$nome.' - '.$id;
})->where('opcional','[0-9]+')->where('nome','[A-Za-z]+');
