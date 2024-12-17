<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_livro', function (Blueprint $table) {
            $table->id('codigo'); // Cria a coluna 'codigo' como PRIMARY KEY
            $table->string('str_titulo', 40);
            $table->string('str_editora', 40)->nullable();
            $table->integer('num_edicao')->nullable();
            $table->integer('num_ano_publicacao')->nullable();
            $table->decimal('num_valor', 15, 2)->nullable();
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_livro');
    }
};
