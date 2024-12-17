<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LivroController extends Controller
{
    // Listar todos os livros
    public function index()
    {
        $livros = Livro::all();
        return view('livros.index', compact('livros'));
    }

    // Mostrar o formulário de criação
    public function create()
    {
        $autores = Autor::orderBy('str_nome', 'asc')->get(); // Ordena os autores
        $assuntos = Assunto::orderBy('str_descricao', 'asc')->get(); // Ordena os assuntos

        return view('livros.create', compact('autores', 'assuntos'));
    }


    // Salvar novo livro no banco
    public function store(Request $request)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $arrData = $request->all();
        $arrData = $this->formatFields($arrData);

        $livro = Livro::create([
            'str_titulo'         => $arrData['str_titulo'],
            'str_editora'        => $arrData['str_editora'],
            'num_edicao'         => $arrData['num_edicao'],
            'num_ano_publicacao' => $arrData['num_ano_publicacao'],
            'num_valor'          => $arrData['num_valor'],
        ]);

        // Associando autores
        $livro->autores()->attach($request->autores);

        // Associando assuntos
        $livro->assuntos()->attach($request->assuntos);

        // Verifica se é uma requisição de teste
        if ($request->header('X-Test-Origin') === 'true') {
            return response()->json($livro, Response::HTTP_CREATED);
        }

        // Redireciona no uso Web normal
        return redirect()->route('livros.index')->with('success', 'Livro criado com sucesso!');
    }


    // Mostrar detalhes de um livro
    public function show($id)
    {
        $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);

        return view('livros.show', compact('livro'));
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        // Busca o livro pelo ID
        $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);

        // Busca listas adicionais (se necessário) para popular selects
        $autores = Autor::all();
        $assuntos = Assunto::all();

        // Retorna a view com os dados do livro
        return view('livros.edit', compact('livro', 'autores', 'assuntos'));
    }


    // Atualizar livro no banco
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        // Buscar o livro para atualização
        $livro = Livro::findOrFail($id);

        $arrData = $request->all();
        $arrData = $this->formatFields($arrData);

        $livro->update([
            'str_titulo'         => $arrData['str_titulo'],
            'str_editora'        => $arrData['str_editora'],
            'num_edicao'         => $arrData['num_edicao'],
            'num_ano_publicacao' => $arrData['num_ano_publicacao'],
            'num_valor'          => $arrData['num_valor'],
        ]);

        // Atualizar relacionamentos
        $livro->autores()->sync($request->input('autores', []));
        $livro->assuntos()->sync($request->input('assuntos', []));

        // Redirecionar com mensagem de sucesso
        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    // Excluir livro
    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }

    private function formatFields(array $arrData)
    {
        if (isset($arrData['num_valor'])) {
            $arrData['num_valor'] = str_replace(',', '.',
                str_replace('.', '', $arrData['num_valor']));
        }

        return $arrData;
    }

    public function gerarRelatorioLivrosPorAutor(Autor $autor)
    {
        $livros = $autor->livros()->with(['autores', 'assuntos'])->get();

        $pdf = SnappyPdf::loadView('relatorios.livros_por_autor', compact('livros', 'autor'));

        // Configurando o cabeçalho para forçar o download
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="livros_por_' . $autor->str_nome . '.pdf"');
    }


//    public function gerarRelatorioLivrosPorAssunto(Assunto $assunto)
//    {
//        $livros = $assunto->livros()->with(['autores', 'assuntos'])->get();
//
//        $pdf = SnappyPdf::loadView('relatorios.livros_por_assunto', compact('livros', 'assunto'));
//
//        // Configurando o cabeçalho para forçar o download
//        return response($pdf->output(), 200)
//            ->header('Content-Type', 'application/pdf')
//            ->header('Content-Disposition', 'attachment; filename="livros_por_' . $assunto->str_descricao . '.pdf"');
//    }

    private function getValidatorInput()
    {
        return [
            'str_titulo'         => 'required|string|max:40',
            'str_editora'        => 'required|string|max:40',
            'num_edicao'         => 'required|integer',
            'num_ano_publicacao' => 'required|integer|min:1900|max:' . date('Y'),
            'autores'            => 'array',
            'assuntos'           => 'array',
        ];
    }

    private function getValidatorMessage()
    {
        return [
            'num_ano_publicacao.required' => 'O campo Ano de Publicação é obrigatório.',
            'num_ano_publicacao.integer'  => 'O Ano de Publicação deve ser um número inteiro.',
            'num_ano_publicacao.min'      => 'O Ano de Publicação deve ser no mínimo 1900.',
            'num_ano_publicacao.max'      => 'O Ano de Publicação não pode ser maior que o ano atual.',
            'str_titulo.required'         => 'O campo Título é obrigatório.',
            'str_titulo.max'              => 'O campo Título deve conter no máximo 40 caracteres.',
            'str_editora.required'        => 'O campo Título é obrigatório.',
            'str_editora.max'             => 'O campo Título deve conter no máximo 40 caracteres.',
            'num_edicao.required'         => 'O campo Edição é obrigatório.',
        ];
    }
}