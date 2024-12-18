<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException as InvalidArgumentExceptionAlias;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsável pela gestão dos recursos ‘Assunto’
 */
class AssuntoController extends Controller
{
    /**
     * Recupera uma lista de Assunto ordenada pela sua descrição em ordem crescente
     *  e retorna a visualização do índice de assuntos com os dados.
     */
    public function index()
    {
        $assuntos = Assunto::orderBy('str_descricao', 'asc')->get();
        return view('assuntos.index', compact('assuntos'));
    }

    /**
     * Exiba o formulário para novo assunto
     *
     * @return View
     */
    public function create()
    {
        return view('assuntos.create');
    }

    /**
     * Valida os dados de entrada, para novo registro "Assunto" no banco de dados e retorna uma resposta apropriada.
     *
     * Se o cabeçalho "X-Test-Origin" estiver definido como "true", uma resposta JSON será retornada com o "Assunto"
     * criado e um código de status 201.
     * Caso contrário, o usuário é redirecionado para a rota "assuntos.index" com mensagem de sucesso.
     *
     * @param Request $request A instância de solicitação HTTP que contém dados de entrada.
     * @return JsonResponse|RedirectResponse O objeto de resposta, JSON ou um redirecionamento.
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $assunto = Assunto::create($request->all());

        if ($request->header('X-Test-Origin') === 'true') {
            return response()->json($assunto, Response::HTTP_CREATED);
        }

        return redirect()->route('assuntos.index')->with('success', 'Assunto criado com sucesso!');
    }

    /**
     * Recupera o registro "Assunto" pelo ‘ID’ informado e carrega os seus livros relacionados,
     * então retorna uma visão com os dados para exibição.
     *
     * Se o registro "Assunto" correspondente ao ‘ID’ fornecido não for encontrado, uma exceção será lançada.
     *
     * @param int $id O identificador único do registro "Assunto" a ser exibido.
     * @return View A visão que exibe o "Assunto" e os livros associados.
     */
    public function show($id)
    {

        if (!$id) {
            throw new InvalidArgumentExceptionAlias('O ID fornecido é inválido.');
        }
        $assunto = Assunto::findOrFail($id);
        $livros = $assunto->livros;

        return view('assuntos.show', compact('assunto', 'livros'));
    }

    /**
     * Recupera o registro "Assunto" pelo código fornecido e exibe o formulário de edição correspondente.
     *
     * Caso o registro não seja encontrado, uma exceção será lançada.
     *
     * @param mixed $id O identificador do registro "Assunto" a ser editado.
     * @return View A visão que contém o formulário de edição do registro.
     */
    public function edit($id)
    {
        $assunto = Assunto::findOrFail($id);
        return view('assuntos.edit', compact('assunto'));
    }

    /**
     * Atualiza as informações de um registro existente "Assunto" no banco de dados com os dados fornecidos e redireciona o usuário.
     *
     * Este método valida os dados de entrada, busca o registro pelo código informado, atualiza os dados no banco de dados
     * e redireciona para a rota "assuntos.index" com uma mensagem de sucesso.
     *
     * @param Request $request A instância de solicitação HTTP contendo os dados de entrada.
     * @param mixed $id O identificador do registro "Assunto" a ser atualizado.
     * @return RedirectResponse O objeto de redirecionamento contendo a mensagem de sucesso.
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        $assunto = Assunto::findOrFail($id);
        $assunto->update($request->all());

        return redirect()->route('assuntos.index')->with('success', 'Assunto atualizado com sucesso!');
    }

    /**
     * Remove o registro "Assunto" identificado pelo código fornecido do banco de dados e redireciona o usuário.
     *
     * Realiza a busca pelo registro com o código especificado. Caso não seja encontrado, uma exceção será lançada.
     * Após localizar o registro, o mesmo será excluído, e o usuário será redirecionado para a rota "assuntos.index"
     * com uma mensagem de sucesso.
     *
     * @param mixed $id O identificador do registro "Assunto" a ser excluído.
     * @return RedirectResponse O redirecionamento para a rota especificada com mensagem de sucesso.
     */
    public function destroy($id)
    {
        $assunto = Assunto::findOrFail($id);
        $assunto->delete();

        return redirect()->route('assuntos.index')->with('success', 'Assunto excluído com sucesso!');
    }

    /**
     * Retorna as regras de validação para os dados de entrada do modelo.
     *
     * Define as restrições de validação aplicáveis, como obrigatoriedade, tipo de dado,
     * e limite de caracteres para os campos especificados.
     *
     * @return array Um array associativo contendo as regras de validação.
     */
    private function getValidatorInput()
    {
        return [
            'str_descricao' => 'required|string|max:20',
        ];
    }

    /**
     * Retorna as mensagens de validação personalizadas para o processo de validação dos dados de entrada.
     *
     * Essa configuração específica mensagens de erro para campos específicos, como o campo "str_descricao",
     * limitando o seu tamanho máximo a 20 caracteres.
     *
     * @return array Um array associativo contendo os atributos e suas respectivas mensagens de validação.
     */
    private function getValidatorMessage()
    {
        return [
            'str_descricao.max' => 'O campo Descrição deve conter no máximo 20 caracteres.',
        ];
    }
}
