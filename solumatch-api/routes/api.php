<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Este ficheiro define as rotas da sua API.
|
*/

// ROTA DE USUÁRIO AUTENTICADO
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ===================================================================
// ROTA DE REGISTO - VERSÃO FINAL CORRIGIDA
// ===================================================================
Route::post('/register', function (Request $request) {

    // 1. Validação: Garantimos que o frontend envia 'name' e todos os outros campos.
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', // Validamos o campo 'name'
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'tipo_usuario' => 'nullable|string',
        'cpf' => 'nullable|string|max:14',
        'cnpj' => 'nullable|string|max:18',
        'telefone' => 'nullable|string|max:20',
        'endereco' => 'nullable|string|max:255',
        'cep' => 'nullable|string|max:9',
        'sobre_mim' => 'nullable|string',
    ]);

    // 2. Prepara os dados para a criação.
    // Usamos o array $validatedData, que já contém todos os campos seguros.
    $userData = $validatedData;
    
    // 3. Faz o hash da senha.
    $userData['password'] = Hash::make($request->password);
    
    // 4. Mapeia 'telefone' do frontend para a coluna 'numero' do banco de dados.
    if (isset($userData['telefone'])) {
        $userData['numero'] = $userData['telefone'];
        unset($userData['telefone']); // Remove a chave 'telefone' para não tentar inseri-la no banco.
    }

    // ==========================================================
    // PASSO DE DEPURAÇÃO: Ver o que estamos a enviar para o banco
    // ==========================================================
    // A linha abaixo irá parar o código e mostrar os dados exatos.
    dd($userData);

    // 5. Cria o usuário com o array de dados completo e correto.
    $user = User::create($userData);

    // 6. Retorna a resposta de sucesso.
    return response()->json([
        'status' => 'success',
        'message' => 'Usuário criado com sucesso!',
        'user' => $user
    ], 201);
});


// ===================================================================
// ROTAS PARA O FLUXO DE REDEFINIÇÃO DE SENHA
// ===================================================================
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
