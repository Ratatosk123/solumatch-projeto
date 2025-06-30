<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir o driver de hash padrão que será utilizado.
    | Laravel suporta "bcrypt" e "argon".
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir o custo do Bcrypt. Quanto maior, mais seguro,
    | mas também mais lento.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Se você usar Argon (ou Argon2id), pode configurar aqui as opções.
    |
    */

    'argon' => [
        'memory' => 65536,
        'threads' => 1,
        'time' => 4,
    ],

    /*
    |--------------------------------------------------------------------------
    | Verify Algorithm Compatibility
    |--------------------------------------------------------------------------
    |
    | Laravel 11 introduziu esta opção para garantir que o hash salvo use
    | o mesmo algoritmo configurado. Caso contrário, uma exceção será lançada.
    |
    | Defina como "false" em .env com HASH_VERIFY=false para permitir transição.
    |
    */

    'verify' => env('HASH_VERIFY', true),

];
