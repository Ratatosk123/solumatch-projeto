<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\ResetPasswordLink;

class PasswordResetController extends Controller
{
    /**
     * Envia o link de redefinição de senha por e-mail.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // 1. Gerar um token aleatório
        $token = Str::random(60);

        // 2. Salvar token hasheado no banco (bcrypt)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => bcrypt($token),  // ← hashing necessário
                'created_at' => Carbon::now(),
            ]
        );

        // 3. Criar link para o front-end
        $resetLink = "http://localhost:5173/resetar-senha?token={$token}&email=" . urlencode($request->email);

        // 4. Enviar e-mail
        $user = User::where('email', $request->email)->first();
        $user->notify(new ResetPasswordLink($resetLink));

        return response()->json([
            'message' => 'Um e-mail com o link de recuperação foi enviado!',
        ]);
    }

    /**
     * Redefine a senha com base no token e dados recebidos.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required|string',
            'email'                 => 'required|email|exists:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        // Para depuração (opcional):
        Log::info('Requisição de reset:', $request->only('email', 'token'));

        // 1. Tentar redefinir a senha usando o Password Broker
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Apenas atribua em texto plano — o mutator fará o hash
                $user->password = $password;
                $user->save();
            }
        );

        // 2. Retorno baseado no resultado
        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha redefinida com sucesso!']);
        }

        return response()->json(['message' => 'Token de redefinição de senha é inválido ou expirou.'], 400);
    }
}
