<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LivroAutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Obter todos os livros e autores existentes
        $livros = DB::table('tb_livro')->pluck('codigo');
        $autores = DB::table('tb_autor')->pluck('codigo');

        // Associar livros a autores
        foreach ($livros as $livro) {
            // Seleciona 2 autores aleatórios para cada livro
            $selectedAutores = $autores->random(2);
            foreach ($selectedAutores as $autor) {
                DB::table('tb_livro_autor')->insert([
                    'codigo_livro' => $livro,
                    'codigo_autor' => $autor,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
