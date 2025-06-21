<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nome', 'email', 'password', 'tipo_usuario', 'cpf', 'cnpj',
        'numero', 'endereco', 'cep', 'sobre_mim',
        'profile_picture', 'profile_picture_type'
    ];

    protected $hidden = [
        'password', 'remember_token', 'profile_picture'
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class);
    }
}