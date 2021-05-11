<?php

namespace App\Services;

use App\Repository\ClienteRepository;
use stdClass;

class ClienteService
{
    public function __construct(ClienteRepository $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    /**
     * Retornando todas as Concessionarias Matriz
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return array
     */
    public function getConcessionariasMatriz()
    {
        return $this->repositorio->getConcessionariasMatriz();
    }
}
