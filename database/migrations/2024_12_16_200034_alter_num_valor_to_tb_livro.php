<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tb_livro', function (Blueprint $table) {
            // Alterando a precisão e a escala para permitir valores maiores
            $table->decimal('num_valor', 15, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('tb_livro', function (Blueprint $table) {
            // Revertendo para o tamanho original
            $table->decimal('num_valor', 10, 2)->change();
        });
    }
};
