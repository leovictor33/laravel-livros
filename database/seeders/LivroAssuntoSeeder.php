<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LivroAssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Obter todos os livros e assuntos existentes
        $livros = DB::table('tb_livro')->pluck('codigo');
        $assuntos = DB::table('tb_assunto')->pluck('codigo');

        // Associar livros a assuntos
        foreach ($livros as $livro) {
            // Seleciona 2 assuntos aleatórios para cada livro
            $selectedAssuntos = $assuntos->random(2);
            foreach ($selectedAssuntos as $assunto) {
                DB::table('tb_livro_assunto')->insert([
                    'codigo_livro' => $livro,
                    'codigo_assunto' => $assunto,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
