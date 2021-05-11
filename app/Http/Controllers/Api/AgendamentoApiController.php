<?php

namespace App\Http\Controllers\Api;

use App\Helper\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Servico;
use App\Models\UsuarioServico;
use App\Models\UsuarioServicoInfo;
use ErrorException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class AgendamentoApiController extends Controller
{
    const API_TOKEN_CONDUTOR = '952ac03Y115d5z18S3ar372827X2fdPf10a1c';

    public function __construct(Request $request, Servico $servico, UsuarioServico $usuarioservico,  UsuarioServicoInfo $usuarioservicoinfo)
    {
        $this->request = $request;
        $this->servico = $servico;
        $this->usuarioservico = $usuarioservico;
        $this->servicoinfo = $usuarioservicoinfo;
    }

    /**
     * Exibir uma lista do recurso. (GET)
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->servico->all();
        return response()->json($data);
    }

    /**
     * Armazene um recurso rec�m-criado no armazenamento. (POST)
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @example 
     * {
     *  "usuario_usu_codigo" : 1,       codusuario
     *  "cliente_cli_codigo" : 1,       cod_consecionaria
     *  "usv_codigo" : 1,               codigo veiculo 
     *  "uss_ser_codigo" : 1,           cod servico
     *  "uss_datetime_inicio" : "29-04-2021"   data agendada
     * }
     */
    public function store(Request $request)
    {
        try {
            if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
                throw new \Exception("Token inválido", 99);
            }

            $params = Util::validaJsonDataRaw($request->getContent());
            
            $this->usuarioservico->validandoAgendamento($params->usv_codigo);

            $dataRegistro = new \DateTime();

            $DataAgendamento = date('Y-m-d', strtotime($params->uss_datetime_inicio));
            //Adicionar usuario_servico
            $data['usuario_usu_codigo']     = $params->usuario_usu_codigo;
            $data['cliente_cli_codigo']     = $params->cliente_cli_codigo;
            $data['usv_codigo']             = $params->usv_codigo;
            $data['uss_ser_codigo']         = $params->uss_ser_codigo;
            $data['uss_datetime_inicio']    = $DataAgendamento;

            $returnusuarioservico = $this->usuarioservico->create($data);         
             
            return response()->json([
                'info'   => true,
                'result' => $returnusuarioservico
            ], 201);
        } catch (\Exception $e) {

            if (substr_count($e->getMessage(), 'Connection refused') > 0) {
                $error = 'Problema ao se conectar com a base de dados!';
            } elseif ($e instanceof QueryException) {
                dd($e->getMessage());
                $error = 'Error query Exception database!';
            } else {
                $error = $e->getMessage();
            }

            return response()->json([
                'info'  => false,
                'result' => 'Não foi possível realizar o Check-In do serviço',
                'error'  => $error
            ], 404);
        }
    }

  
     

}
