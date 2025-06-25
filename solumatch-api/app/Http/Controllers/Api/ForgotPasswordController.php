<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;


class ForgotPasswordController extends Controller
{
    /**
     * Lida com o pedido de link para redefinição de senha.
     * Envia um email para o usuário com o token de redefinição.
     */
    public function forgotPassword(Request $request)
    {
        // Valida se o email foi enviado e se é um email válido.
        $request->validate(['email' => 'required|email']);

        // Tenta enviar o link de redefinição de senha usando o mecanismo padrão do Laravel.
        // O método 'sendResetLink' cuida da criação do token e do envio do email.
        $status = Password::sendResetLink($request->only('email'));

        // Verifica o status do envio.
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => 'Link de redefinição de senha enviado com sucesso!'
            ], 200);
        }

        // Se o email não for encontrado na base de dados, o status será 'INVALID_USER'.
        return response()->json([
            'status' => 'error',
            'message' => 'Não foi possível encontrar um usuário com este endereço de email.'
        ], 404);
    }

    /**
     * Redefine a senha do usuário com base no token recebido.
     */
    public function resetPassword(Request $request)
    {
        // Valida os dados recebidos: token, email e a nova senha com confirmação.
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Usa a facade Password para tentar redefinir a senha.
        // O Laravel verifica automaticamente se o token e o email correspondem.
        $status = Password::reset($request->all(), function (User $user, string $password) {
            // Se o token for válido, esta função de callback será executada.
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            // Dispara um evento para notificar que a senha foi redefinida.
            event(new PasswordReset($user));
        });
        
        // Se a senha foi redefinida com sucesso, retorna uma mensagem positiva.
        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'message' => 'Senha redefinida com sucesso!'
            ], 200);
        }

        // Se o token for inválido, o Laravel retorna este status.
        return response()->json([
            'status' => 'error',
            'message' => 'O token de redefinição de senha é inválido ou expirou.'
        ], 400);
    }
}
