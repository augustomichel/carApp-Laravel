<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioServico extends Model
{
    const INATIVO           = 0;
    const AGENDADO          = 1;
    const OFICINA           = 2;
    const EXECUCAO          = 3;
    const POSEXEC           = 4;
    const LAVACAO           = 5;
    const PREENTREGA        = 6;
    const FINALIZADO        = 7;

    protected $table = 'usuario_servico';
    protected $primaryKey = 'uss_codigo';
    public $timestamps = false;

    protected $fillable = [
        'usuario_usu_codigo',
        'cliente_cli_codigo',
        'cli_codigo',
        'usv_codigo',
        'uss_ser_codigo',
        'usu_codigo_solicitante',
        'usu_codigo_executor',
        'pro_codigo',
        'uss_observacao',
        'uss_status',
        'uss_datetime_entrega',
        'uss_datetime_inicio',
        'uss_datetime_finalizacao',
        'uss_descricao_avalizacao',
        'uss_datetime_avaliacao',
        'uss_datetime'
    ];

   /**
     * Validando dados do servico
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $servico
     */
    public function validandoServico($veiculoId, $usuario_servico)
    {
        $veiculo = UsuarioServico::where(['usv_codigo' => $veiculoId])
            ->where('uss_status', '=', UsuarioServico::EXECUCAO)
            ->first();

        if (!empty($veiculo)) {
            throw new \InvalidArgumentException('Veículo possui serviço em Execução!');
        }

        $veiculo = UsuarioServico::where(['uss_codigo' => $usuario_servico])
        ->where('uss_status', '=', UsuarioServico::FINALIZADO)
        ->first();

        if (!empty($veiculo)) {
            throw new \InvalidArgumentException('Serviço já finalizado!');
        }
    }

       /**
     * Validando dados do servico
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $servico
     */
    public function validandoAgendamento($veiculoId)
    {
        $usuario_servico = UsuarioServico::where(['usv_codigo' => $veiculoId])
            ->where('uss_status', '<>', UsuarioServico::FINALIZADO)
            ->first();

        if (!empty($usuario_servico)) {
            if ($usuario_servico->uss_status <> UsuarioServico::AGENDADO) {
                throw new \InvalidArgumentException('Veículo já esta na oficina!' );
            } else {
                throw new \InvalidArgumentException('Veículo já possue agendamento!');
            }
        }
    }
}
