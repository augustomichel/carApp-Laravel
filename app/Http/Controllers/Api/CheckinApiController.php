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

class CheckinApiController extends Controller
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
     *  "user" : 1,
     *  "observacao" : "Inicio da atividade",
     *  "uss_codigo" : 1
     * }
     */
    public function store(Request $request)
    {
        try {
            if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
                throw new \Exception("Token inválido", 99);
            }

            $params = Util::validaJsonDataRaw($request->getContent());
            
            $dataRegistro = new \DateTime();
            //atualizando status
            $servico = $this->usuarioservico->where(['uss_codigo' => $params->uss_codigo])->first();

            switch ($servico->uss_status) {
                case UsuarioServico::AGENDADO:
                    $servico->uss_status          = UsuarioServico::OFICINA;
                    $servico->uss_datetime_inicio = $dataRegistro->format('Y-m-d H:i:s'); 
                    break;
                case UsuarioServico::OFICINA:
                    $this->usuarioservico->validandoServico($servico->usv_codigo, $servico->uss_codigo);
                    $servico->uss_status          = UsuarioServico::EXECUCAO; 
                    break;
                case UsuarioServico::EXECUCAO:
                    $servico->uss_status = UsuarioServico::POSEXEC;
                    break;
                case UsuarioServico::POSEXEC:
                    $servico->uss_status = UsuarioServico::LAVACAO;
                    break;
                case UsuarioServico::LAVACAO:
                    $servico->uss_status = UsuarioServico::PREENTREGA;
                    break;    
                default:
                    $this->usuarioservico->validandoServico($servico->usv_codigo, $servico->uss_codigo);
                    $servico->uss_status = UsuarioServico::FINALIZADO;
                    break;
            }

            $servico->uss_observacao = $params->observacao;
            $servico->usu_codigo_executor = $params->user ;
            
            $servico->update();
            //Validações do usuario
            //$this->validandoServico($params);

            //Adicionar usuario_servico_info
            $data['usuario_servico_uss_codigo'] = $servico->uss_codigo;
            $data['usi_descricao']              = mb_strtoupper($params->observacao, 'UTF-8');
            $data['usu_codigo']                 = $params->user;
            $data['usi_datetime']               = $dataRegistro->format('Y-m-d H:i:s');
            $data['usi_status_checkin']         = $servico->uss_status;

            $returnServico = $this->servicoinfo->create($data);
            
             //atualiza a data fim do servico_info anterior
             $statusAnteriro = $servico->uss_status - 1;
             if ($statusAnteriro < 1) {
                 $statusAnteriro = 1;
             }
             
             $servicoinfo = $this->servicoinfo->where(['usuario_servico_uss_codigo' => $servico->uss_codigo])
                 ->where(['usi_status_checkin' => $statusAnteriro])
                 ->first();
 
             if ($servicoinfo){    
                 $servicoinfo->usi_datetime_fim  = $dataRegistro->format('Y-m-d H:i:s') ;
                 $servicoinfo->update();  
             }
             
            return response()->json([
                'info'   => true,
                'result' => $returnServico
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
