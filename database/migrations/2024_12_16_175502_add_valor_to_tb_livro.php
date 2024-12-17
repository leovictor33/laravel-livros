<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorToTbLivro extends Migration
{
    public function up()
    {
        Schema::table('tb_livro', function (Blueprint $table) {
            $table->decimal('num_valor', 10, 2)->nullable()->after('num_ano_publicacao'); // Adicionando o campo valor
        });
    }

    public function down()
    {
        Schema::table('tb_livro', function (Blueprint $table) {
            $table->dropColumn('num_valor');
        });
    }
}
