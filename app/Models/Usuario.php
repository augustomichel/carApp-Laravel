<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    const INATIVO           = 'N';
    const ATIVO             = 'S';

    const ROOT              = 1;
    const ADMIN             = 2;
    const AUDITOR           = 3;
    const ATENDENTE         = 4;
    const MECANICO          = 5;
    const CONDUTOR          = 6;

    public $timestamps = false;

    protected $table = 'usuario';
    protected $primaryKey = 'usu_codigo';

    protected $fillable = [
        'usu_nome', 'usu_cliente', 'usu_email', 'usu_senha', 'usu_nivel', 'usu_status', 'usu_datetime'
    ];

    /**
     * Realizando validacao dos campos recebidos API Rest Condutor
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $params
     */
    public function validacaoCampos($params)
    {
        if (empty($params->cliente)) {
            throw new \Exception('Cliente não informado!', 99);
        }

        if (empty($params->nome)) {
            throw new \Exception('Nome não informado!', 99);
        }

        if (empty($params->email)) {
            throw new \Exception('Email não informado!', 99);
        }

        if (empty($params->senha)) {
            throw new \Exception('Senha não informada!', 99);
        }
    }
}
