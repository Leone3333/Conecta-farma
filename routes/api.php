<?php

use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;
use App\Http\Controllers\ConfirmarSoliController;
use App\Http\Controllers\SolicitarRetiController;


Route::post('/ConfirmarRetirada', [ConfirmarSoliController::class, 'confirmar']);
