<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user' , function (Request $request){
    return $request->user();    
});
Route::post('/login', [AuthController::class,'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password',  [ForgotPasswordController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * REGISTRO DE USUÁRIO
 * POST /api/register
 */
Route::post('/register', function (Request $request) {

    // Validação de segurança
    $validatedData = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|string|email|max:255|unique:users',
        'password'      => 'required|string|min:8|confirmed', // exige password_confirmation
        'tipo_usuario'  => 'nullable|string',
        'cpf'           => 'nullable|string|max:14|unique:users',
        'cnpj'          => 'nullable|string|max:18|unique:users',
        'telefone'      => 'nullable|string|max:20',
        'endereco'      => 'nullable|string|max:255',
        'cep'           => 'nullable|string|max:9',
        'sobre_mim'     => 'nullable|string',
    ]);

    // Prepara dados para o banco
    $userData = [
        ...$validatedData,
        'password' => Hash::make($validatedData['password']),
        'numero'   => $validatedData['telefone'] ?? null, // telefone vai para a coluna 'numero'
    ];
    unset($userData['telefone']); // remove chave que não existe na tabela

    // Log opcional de depuração
    Log::info('Criando usuário', $userData);

    // Cria o usuário
    $user = User::create($userData);

    // Resposta
    return response()->json([
        'status'  => 'success',
        'message' => 'Usuário criado com sucesso!',
        'user'    => $user,
    ], 201);
});

