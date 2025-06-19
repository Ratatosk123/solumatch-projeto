<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Importa o modelo User
use App\Models\Vaga; // Importa o modelo Vaga

class VagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Encontra o primeiro usuário que é uma empresa para ser o dono das vagas
        $empresa = User::where('tipo_usuario', 'empresa')->first();

        if ($empresa) {
            Vaga::create([
                'user_id' => $empresa->id,
                'titulo' => 'Desenvolvedor PHP Pleno (Remoto)',
                'descricao' => 'Procuramos um desenvolvedor PHP com experiência em Laravel para trabalhar em projetos inovadores. O trabalho é 100% remoto.',
                'requisitos' => 'PHP, Laravel, MySQL, Git',
                'categoria' => 'Programação',
                'tipo_contratacao' => 'CLT',
                'salario' => 5500.00
            ]);

            Vaga::create([
                'user_id' => $empresa->id,
                'titulo' => 'Designer de UI/UX para App Mobile',
                'descricao' => 'Precisamos de um designer talentoso para criar a interface de um novo aplicativo de finanças. Experiência com Figma é essencial.',
                'requisitos' => 'Figma, UI, UX, Design System',
                'categoria' => 'Design',
                'tipo_contratacao' => 'Preço Fixo / PJ / Freelance',
                'salario' => 8000.00
            ]);
        }
    }
}