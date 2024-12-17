<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssuntoController extends Controller
{
    public function index()
    {
        $assuntos = Assunto::orderBy('str_descricao', 'asc')->get();
        return view('assuntos.index', compact('assuntos'));
    }

    public function create()
    {
        return view('assuntos.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $assunto = Assunto::create($request->all());

        // Verifica se é uma requisição de teste
        if ($request->header('X-Test-Origin') === 'true') {
            return response()->json($assunto, Response::HTTP_CREATED);
        }

        return redirect()->route('assuntos.index')->with('success', 'Assunto criado com sucesso!');
    }

    public function show($id)
    {
        $assunto = Assunto::findOrFail($id);
        // Carregar livros associados ao assunto, se necessário
        $livros = $assunto->livros; // Supondo que exista um relacionamento 'livros' em Autor

        return view('assuntos.show', compact('assunto', 'livros'));
    }

    public function edit($codigo)
    {
        $assunto = Assunto::findOrFail($codigo);
        return view('assuntos.edit', compact('assunto'));
    }

    public function update(Request $request, $codigo)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $assunto = Assunto::findOrFail($codigo);
        $assunto->update($request->all());

        return redirect()->route('assuntos.index')->with('success', 'Assunto atualizado com sucesso!');
    }

    public function destroy($codigo)
    {
        $assunto = Assunto::findOrFail($codigo);
        $assunto->delete();

        return redirect()->route('assuntos.index')->with('success', 'Assunto excluído com sucesso!');
    }

    private function getValidatorInput()
    {
        return [
            'str_descricao' => 'required|string|max:20',
        ];
    }

    private function getValidatorMessage()
    {
        return [
            'str_descricao.max' => 'O campo Descrição deve conter no máximo 20 caracteres.',
        ];
    }
}
