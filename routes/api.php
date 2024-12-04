<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;

// Rota de cadastro
Route::post('/register', [AuthController::class, 'register']);

// Rota de login
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas por autenticação
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/account', [AccountController::class, 'getAccount']); // Exibir uma conta específica
    Route::get('/accounts', [AccountController::class, 'index']); // Listar todas as contas do usuário
    Route::post('/accounts/{account}/deposit', [AccountController::class, 'deposit']); // Realizar depósito
    Route::get('/accounts/{account}/balance', [AccountController::class, 'balance']); // Consultar saldo
    Route::post('/accounts/apply-correction', [AccountController::class, 'applyMonthlyCorrection']); // Correção monetária
    Route::post('/accounts', [AccountController::class, 'store']); // Cria conta
});

Route::get('/test-get', function () {
    return response()->json(['message' => 'Rota GET funcionando!']);
});
