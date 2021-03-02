<?php

namespace App\Repository;

use stdClass;
use App\Models\Cliente;

class ClienteRepository extends Repository
{
    /**
     * Retornando todas as Concessionarias Matriz
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return array
     */
    public function getConcessionariasMatriz()
    {
        $matrizes = Cliente::where([
            'cli_status' => Cliente::ATIVO,
        ])->whereNull('cli_matriz')->get();

        $listaMatrizes = [];

        if (!empty($matrizes)) {
            foreach ($matrizes as $matriz) {
                $listaMatrizes[$matriz->cli_codigo] = $matriz->cli_nome;
            }
        }

        return $listaMatrizes;
    }
}
