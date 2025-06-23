<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Este método gera um token e retorna o link de recuperação
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Gera um token seguro
        $token = Str::random(60);

        // Salva o token no banco de dados
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Em vez de enviar um email, retornamos o link para o frontend (bom para desenvolvimento)
        $resetLink = "http://localhost:5173/resetar-senha?token={$token}&email=" . urlencode($request->email);

        return response()->json([
            'message' => 'Link de recuperação gerado com sucesso.',
            'reset_link' => $resetLink
        ]);
    }

    // Este método valida o token e redefine a senha
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tenta redefinir a senha usando o sistema do Laravel
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha redefinida com sucesso!']);
        }

        return response()->json(['message' => 'Token inválido ou expirado.'], 400);
    }
}