<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcessoController;

Route::get('/', function () {return view('welcome');});


Route::get('/login', function () {return view('index');});
Route::post('/login', [AcessoController::class, 'login']);
