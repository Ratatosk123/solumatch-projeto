<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra quaisquer serviços da aplicação.
     *
     * Este método é usado para vincular coisas ao container de serviços do Laravel.
     */
    public function register(): void
    {
        // Deixe vazio por enquanto.
    }

    /**
     * Inicializa quaisquer serviços da aplicação.
     *
     * Este método é chamado depois que todos os outros 'providers'
     * foram registrados. É aqui que você pode interagir com o framework,
     * registrar 'listeners' de eventos, rotas, etc.
     */
    public function boot(): void
    {
        // Deixe vazio por enquanto.
    }
}