<?php

use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\SolicitarRetiController;

Route::get('/', function () {return view('welcome');});

// Módolo de usuarios
Route::get('/solicitar', function () {
    return view('solicitarRetirada')->with('medicamentos',Medicamento::all());
});
Route::post('/solicitar',[SolicitarRetiController::class, 'buscaDisponibilidade']);


Route::get('/ProcurarUbs', function () {return view('ProcurarUbs');});
Route::get('/ConfirmarRetirada', function () {return view('confirmarRetirada');});


// Módulo de funcionários
Route::get('/login', function () {return view('index');});
Route::post('/login', [AcessoController::class, 'login']);
Route::get('/codigoRetirada', function () {return view('codigoRetirada');});