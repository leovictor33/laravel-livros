<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\Autor;
use Illuminate\Support\Facades\DB;

class RelatorioController
{
    public function livros()
    {
        $autores = Autor::with('livros')->orderBy('str_nome')->get();

        $pdf = SnappyPdf::loadView('relatorios.livros', compact('autores'))
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4', 'portrait');

        return $pdf->download('relatorio_livros.pdf');
    }

    public function gerarRelatorioPorAssunto($assuntoId)
    {
        $assunto = Assunto::findOrFail($assuntoId);
        $livros = DB::table('livros_por_assunto')
            ->where('assunto_id', $assuntoId)
            ->get();
        $strAssunto = $assunto->str_descricao;
        $pdf = SnappyPdf::loadView('relatorios.livros_assunto_view', compact('livros', 'strAssunto'))
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4', 'portrait');

        return $pdf->download('Livros_sobre_' . $strAssunto . '.pdf');
    }
}
