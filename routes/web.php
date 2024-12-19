<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\RelatorioController;


//Livros
Route::resource('livros', LivroController::class);
//No load da aplicação, redireciona para lista livro
Route::get('/', [LivroController::class, 'index'])->name('livros.index');

//autores
Route::resource('autores', AutorController::class);

//Assunto
Route::resource('assuntos', AssuntoController::class);

//Relatorio Livro
Route::get('/relatorios/livros', [RelatorioController::class, 'livros'])
    ->name('relatorios.livros');

Route::get('/relatorios/por-assunto/{assunto}', [RelatorioController::class, 'porAssunto'])
    ->name('relatorios.assunto');

Route::get('/relatorios/por-autor/{autor}', [RelatorioController::class, 'porAutor'])
    ->name('relatorios.autor');
