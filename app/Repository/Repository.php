<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use stdClass;

class Repository
{
    private $instance;

    public function __construct()
    {
        $this->instance = DB::connection()->getPdo();
    }

    /**
     * Setando Instancia PDO
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param PDO $pdo
     */
    public function setInstance(PDO $pdo)
    {
        $this->instance = $pdo;
    }

    /**
     * Retornando Instancia PDO
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return PDO
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
