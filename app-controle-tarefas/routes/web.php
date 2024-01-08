<?php

use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Mail;
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
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

// Route::middleware('verified')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); redirect pelo provider(RouteServiceProvider)
Route::get('tarefa/exportacao/{extensao}', 'App\Http\Controllers\TarefaController@exportacao')->name('tarefa.exportacao');
Route::get('tarefa/exportar', 'App\Http\Controllers\TarefaController@exportar')->name('tarefa.exportar');
Route::middleware('verified')->resource('tarefa', 'App\Http\Controllers\TarefaController');

Route::get('/mensagem-teste', function(){
    return new MensagemTesteMail();
    // Mail::to('vportugalgames@outlook.com')->send(new MensagemTesteMail()); //pode ser testado via Tinker
    // return 'E-mail enviado com sucesso!';
});
