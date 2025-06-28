<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Aqui pode configurar as suas definições para partilha de recursos
    | de origem cruzada (CORS).
    |
    */

    // Define os caminhos que usarão estas regras de CORS. 'api/*' cobre toda a sua API.
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Define os métodos HTTP permitidos. '*' significa todos (POST, GET, PUT, etc).
    'allowed_methods' => ['*'],

    // ATENÇÃO: Define os endereços que podem aceder à sua API.
    // Adicionamos o endereço do seu frontend Vue.js.
    'allowed_origins' => ['http://localhost:5173'],

    // Permite que origens com padrões específicos (wildcards) acedam. Não precisamos por agora.
    'allowed_origins_patterns' => [],

    // Define os cabeçalhos que o frontend pode enviar na requisição. '*' permite todos.
    'allowed_headers' => ['*'],

    // Define cabeçalhos que o frontend pode ler na resposta.
    'exposed_headers' => [],

    // Tempo (em segundos) que o resultado da requisição "preflight" pode ser guardado em cache.
    'max_age' => 0,

    // ESSENCIAL: Permite que o frontend envie credenciais (cookies, tokens) com as requisições.
    'supports_credentials' => true,

];