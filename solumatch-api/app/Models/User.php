<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Corrigido para corresponder à coluna do banco de dados
        'email',
        'password',
        'tipo_usuario',
        'cpf',
        'cnpj',
        'numero',
        'endereco',
        'cep',
        'sobre_mim',
        'profile_picture',
        'profile_picture_type'
    ];

    /**
     * Os atributos que devem ser ocultados nas serializações.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define o relacionamento onde um Usuário pode ter muitas Vagas.
     * (Assumindo que você tem um modelo Vaga)
     */
    public function vagas()
    {
        // Se você não tiver um modelo Vaga, pode comentar ou remover esta função.
        // return $this->hasMany(Vaga::class);
    }
}
