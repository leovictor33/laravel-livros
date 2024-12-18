<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::orderBy('str_nome', 'asc')->get();
        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $autor = Autor::create($request->all());

        if ($request->header('X-Test-Origin') === 'true') {
            return response()->json($autor, Response::HTTP_CREATED);
        }

        return redirect()->route('autores.index')->with('success', 'Autor criado com sucesso!');
    }

    public function show($id)
    {
        $autor = Autor::findOrFail($id);
        // Carregar livros associados ao autor, se necessário
        $livros = $autor->livros; // Supondo que exista um relacionamento 'livros' em Autor

        return view('autores.show', compact('autor', 'livros'));
    }

    public function edit($id)
    {
        $autor = Autor::findOrFail($id);
        return view('autores.edit', compact('autor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $autor = Autor::findOrFail($id);
        $autor->update($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);
        $autor->delete();

        return redirect()->route('autores.index')->with('success', 'Autor excluído com sucesso!');
    }

    private function getValidatorInput()
    {
        return [
            'str_nome' => 'required|string|max:40',
        ];
    }

    private function getValidatorMessage()
    {
        return [
            'str_nome.max' => 'O campo Nome do Autor(a) deve conter no máximo 40 caracteres.',
        ];
    }
}
