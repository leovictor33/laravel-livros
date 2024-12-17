<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Verifica quantos autores já existem
        $autoresExistentes = DB::table('tb_autor')->count();

        if ($autoresExistentes < 5) { // Ajuste o número de autores conforme necessário
            for ($i = 0; $i < 5; $i++) {
                DB::table('tb_autor')->insert([
                    'str_nome' => $faker->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
