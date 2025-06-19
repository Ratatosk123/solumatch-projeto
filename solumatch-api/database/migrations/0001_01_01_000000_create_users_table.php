<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Nossos campos personalizados
            $table->enum('tipo_usuario', ['profissional', 'empresa']);
            $table->string('cpf')->unique()->nullable();      // Nulo para empresas
            $table->string('cnpj')->unique()->nullable();     // Nulo para profissionais
            $table->string('numero', 20)->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep', 10)->nullable();
            $table->text('sobre_mim')->nullable();
            // Usaremos um campo BLOB para armazenar a imagem diretamente no banco.
            // É uma abordagem simples para começar.
            $table->binary('profile_picture')->nullable();
            $table->string('profile_picture_type')->nullable(); // Para guardar o tipo da imagem (ex: image/png)

            $table->rememberToken();
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};