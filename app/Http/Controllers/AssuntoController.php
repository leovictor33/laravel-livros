<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsável pela gestão dos recursos ‘Assunto’
 */
class AssuntoController extends Controller
{
    /**
     * Recupera uma lista de Assunto ordenada pela sua descrição em ordem crescente
     *   e retorna a visualização do índice de assuntos com os dados.
     * @return Factory|\Illuminate\Contracts\View\View|Application|RedirectResponse
     */
    public function index()
    {
        try {
            // Recupera todos os registros de assuntos ordenados por descrição
            $assuntos = Assunto::orderBy('str_descricao', 'asc')->get();

            // Retorna a visualização com a lista de assuntos
            return view($this->getPathView(), compact('assuntos'));

        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }

    /**
     * Exiba o formulário para novo assunto
     *
     * @return View
     */
    public function create()
    {
        return view($this->getPathView());
    }

    /**
     * Valida os dados de entrada, para novo registro "Assunto" no banco de dados e retorna uma resposta apropriada.
     *
     * Se o cabeçalho "X-Test-Origin" estiver definido como "true", uma resposta JSON será retornada com o "Assunto"
     * criado e um código de status 201.
     * Caso contrário, o usuário é redirecionado para a rota "assuntos.index" com mensagem de sucesso.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados de entrada antes do try/catch
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        try {
            // Cria o registro no banco de dados
            $assunto = Assunto::create($request->all());
            if ($request->header('X-Test-Origin') === 'true') {
                return response()->json($assunto, Response::HTTP_CREATED);
            }

            // Retorna sucesso
            return redirect()->route($this->getPathView())->with('success', 'Assunto criado com sucesso!');
        } catch (Exception $e) {
            // Lida com exceções inesperadas
            return $this->handleException($e, 'Ocorreu um erro ao criar o assunto.');
        }
    }

    /**
     * Exibe os detalhes de um registro "Assunto" identificado pelo ID fornecido e exibe sua visão.
     *
     * Este método tenta recuperar o registro "Assunto" pelo ID. Em caso de sucesso, retorna a visão
     * com os detalhes do "Assunto" e seus "livros" associados. Caso contrário, lida com diferentes tipos
     * de exceções, incluindo a ausência de registros, IDs inválidos ou erros inesperados.
     *
     * @param mixed $id O identificador do registro "Assunto" que será exibido.
     * @return Factory|View|Application|RedirectResponse A visão com os detalhes do registro ou um redirecionamento em caso de erro.
     */
    public function show($id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            $livros = $assunto->livros;

            return view($this->getPathView(), compact('assunto', 'livros'));

        } catch (Exception $e) {
            // Lida com exceções inesperadas
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o assunto.');
        }
    }

    /**
     * Recupera o registro "Assunto" pelo código fornecido e exibe o formulário de edição correspondente.
     *
     * Caso o registro não seja encontrado, uma exceção será lançada.
     *
     * @param $id
     * @return Factory|\Illuminate\Contracts\View\View|Application|RedirectResponse
     */
    public function edit($id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            return view($this->getPathView(), compact('assunto'));
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o assunto.');
        }
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

        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->update($request->all());

            return redirect()->route($this->getPathView())->with('success', 'Assunto atualizado com sucesso!');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o assunto.');
        }
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
        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->delete();
            return redirect()->route($this->getPathView())->with('success', 'Assunto excluído com sucesso!');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o assunto.');
        }
    }

    /**
     * Retorna as regras de validação para os dados de entrada do modelo.
     *
     * Define as restrições de validação aplicáveis, como obrigatoriedade, tipo de dado,
     * e limite de caracteres para os campos especificados.
     *
     * @return array Um array associativo contendo as regras de validação.
     */
    public function getValidatorInput(): array
    {
        return ['str_descricao' => 'required|string|max:20'];
    }

    /**
     * Retorna as mensagens de validação personalizadas para o processo de validação dos dados de entrada.
     *
     * Essa configuração específica mensagens de erro para campos específicos, como o campo "str_descricao",
     * limitando o seu tamanho máximo a 20 caracteres.
     *
     * @return array Um array associativo contendo os atributos e suas respectivas mensagens de validação.
     */
    public function getValidatorMessage(): array
    {
        return ['str_descricao.max' => 'O campo Descrição deve conter no máximo 20 caracteres.'];
    }
}
