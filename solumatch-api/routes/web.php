<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/teste-email', function () {
    Mail::raw('Este é um e-mail de teste via SMTP Gmail', function ($message) {
        $message->to('allanmaiagondim.rng@gmail.com')
                ->subject('Teste de E-mail');
    });

    return 'E-mail enviado (se tudo estiver certo).';
});
