<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da sua API. Todas elas
| recebem automaticamente o prefixo /api.
|
*/

/**
 * Rota padrão do Laravel para buscar dados de um usuário autenticado.
 * É uma boa prática mantê-la para o futuro.
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * ROTA PARA O CADASTRO DE USUÁRIO (POST /api/register)
 * -----------------------------------------------------------------------
 * Esta é a rota que o seu frontend está tentando acessar.
 * Sem ela, o Laravel retorna o erro 404 Not Found.
 */
Route::post('/register', function (Request $request) {
    
    // Este código é para o teste final. Ele apenas confirma que a
    // comunicação entre frontend e backend foi um sucesso.
    return response()->json([
        'status' => 'success',
        'message' => 'A ROTA FOI ENCONTRADA! Backend acessado com sucesso!'
    ], 200); // Código 200 significa que a requisição foi bem-sucedida.
}); 