<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\TesteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProdutoDetalheController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoProdutoController;

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
Route::get('/', [PrincipalController::class,'principal'])
    ->name('site.index');

Route::get('/sobre-nos',[SobreNosController::class,'sobreNos'])->name('site.sobrenos');

Route::get('/contato', [ContatoController::class,'contato'])->name('site.contato');
Route::post('/contato', [ContatoController::class,'salvar'])->name('site.contato');

Route::get('/login/{erro?}', [LoginController::class,'index'])->name('site.login');
Route::post('/login', [LoginController::class,'autenticar'])->name('site.login');

Route::get('/contato/{nome}/{opcional}' , function(string $nome,int $id) { 
    echo 'Estamos aqui:'.$nome.' - '.$id;
})->where('opcional','[0-9]+')->where('nome','[A-Za-z]+');


Route::middleware('autenticacao:padrao,visitante')->prefix('/app')->group( function(){
    Route::get('/home', [HomeController::class , 'index'] )->name('app.home');
    Route::get('/sair', [LoginController::class,'sair'])->name('app.sair');
    
    Route::get('/fornecedor',[FornecedorController::class,'index'])->name('app.fornecedor');
    Route::post('/fornecedor/listar',[FornecedorController::class,'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/listar',[FornecedorController::class,'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/adicionar',[FornecedorController::class,'adicionar'])->name('app.fornecedor.adicionar');
    Route::post('/fornecedor/adicionar',[FornecedorController::class,'adicionar'])->name('app.fornecedor.adicionar');
    Route::get('/fornecedor/editar/{id}',[FornecedorController::class,'editar'])->name('app.fornecedor.editar');
    Route::get('/fornecedor/excluir/{id}',[FornecedorController::class,'excluir'])->name('app.fornecedor.excluir');

    Route::get('/produto',[ProdutoController::class,'index'])->name('app.produto');
    Route::resource('produto',ProdutoController::class);
    Route::resource('produto-detalhe',ProdutoDetalheController::class);

    Route::resource('cliente',ClienteController::class);
    Route::resource('pedido',PedidoController::class);
    //Route::resource('pedido-produto',PedidoProdutoController::class);

    Route::get('pedido-produto/create/{pedido}',[PedidoProdutoController::class,'create'])->name('pedido-produto.create');
    Route::post('pedido-produto/store/{pedido}',[PedidoProdutoController::class,'store'])->name('pedido-produto.store');

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