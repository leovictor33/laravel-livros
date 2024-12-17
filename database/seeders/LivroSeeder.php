<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Verifica quantos livros já existem
        $livrosExistentes = DB::table('tb_livro')->count();

        if ($livrosExistentes < 10) { // Ajuste o número de livros conforme necessário
            for ($i = 0; $i < 10; $i++) {
                DB::table('tb_livro')->insert([
                    'str_titulo' => $faker->sentence(3),
                    'str_editora' => $faker->company,
                    'num_edicao' => $faker->numberBetween(1, 10),
                    'num_ano_publicacao' => $faker->year,
                    'num_valor' => $faker->numerify('##'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
