<?php

use App\Models\Medicamento;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmarSoliController;



Route::post('/ConfirmarRetirada', [ConfirmarSoliController::class, 'confirmar'])
->name('api.confirmarRetirada');
