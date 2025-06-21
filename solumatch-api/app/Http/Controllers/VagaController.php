<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VagaController extends Controller
{
    public function index(Request $request)
    {
        $query = Vaga::with('empresa:id,nome')->latest('data_postagem');

        if ($request->filled('category') && $request->category !== 'Todos') {
            $query->where('categoria', $request->category);
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->tipo_usuario !== 'empresa') {
            return response()->json(['message' => 'Apenas empresas podem postar vagas.'], 403);
        }

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            'tipo_contratacao' => 'required|string',
            'requisitos' => 'nullable|string',
            'localizacao' => 'nullable|string',
            'salario' => 'nullable|numeric',
            'tipo_orcamento' => 'required|in:fixo,por_hora',
        ]);

        $vaga = $user->vagas()->create($validatedData);

        return response()->json($vaga, 201);
    }

    public function show(Vaga $vaga) { /* Lógica para ver uma vaga específica */ }
    public function update(Request $request, Vaga $vaga) { /* Lógica para atualizar uma vaga */ }
    public function destroy(Vaga $vaga) { /* Lógica para deletar uma vaga */ }
}