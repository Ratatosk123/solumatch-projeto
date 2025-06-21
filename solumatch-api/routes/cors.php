<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Define para quais caminhos da sua API as regras de CORS serão aplicadas.
    | 'api/*' significa que todas as rotas que começam com /api (como /api/register)
    | serão afetadas por esta configuração.
    |
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Define quais métodos HTTP são permitidos (GET, POST, PUT, etc.).
    | O asterisco '*' permite todos os métodos.
    |
    */
    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | A PARTE MAIS IMPORTANTE. É a "lista VIP" de endereços que podem
    | fazer requisições para sua API. Como seu frontend Vue roda em
    | http://localhost:5173, nós precisamos adicionar este endereço aqui.
    |
    */
    'allowed_origins' => [
        'http://localhost:5173',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Você pode usar expressões regulares para permitir múltiplas origens,
    | mas para nosso caso, a lista acima é mais segura e suficiente.
    |
    */
    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Define quais cabeçalhos podem ser enviados na requisição.
    | O asterisco '*' permite todos os cabeçalhos comuns.
    |
    */
    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Define quais cabeçalhos o frontend terá permissão para ler na resposta.
    | Para nosso caso, não precisamos de nenhum especial.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Define por quanto tempo o navegador pode manter em cache as respostas
    | de preflight (verificação de CORS).
    |
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | A SEGUNDA PARTE MAIS IMPORTANTE. Como nosso frontend precisa enviar
    | credenciais (tokens de sessão/API para login), esta opção precisa
    | ser 'true'. É por isso que 'allowed_origins' não pode ser '*'.
    |
    */
    'supports_credentials' => true,

];