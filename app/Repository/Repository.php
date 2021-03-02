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
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param PDO $pdo
     */
    public function setInstance(PDO $pdo)
    {
        $this->instance = $pdo;
    }

    /**
     * Retornando Instancia PDO
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return PDO
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
