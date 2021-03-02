<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioVeiculo extends Model
{
    const INATIVO           = 0;
    const ATIVO             = 1;

    public $timestamps = false;

    protected $table = 'usuario_veiculo';
    protected $primaryKey = 'usv_codigo';

    protected $fillable = [
        'usv_codigo', 'usv_usuario', 'usv_placa', 'usv_marca', 'usv_modelo', 'usv_versao', 'km_atual', 'usv_datetime'
    ];

    /**
     * Realizando validacao dos campos recebidos API Rest Condutor
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $params
     */
    public function validacaoCampos($params)
    {
        if (count($params->veiculos) == 0) {
            throw new \Exception('Veiculo não informado!', 99);
        }

        foreach ($params->veiculos as $veiculo) {
            if (empty($veiculo->marca)) {
                throw new \Exception('Marca não informada!', 99);
            }

            if (empty($veiculo->modelo)) {
                throw new \Exception('Modelo não informado!', 99);
            }

            if (empty($veiculo->placa)) {
                throw new \Exception('Placa não informada!', 99);
            }
        }
    }
}
