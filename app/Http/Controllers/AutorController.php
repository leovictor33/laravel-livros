<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutorController extends Controller
{
    /**
     * Recupera uma lista de Autores ordenada pelo seu nome em ordem crescente
     * e retorna a visualização do índice de autores com os dados.
     * @return Factory|View|Application|RedirectResponse
     */
    public function index()
    {
        try {
            $autores = Autor::orderBy('str_nome', 'asc')->get();
            return view($this->getPathView(), compact('autores'));

        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e trata com o método handleException
            return $this->handleException($e, 'Ocorreu um erro inesperado.');
        }
    }

    /**
     * Exiba o formulário para novo autor
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->getPathView());
    }

    /**
     * Lida com o armazenamento de um recurso Autor recém-criado.
     *
     * Valida os dados da solicitação recebida antes de prosseguir
     * a criação do registro Autor. Se a solicitação tiver origem
     * de um teste, retorna uma resposta JSON do registro criado.
     * Caso contrário, redireciona para a rota apropriada com uma mensagem de sucesso.
     * Lida com exceções retornando uma resposta de erro apropriada.
     *
     * @param Request $request Solicitação HTTP de entrada contendo os dados para o novo registro Autor.
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados de entrada antes do try/catch
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        try {
            $autor = Autor::create($request->all());

            // Verifica se é uma requisição de teste
            if ($request->header('X-Test-Origin') === 'true') {
                return response()->json($autor, Response::HTTP_CREATED);
            }

            // Retorna sucesso
            return redirect()->route($this->getPathView())->with('success', 'Autor criado com sucesso!');
        } catch (Exception $e) {
            // Lida com exceções inesperadas
            return $this->handleException($e, 'Ocorreu um erro ao criar o assunto.');
        }
    }

    /**
     * Exibe as informações detalhadas de um autor específico.
     *
     * Recupera o registro do autor com base no ID fornecido, incluindo os livros
     * associados, se existentes. Retorna uma visão contendo os detalhes do autor
     * e dos seus livros. Lida com erros e exceções lançando uma resposta de erro
     * apropriada.
     *
     * @param int $id Identificador único do autor a ser exibido.
     * @return Application|Factory|RedirectResponse|View
     */
    public function show($id)
    {
        try {
            $autor = Autor::findOrFail($id);
            // Carregar livros associados ao autor, se necessário
            $livros = $autor->livros; // Supondo que exista um relacionamento 'livros' em Autor

            return view($this->getPathView(), compact('autor', 'livros'));
        } catch (Exception $e) {
            // Lida com exceções inesperadas
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o autor.');
        }
    }

    /**
     * Apresenta o formulário de edição para um recurso Autor específico.
     *
     * Recupera o registro Autor pelo identificador fornecido.
     *
     * @param int $id Identificador único do recurso Autor que deve ser editado.
     * @return Factory|View|Application|RedirectResponse
     */
    public function edit($id)
    {
        $id = false;
        try {
            $autor = Autor::findOrFail($id);
            return view($this->getPathView(), compact('autor'));
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o autor.');
        }
    }

    /**
     * Lida com a atualização de um recurso Autor existente.
     *
     * Valida os dados da solicitação recebida antes de localizar e
     * atualizar o registro Autor especificado pelo ‘ID’. Se a operação
     * for bem-sucedida, redireciona para a lista de autores com
     * uma mensagem de sucesso. Lida com exceções retornando uma
     * resposta de erro apropriada.
     *
     * @param Request $request Solicitação HTTP de entrada contendo os dados para atualizar o registro Autor.
     * @param int $id Identificador único do registro Autor a ser atualizado.
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate($this->getValidatorInput(), $this->getValidatorMessage());

        try {
            $autor = Autor::findOrFail($id);
            $autor->update($request->all());

            return redirect()->route('autores.index')->with('success', 'Autor atualizado com sucesso!');
        } catch (Exception $e) {
            return $this->handleException($e, 'Ocorreu um erro ao atualizar o autor.');
        }
    }

    /**
     * Remove o recurso Autor especificado pelo ID fornecido.
     *
     * Localiza o registro Autor pelo ID, executa a exclusão e redireciona
     * para a rota de listagem com uma mensagem de sucesso. Caso ocorra
     * uma falha, lida com a exceção retornando uma resposta de erro apropriada.
     *
     * @param int $id Identificador único do recurso Autor a ser excluído.
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $autor = Autor::findOrFail($id);
            $autor->delete();

            return redirect()->route('autores.index')->with('success', 'Autor excluído com sucesso!');
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
        return [
            'str_nome' => 'required|string|max:40',
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
    public function getValidatorMessage(): array
    {
        return [
            'str_nome.max' => 'O campo Nome do Autor(a) deve conter no máximo 40 caracteres.',
        ];
    }
}
