<?php

use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\TesteController;
use App\Http\Middleware\LogAcessoMiddleware;

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
Route::middleware(LogAcessoMiddleware::class)
    ->get('/', [PrincipalController::class,'principal'])
    ->name('site.index');

Route::get('/sobre-nos',[SobreNosController::class,'sobreNos'])->name('site.sobrenos');

Route::get('/contato', [ContatoController::class,'contato'])->name('site.contato');
Route::post('/contato', [ContatoController::class,'salvar'])->name('site.contato');

Route::get('/login', function() { return 'Login'; })->name('site.login');

Route::get('/contato/{nome}/{opcional}' , function(string $nome,int $id) { 
    echo 'Estamos aqui:'.$nome.' - '.$id;
})->where('opcional','[0-9]+')->where('nome','[A-Za-z]+');


Route::prefix('/app')->group( function(){
    
    Route::get('/clientes', function() { return 'clientes'; })->name('app.clientes');
    Route::get('/fornecedores',[FornecedorController::class,'index'])->name('app.fornecedores');
    Route::get('/produtos', function() { return 'produtos'; })->name('app.produtos');

});

Route::get('/teste/{p1}/{p2}' , [TesteController::class,'teste'])->name('teste');

// Route::get('/rota1' , function() {
//     echo 'rota1';
// })->name('site.rota1');
// Route::get('/rota2', function() {
//     return redirect()->route('site.rota1');
// })->name('site.rota2');

//Route::redirect('/rota2' , '/rota1');



Route::fallback(function() {
    echo "A rota acessada nao existe. <a href='".route('site.index')."' >clique aqui</a>";
});