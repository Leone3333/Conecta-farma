<?php

use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\ConfirmarSoliController;
use App\Http\Controllers\SolicitarRetiController;
use App\Http\Controllers\SolicitarRetiradaController;

Route::get('/', function () {return view('welcome');});

// Módolo de usuarios
Route::get('/solicitar', function () {
    return view('solicitarRetirada')->with('medicamentos',Medicamento::all());
});
Route::post('/solicitar',[SolicitarRetiradaController::class, 'solicitar']);


Route::get('/ProcurarUbs', function () {return view('ProcurarUbs');});

Route::get('/confirmar-retirada', function () {return view('confirmarRetirada');});

Route::post('/postoEscolhido', [ConfirmarSoliController::class, 'solicitarRetirada']);
// Se encontra em api.php
// Route::post('/ConfirmarRetirada', [ConfirmarSoliController::class, 'confirmar']);    


// Módulo de funcionários
Route::get('/login', function () {return view('index');});
Route::post('/login', [AcessoController::class, 'login']);
// Route::get('/codigoRetirada', function () {return view('codigoRetirada');})->name('codigos');