<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Envia o link de redefinição de senha para o e-mail informado.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => 'Link de redefinição de senha enviado com sucesso!'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Não foi possível encontrar um usuário com este endereço de email.'
        ], 404);
    }

    /**
     * Redefine a senha do usuário.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill([
                'password' => $password  // DEIXA SEM Hash::make() se você já tem o mutator no model
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'message' => 'Senha redefinida com sucesso!'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'O token de redefinição de senha é inválido ou expirou.'
        ], 400);
    }
}
