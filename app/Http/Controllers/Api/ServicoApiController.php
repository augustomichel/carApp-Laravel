<?php

namespace App\Http\Controllers\Api;

use App\Helper\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Servico;
use ErrorException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class ServicoApiController extends Controller
{
    const API_TOKEN_CONDUTOR = '952ac03Y115d5z18S3ar372827X2fdPf10a1c';

    public function __construct(Request $request, Servico $servico)
    {
        $this->request = $request;
        $this->servico = $servico;
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
     *  "cliente" : 1,
     *  "descricao" : "TROCA DE FILTRO DE AR",
     *  "tipo_servico" : 1,
     *  "time_execucao" : 110,
     *  "status" : "S"
     * }
     */
    public function store(Request $request)
    {
        try {
            if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
                throw new \Exception("Token inválido", 99);
            }

            $params = Util::validaJsonDataRaw($request->getContent());
            
            $dataCriacao  = new \DateTime();

            //Validações do usuario
            $this->validandoServico($params);

            //Adicionar servico
            $data['ser_cliente']       = $params->cliente;
            $data['ser_descricao']     = mb_strtoupper($params->descricao, 'UTF-8');
            $data['ser_tipo_servico']  = $params->tipo_servico;
            $data['ser_time_execucao'] = $params->time_execucao;
            $data['ser_status']        = $params->status;

            $returnServico = $this->servico->create($data);
            
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
                'result' => 'Não foi possível realizar a inclusão do serviço',
                'error'  => $error
            ], 404);
        }
    }

  
     /**
     * Validando dados do servico
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $servico
     */
    public function validandoServico($servico)
    {
        $servico = Servico::where(['ser_descricao' => $servico->descricao])
        ->first();

        if (!empty($servico)) {
            throw new \Exception('Serviço informado já cadastrado anteriormente!', 99);
        }
    
    }

      /**
     * Retornando os serviços
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function servicos(Request $request)
    {
        if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
            throw new \Exception("Token inválido", 99);
        }

        if ($request->input('ser_codigo')) {
            return Servico::where(['ser_codigo' => $request->input('ser_codigo')])->get();          
        } else {
            return servico::all();
        }
        
       
        
    }


}
