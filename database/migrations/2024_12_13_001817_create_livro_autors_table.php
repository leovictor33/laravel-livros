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
        Schema::create('tb_livro_autor', function (Blueprint $table) {
            $table->id('codigo');
            $table->unsignedBigInteger('codigo_livro');
            $table->unsignedBigInteger('codigo_autor');
            $table->foreign('codigo_livro')->references('codigo')->on('tb_livro')->onDelete('cascade');
            $table->foreign('codigo_autor')->references('codigo')->on('tb_autor')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_livro_autor');
    }
};
