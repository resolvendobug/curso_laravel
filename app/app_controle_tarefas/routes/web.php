<?php

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
    //return view('welcome');
    return view('bem-vindo');
});

Auth::routes();

Route::get('/tarefa/exportacao/{extensao}',[App\Http\Controllers\TarefaController::class,'exportacao'])->name('tarefa.exportacao');

Route::get('/tarefa/exportacao/',[App\Http\Controllers\TarefaController::class,'exportar'])->name('tarefa.exportar');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('tarefa','App\Http\Controllers\TarefaController');

