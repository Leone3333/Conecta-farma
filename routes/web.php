<?php

use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\ConfirmarSoliController;
use App\Http\Controllers\SolicitarRetiradaController;
use App\Http\Controllers\SelecionaRetiradaController;
use App\Http\Controllers\AutorizarRetiradaController;
use App\Http\Controllers\AdicionarMediController;


// Módolo de usuarios
Route::get('/', function () {
    return view('solicitarRetirada')->with('medicamentos',Medicamento::all());
});
Route::post('/solicitar',[SolicitarRetiradaController::class, 'solicitar']);
// Route::get('/ProcurarUbs', function () {return view('ProcurarUbs');});


Route::get('/confirmar-retirada', function () {return view('confirmarRetirada');});

Route::post('/postoEscolhido', [ConfirmarSoliController::class, 'selecionaPosto']);
// Se encontra em api.php
// Route::post('/ConfirmarRetirada', [ConfirmarSoliController::class, 'confirmar']);    


// Módulo de funcionários
Route::get('/login', function () {return view('index');});
Route::post('/login', [AcessoController::class, 'login']);
Route::get('/selecionarRetirada',[AcessoController::class, 'login']);

Route::post('/selecionarRetirada',[SelecionaRetiradaController::class, 'dataRetirada']);
Route::post('/autorizar',[AutorizarRetiradaController::class, 'updateRetirada']);
Route::post('/adicionar',[AdicionarMediController::class, 'add']);
Route::get('/retiradas', [AutorizarRetiradaController::class, 'listaRetiradas'])->name('retiradas.index');
