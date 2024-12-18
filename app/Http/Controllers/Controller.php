<?php

namespace App\Http\Controllers;

use App\Contracts\Validatable;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

abstract class Controller implements Validatable
{
    /**
     * Lida com uma exceção registrando o erro, adicionando-o à sessão e redirecionando para uma rota especificada.
     *
     * @param Exception $e A exceção a ser tratada.
     * @param string $message Uma mensagem de erro a ser armazenada na sessão.
     * @param array $routeParams Parâmetros a serem passados para a rota de redirecionamento.
     * @return RedirectResponse Uma resposta de redirecionamento para a rota especificada com erros.
     */
    protected function handleException(Exception $e, string $message, array $routeParams = []): RedirectResponse
    {
        // Logar a exceção para monitoramento
        Log::error($e->getMessage(), [
            'exception' => $e->getTraceAsString(), // Apenas o stack trace como string
        ]);

        // Armazenar mensagem e código simples na sessão
        Session::flash('error', $message);
        Session::flash('exception', [
            'message' => $e->getMessage(),
            'code'    => $e->getCode(),
        ]);

        // Redirecionar para a rota com erros
        return redirect()->route($this->getPathView(), $routeParams)->withErrors(['error' => $message]);
    }


    /**
     * Retorna o caminho da visualização baseado no nome do método chamador e no nome da classe do controlador.
     *
     * @return string O caminho formatado da visualização.
     */
    protected function getPathView()
    {
        // Obtém o nome do método que está chamando a função
        $callingMethod = debug_backtrace()[1]['function'];

        // Obtém o nome da classe atual (controller)
        $controllerClass = get_class($this);

        // Remove 'Controller' do nome da classe
        $controllerBaseName = str_replace('Controller', '', class_basename($controllerClass));

        // Define o mapeamento de métodos para views customizadas
        $methodViewMapping = [
            'update'  => 'index', // Exemplo: o método update redireciona para a view 'index'
            'store'   => 'index', // O método store pode redirecionar para 'index'
            'destroy' => 'index', // O método store pode redirecionar para 'index'
            // Adicione mais mapeamentos conforme sua necessidade
        ];

        // Se houver um mapeamento para o método chamado, usa-o
        if (array_key_exists($callingMethod, $methodViewMapping)) {
            $viewName = $methodViewMapping[$callingMethod];
        } else {
            // Caso contrário, usa o nome do método como nome da view
            $viewName = $callingMethod === 'handleException' ? 'index' : $callingMethod;
        }

        // Retorna o caminho da view no formato correto (exemplo: 'assuntos.index')
        return strtolower($controllerBaseName) . 's.' . $viewName;
    }
}
