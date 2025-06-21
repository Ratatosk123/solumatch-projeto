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
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'tipo_usuario' => 'required|in:profissional,empresa',
            'cpf' => 'required_if:tipo_usuario,profissional|nullable|string|unique:users,cpf',
            'cnpj' => 'required_if:tipo_usuario,empresa|nullable|string|unique:users,cnpj',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
        ]);

        $user = User::create([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'tipo_usuario' => $validatedData['tipo_usuario'],
            'cpf' => $validatedData['cpf'] ?? null,
            'cnpj' => $validatedData['cnpj'] ?? null,
            'telefone' => $validatedData['telefone'] ?? null,
            'endereco' => $validatedData['endereco'] ?? null,
            'cep' => $validatedData['cep'] ?? null,
        ]);

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages(['email' => ['As credenciais fornecidas estão incorretas.']]);
        }

        $user = $request->user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}