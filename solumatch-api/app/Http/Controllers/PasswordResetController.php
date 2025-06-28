<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;   // ← agora realmente utilizado
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\ResetPasswordLink;

class PasswordResetController extends Controller
{
    /**
     * Gera o token, armazena na tabela password_reset_tokens
     * e envia o link de redefinição por e-mail.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // 1. Gerar um token aleatório
        $token = Str::random(60);

        // 2. Inserir ou atualizar na tabela de tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => $token,
                'created_at' => Carbon::now(),
            ]
        );

        // 3. Criar o link para seu front-end
        $resetLink = "http://localhost:5173/resetar-senha?token={$token}&email=" . urlencode($request->email);

        // 4. Enviar notificação por e-mail
        $user = User::where('email', $request->email)->first();
        $user->notify(new ResetPasswordLink($resetLink));

        return response()->json([
            'message' => 'Um e-mail com o link de recuperação foi enviado!',
        ]);
    }

    /**
     * Valida o token recebido e redefine a senha do usuário.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required|string',
            'email'                 => 'required|email|exists:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        // 1. Usar o Password Broker para validar token e atualizar senha
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Hash e salva a nova senha
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // 2. Retornar resposta adequada
        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha redefinida com sucesso!']);
        }

        return response()->json(['message' => 'Token inválido ou expirado.'], 400);
    }
}
