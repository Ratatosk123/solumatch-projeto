<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VagaController extends Controller
{
    /**
     * Lista todas as vagas disponíveis (com paginação e filtro).
     */
    public function index(Request $request)
    {
        $query = Vaga::with('empresa:id,nome')
                     ->orderBy('data_postagem', 'desc');

        if ($request->has('category') && $request->category !== 'Todos') {
            $query->where('categoria', $request->category);
        }

        $vagas = $query->paginate(10);
        return response()->json($vagas);
    }

    /**
     * Salva uma nova vaga no banco de dados.
     */
    public function store(Request $request)
    {
        // Garante que apenas usuários do tipo 'empresa' podem criar vagas
        if (Auth::user()->tipo_usuario !== 'empresa') {
            return response()->json(['message' => 'Apenas empresas podem postar vagas.'], 403);
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            // ... outras regras de validação para os campos da vaga
        ]);

        // Associa a vaga ao usuário (empresa) logado
        $vaga = Auth::user()->vagas()->create($validatedData);

        return response()->json($vaga, 201);
    }
    
    // ... (Aqui viriam os métodos show, update, destroy) ...
}