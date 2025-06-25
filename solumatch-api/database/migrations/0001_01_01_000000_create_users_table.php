<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Colunas padrão do Laravel
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // Cria as colunas created_at e updated_at

            // ================================================
            // SUAS COLUNAS PERSONALIZADAS (A CORREÇÃO ESTÁ AQUI)
            // ================================================
            $table->string('tipo_usuario')->nullable(); // ex: 'profissional' ou 'empresa'
            $table->string('cpf')->nullable()->unique();
            $table->string('cnpj')->nullable()->unique();
            $table->string('numero')->nullable(); // Para o celular
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->text('sobre_mim')->nullable();
            
            // Adicione outras colunas se precisar
            // $table->string('profile_picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
