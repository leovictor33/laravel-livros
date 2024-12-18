<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\RelatorioController;

//Livros
Route::get('/', [LivroController::class, 'index'])->name('livros.index');
Route::resource('livros', LivroController::class);

//autores
Route::resource('autores', AutorController::class);

//Assunto
Route::resource('assuntos', AssuntoController::class);

//Relatorio Livro

Route::get('/relatorios/livros', [RelatorioController::class, 'livros'])
    ->name('relatorios.livros');

Route::get('/relatorio/livros/por-assunto/{assuntoId}', [RelatorioController::class, 'gerarRelatorioPorAssunto'])
    ->name('assuntos.relatorio');

Route::get('autores/{autor}/relatorio', [LivroController::class, 'gerarRelatorioLivrosPorAutor'])
    ->name('autores.relatorio');

