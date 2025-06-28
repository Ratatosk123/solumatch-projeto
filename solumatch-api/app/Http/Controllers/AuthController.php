<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Regista um novo utilizador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 👇 ALTERAÇÕES AQUI: Ajustamos as regras de validação.
        $validatedData = $request->validate([
            // Alterado de 'nome' para 'name' para corresponder ao formulário do frontend
            'name' => 'required|string|max:255', 
            
            'email' => 'required|string|email|max:255|unique:users',
            
            // Removida a regra 'confirmed' para simplificar o formulário de registo
            'password' => ['required', Password::min(8)->mixedCase()->numbers()], 

            'tipo_usuario' => 'required|in:profissional,empresa',
            'cpf' => 'required_if:tipo_usuario,profissional|nullable|string|unique:users,cpf',
            'cnpj' => 'required_if:tipo_usuario,empresa|nullable|string|unique:users,cnpj',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
        ]);

        // 👇 ALTERAÇÃO AQUI: Ajustamos a criação do utilizador.
        $user = User::create([
            // Alterado de 'nome' para 'name'
            'name' => $validatedData['name'], 
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'tipo_usuario' => $validatedData['tipo_usuario'],
            'cpf' => $validatedData['cpf'] ?? null,
            'cnpj' => $validatedData['cnpj'] ?? null,
            'telefone' => $validatedData['telefone'] ?? null,
            'endereco' => $validatedData['endereco'] ?? null,
            'cep' => $validatedData['cep'] ?? null,
        ]);

        // Após o registo, faz o login automático e retorna um token.
        // Isto melhora a experiência do utilizador.
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Autentica um utilizador existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages(['email' => ['As credenciais fornecidas estão incorretas.']]);
        }

        // É necessário obter o utilizador a partir da requisição APÓS a autenticação
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Faz o logout do utilizador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}