<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;

Route::get('/', function () {return view('welcome');});

Route::get('/solicitar', function () {return view('solicitarRetirada');});
Route::get('/ProcurarUbs', function () {return view('ProcurarUbs');});
Route::get('/ConfirmarRetirada', function () {return view('confirmarRetirada');});


Route::get('/login', function () {return view('index');});
Route::post('/login', [AcessoController::class, 'login']);
