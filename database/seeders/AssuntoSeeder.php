<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Verifica quantos assuntos já existem
        $assuntosExistentes = DB::table('tb_assunto')->count();

        if ($assuntosExistentes < 5) { // Ajuste o número de assuntos conforme necessário
            for ($i = 0; $i < 5; $i++) {
                DB::table('tb_assunto')->insert([
                    'str_descricao' => $faker->word,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
