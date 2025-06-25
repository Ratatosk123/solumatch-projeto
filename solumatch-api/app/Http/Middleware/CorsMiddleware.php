<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Executa a requisição primeiro para obter a resposta
        $response = $next($request);

        // Adiciona os cabeçalhos de CORS à resposta
        // Permite que o seu frontend (localhost:5173) aceda à API
        $response->header('Access-Control-Allow-Origin', 'http://localhost:5173');
        
        // Permite métodos HTTP comuns
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        
        // Permite cabeçalhos comuns em requisições, como o de autorização
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        return $response;
    }
}