<?php
namespace App\Contracts;

interface Validatable
{
    /**
     * Obter as regras de validação para os dados de entrada do modelo.
     *
     * @return array
     */
    public function getValidatorInput();

    /**
     * Obter as mensagend de validação para os dados de entrada do modelo.
     *
     * @return array
     */
    public function getValidatorMessage();
}
