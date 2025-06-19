<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar quais origens têm permissão para fazer requisições
    | para a sua API. Use '*' para permitir todas, mas para o nosso caso com
    | credenciais, precisamos ser específicos.
    |
    */

    'allowed_origins' => [
        'http://localhost:5173', // <-- ADICIONE O ENDEREÇO DO SEU FRONTEND AQUI
    ],

    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'allowed_methods' => ['*'],

    // --- GARANTA QUE ESTA LINHA ESTEJA COMO 'true' ---
    'supports_credentials' => true,

    // ... resto do arquivo
];