<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /*--------------------------------------------------------------
    | CAMPOS GRAVÁVEIS (mass assignment)
    |--------------------------------------------------------------*/
    protected $fillable = [
        'name',
        'email',
        'password',

        // campos extras que você adicionou à tabela users
        'tipo_usuario',   // ex.: 'profissional', 'empresa'
        'cpf',
        'cnpj',
        'numero',         // telefone armazenado aqui
        'endereco',
        'cep',
        'sobre_mim',
    ];

    /*--------------------------------------------------------------
    | CAMPOS OCULTOS nas respostas JSON
    |--------------------------------------------------------------*/
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*--------------------------------------------------------------
    | CASTS automáticos de tipos
    |--------------------------------------------------------------*/
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*--------------------------------------------------------------
    | MUTATORS / ACCESSORS
    |--------------------------------------------------------------*/
    /**
     * Armazena sempre a senha criptografada.
     */
   public function setPasswordAttribute($value)
{
    if ( \Illuminate\Support\Str::startsWith($value, '$2y$') ) {
        // Já é um hash bcrypt, salva direto
        $this->attributes['password'] = $value;
    } else {
        // Senha em texto plano, faz o hash
        $this->attributes['password'] = bcrypt($value);
    }
}

}
