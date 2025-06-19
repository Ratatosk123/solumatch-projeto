<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'titulo', 'descricao', 'requisitos', 'categoria', 
        'tipo_contratacao', 'localizacao', 'salario', 'tipo_orcamento'
    ];

    // Relacionamento: Uma vaga pertence a uma empresa (que é um Usuário)
    public function empresa()
    {
        // Renomeamos para 'empresa' para clareza no código
        return $this->belongsTo(User::class, 'user_id');
    }
}