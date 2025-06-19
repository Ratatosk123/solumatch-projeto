<?php

namespace App\Http\Controllers;

use App\Models\User; // Importa o Model 'User' para interagir com a tabela de usuários.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Fachada de Autenticação do Laravel.
use Illuminate\Support\Facades\Hash; // Fachada para criptografar e verificar senhas.
use Illuminate\Validation\Rules\Password; // Classe para definir regras de senha fortes.
use Illuminate\Validation\ValidationException; // Classe para lidar com erros de validação.

class AuthController extends Controller
{
    /**
     * Registra um novo usuário (Profissional ou Empresa).
     * Este método é chamado pela rota POST /api/register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 1. Validação dos dados recebidos do frontend.
        // Se a validação falhar, o Laravel automaticamente retorna um erro 422 com os detalhes.
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed', // Verifica se o campo 'password_confirmation' foi enviado e corresponde.
                Password::min(8)->mixedCase()->numbers() // Regra de segurança: Mínimo 8 caracteres, com maiúsculas e minúsculas, e números.
            ],
            'tipo_usuario' => 'required|in:profissional,empresa',
            'cpf' => 'required_if:tipo_usuario,profissional|nullable|string|unique:users,cpf',
            'cnpj' => 'required_if:tipo_usuario,empresa|nullable|string|unique:users,cnpj',
        ]);

        // 2. Criação do usuário no banco de dados.
        $user = User::create([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // IMPORTANTE: Criptografa a senha antes de salvar!
            'tipo_usuario' => $validatedData['tipo_usuario'],
            'cpf' => $validatedData['cpf'] ?? null,
            'cnpj' => $validatedData['cnpj'] ?? null,
        ]);

        // 3. Retorna uma resposta de sucesso para o frontend.
        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
    }

    /**
     * Autentica um usuário e retorna um token de acesso.
     * Este método é chamado pela rota POST /api/login.
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

        // Tenta autenticar usando as credenciais. O Laravel cuida da comparação da senha hasheada.
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Se a autenticação falhar, lança uma exceção com uma mensagem de erro.
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // Se o login for bem-sucedido, obtém o modelo do usuário.
        $user = $request->user();

        // Cria um token de API para o usuário usando o Laravel Sanctum.
        // Este token será usado pelo Vue.js para acessar rotas protegidas.
        $token = $user->createToken('auth-token')->plainTextToken;

        // Retorna uma resposta de sucesso com os dados do usuário e o token.
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Faz o logout do usuário (invalida o token de acesso atual).
     * Este método é chamado pela rota POST /api/logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoga o token específico que foi usado para fazer esta chamada.
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}