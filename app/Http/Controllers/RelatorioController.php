<?php

namespace App\Http\Controllers;

use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\Autor;
use Illuminate\Support\Facades\DB;
use Knp\Snappy\Pdf;

class RelatorioController extends Controller
{
    public function livros()
    {
        $autores = Autor::with('livros')->orderBy('str_nome')->get();

        $pdf = SnappyPdf::loadView('relatorios.livros', compact('autores'))
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4', 'portrait'); // Definindo o tamanho e orientação do papel

        return $pdf->download('relatorio_livros.pdf');
    }

    public function gerarRelatorioPorAssunto($assuntoId)
    {
        // Consultando os dados da view "livros_por_assunto" no PostgreSQL
        // A view já deve ser configurada para agrupar livros por assunto
        $livros = DB::table('livros_por_assunto')
            ->where('assunto_id', $assuntoId)
            ->get();

        // Gerando o PDF a partir da view 'relatorios.livros_assunto'
        $pdf = SnappyPdf::loadView('relatorios.livros_assunto_view', compact('livros'))
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4', 'portrait'); // Definindo o tamanho e orientação do papel

        // Retornando o PDF para download
        return $pdf->download('relatorio_livros_por_assunto.pdf');
    }
}
