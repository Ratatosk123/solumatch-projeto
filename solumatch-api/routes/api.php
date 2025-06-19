<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controladores da API
|--------------------------------------------------------------------------
|
| Aqui importamos todos os controllers que serão usados nas rotas.
| Manter isso organizado ajuda na manutenção do projeto.
|
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ChatController;


/*
|--------------------------------------------------------------------------
| Rotas da API
|--------------------------------------------------------------------------
|
| Todas as rotas definidas aqui são automaticamente prefixadas com '/api'.
| Por exemplo, a rota '/login' se torna '/api/login'.
|
*/

// --- ROTAS PÚBLICAS ---
// Rotas que não exigem que o usuário esteja logado.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Futuramente, poderíamos adicionar aqui a rota de "esqueci minha senha".
// Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);


// --- ROTAS PROTEGIDAS ---
// Rotas que só podem ser acessadas por usuários autenticados via Sanctum.
// O middleware 'auth:sanctum' cuida da verificação do token de acesso.
Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticação
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        // Rota simples para obter os dados do usuário logado.
        // Útil para o frontend verificar quem é o usuário atual.
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas de Vagas (Jobs)
    |--------------------------------------------------------------------------
    |
    | Usamos um 'apiResource' para as vagas. Esta é uma forma muito poderosa
    | e limpa que o Laravel oferece para criar todas as rotas padrão para um "recurso".
    | Ele automaticamente cria as rotas para listar, criar, ver, atualizar e deletar vagas.
    |
    */
    Route::apiResource('vagas', VagaController::class);
    // O comando acima é um atalho para criar as seguintes rotas:
    // GET       /api/vagas               -> VagaController@index   (Listar todas as vagas)
    // POST      /api/vagas               -> VagaController@store   (Salvar uma nova vaga)
    // GET       /api/vagas/{vaga}        -> VagaController@show    (Mostrar uma vaga específica)
    // PUT/PATCH /api/vagas/{vaga}        -> VagaController@update  (Atualizar uma vaga específica)
    // DELETE    /api/vagas/{vaga}        -> VagaController@destroy (Deletar uma vaga específica)

    /*
    |--------------------------------------------------------------------------
    | Rotas de Perfil de Usuário
    |--------------------------------------------------------------------------
    */
    // (Ainda vamos criar o PerfilController)
    // Route::get('/perfil', [PerfilController::class, 'show']);       // Ver o próprio perfil
    // Route::put('/perfil', [PerfilController::class, 'update']);      // Atualizar o próprio perfil
    // Route::get('/perfil/{id}', [PerfilController::class, 'showById']); // Ver o perfil de outro usuário

    /*
    |--------------------------------------------------------------------------
    | Rotas de Chat / Mensagens
    |--------------------------------------------------------------------------
    */
    // (Ainda vamos criar o ChatController)
    // Route::get('/conversations', [ChatController::class, 'index']);
    // Route::get('/conversations/{userId}', [ChatController::class, 'show']);
    // Route::post('/messages', [ChatController::class, 'store']);

});