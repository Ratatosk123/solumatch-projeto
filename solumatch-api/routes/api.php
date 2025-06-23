<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Este arquivo define as rotas da sua API.
|
*/

/**
 * Rota padrão do Laravel para buscar dados de um usuário autenticado.
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * ROTA DE CADASTRO COMPLETA E CORRIGIDA (POST /api/register)
 * -----------------------------------------------------------------------
 * Utiliza 'nome' para alinhar com o frontend e o banco de dados.
 */
Route::post('/register', function (Request $request) {
    
    // Valida os dados recebidos, esperando um campo 'nome'.
    $request->validate([
        'nome' => 'required|string|max:255', // Corrigido para 'nome'
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    // Cria o usuário, inserindo o dado na coluna 'nome'.
    $user = User::create([
        'nome' => $request->nome, // Corrigido para 'nome'
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Retorna a resposta de sucesso.
    return response()->json([
        'status' => 'success',
        'message' => 'Usuário criado com sucesso!',
        'user' => $user
    ], 201);
});