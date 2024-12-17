<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_livro_assunto', function (Blueprint $table) {
            $table->id('codigo');
            $table->unsignedBigInteger('codigo_livro');
            $table->unsignedBigInteger('codigo_assunto');
            $table->foreign('codigo_livro')->references('codigo')->on('tb_livro')->onDelete('cascade');
            $table->foreign('codigo_assunto')->references('codigo')->on('tb_assunto')->onDelete('cascade');
            $table->timestamps();
        });

        DB::statement("
        CREATE VIEW livros_por_assunto AS
        SELECT
            a.codigo AS assunto_id,
            a.str_descricao AS assunto_nome,
            l.codigo AS livro_id,
            l.str_titulo,
            l.str_editora,
            l.num_ano_publicacao,
            l.num_valor,
            string_agg(aut.str_nome, ', ') AS autores
        FROM
            tb_assunto a
            JOIN tb_livro_assunto la ON a.codigo = la.codigo_assunto
            JOIN tb_livro l ON la.codigo_livro = l.codigo
            JOIN tb_livro_autor lauto ON l.codigo = lauto.codigo_livro
            JOIN tb_autor aut ON lauto.codigo_autor = aut.codigo
        GROUP BY
            a.codigo, l.codigo
        ORDER BY
            a.str_descricao, l.str_titulo
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop a view que depende da tabela
        DB::statement('DROP TABLE IF EXISTS tb_livro_assunto CASCADE');

        Schema::dropIfExists('tb_livro_assunto');
    }
};
