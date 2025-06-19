<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Especifique quais origens têm permissão para fazer requisições.
    | Para o nosso caso com credenciais, precisamos ser específicos.
    |
    */

    'allowed_origins' => [
        // AQUI ESTÁ A LINHA MAIS IMPORTANTE:
        // Nós permitimos explicitamente que o seu frontend faça requisições.
        'http://localhost:5173',
    ],

    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,

    // A SEGUNDA LINHA MAIS IMPORTANTE:
    // Precisamos permitir o envio de credenciais (necessário para login/sessão).
    'supports_credentials' => true,

];