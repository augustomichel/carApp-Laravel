<?php

namespace App\Http\Controllers\Api;

use App\Helper\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\UsuarioVeiculo;
use App\Models\Modelo;
use App\Models\Marca;
use App\Services\CondutorService;
use ErrorException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class CondutorApiController extends Controller
{
    const API_TOKEN_CONDUTOR = '952ac03Y115d5z18S3ar372827X2fdPf10a1c';

    public function __construct(Request $request, Usuario $usuario, UsuarioVeiculo $usuarioVeiculo)
    {
        $this->request = $request;
        $this->usuario = $usuario;
        $this->veiculo = $usuarioVeiculo;
    }

    /**
     * Exibir uma lista do recurso. (GET)
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->veiculo->all();
        return response()->json($data);
    }

    /**
     * Armazene um recurso recém-criado no armazenamento. (POST)
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @example 
     * {
     *  "cliente" : 1,
     *  "nome"  : "Juliano de Medeiros",
     *  "email" : "fernando@ig.com.br",
     *  "senha" : "123456",
     *  "veiculos" : [
     *  {
     *   "marca" : 3,
     *   "modelo" : 190,
     *   "placa" : "MBR2738",
     *   "KM_atual" : 184503
     *  },
     *  {
     *   "marca" : 3,
     *   "modelo" : 194,
     *   "placa" : "MBR2738",
     *   "KM_atual" : 184503
     *   }
     *  ]
     * }
     */
    public function store(Request $request)
    {
        try {
            if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
                throw new \Exception("Token inválido", 99);
            }

            $params = Util::validaJsonDataRaw($request->getContent());

            $this->usuario->validacaoCampos($params);
            $this->veiculo->validacaoCampos($params);
            $this->validandoAtributosReferences($params);

            $dataUsuario = $request->only(
                'usu_cliente',
                'usu_nivel',
                'usu_nome',
                'usu_email',
                'usu_senha',
                'usu_status',
                'usu_datetime'
            );

            $dataCriacao  = new \DateTime();

            $dataUsuario['usu_cliente']  = $params->cliente;
            $dataUsuario['usu_nivel']    = Usuario::CONDUTOR;
            $dataUsuario['usu_nome']     = $params->nome;
            $dataUsuario['usu_email']    = $params->email;
            $dataUsuario['usu_senha']    = md5($params->senha);
            $dataUsuario['usu_status']   = Usuario::ATIVO;
            $dataUsuario['usu_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

            //Validações do veiculo
            foreach ($params->veiculos as $veiculo) {
                $this->validandoVeiculo($veiculo);
            }

            //Adicionando Usuario Condutor
            $retornoUsuario = $this->usuario->create($dataUsuario);

            //Adicionando Veiculos
            foreach ($params->veiculos as $veiculo) {
                $dataVeiculo['usv_usuario']  = $retornoUsuario->usu_codigo;
                $dataVeiculo['usv_placa']    = $veiculo->placa;
                $dataVeiculo['usv_marca']    = $veiculo->marca;
                $dataVeiculo['usv_modelo']   = $veiculo->modelo;
                $dataVeiculo['usv_versao']   = null;
                $dataVeiculo['km_atual']     = $veiculo->km_atual;
                $dataVeiculo['usv_status']   = UsuarioVeiculo::ATIVO;
                $dataVeiculo['usv_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

                $this->veiculo->create($dataVeiculo);
            }

            unset($retornoUsuario->usu_senha);
            unset($retornoUsuario->usu_status);

            //enviando email de confirmação de cadastro do condutor
            $condutorService = new CondutorService();
            $condutorService->confirmacaoCondutor($retornoUsuario);

            return response()->json([
                'info'   => true,
                'result' => $retornoUsuario
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
                'result' => 'Não foi possível realizar a inclusão do usuario',
                'error'  => $error
            ], 404);
        }
    }

    /**
     * Retornando as marcas de veiculos
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function marca(Request $request)
    {
        if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
            throw new \Exception("Token inválido", 99);
        }

        return Marca::all();
    }

    /**
     * Retornando os modelos de uma Marca
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function modelo(Request $request)
    {
        if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
            throw new \Exception("Token inválido", 99);
        }

        return Modelo::where('mod_marca', $request->marca)->get();
    }

    /**
     * Setando atributos referenciados na table pedidos
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json  $params
     */
    public function validandoAtributosReferences(&$params)
    {
        if (!empty(Usuario::where('usu_email', $params->email)->first())) {
            throw new \InvalidArgumentException('Email informado pertence a um cliente Já cadastrado');
        }
    }

    /**
     * Validando dados do Veiculo
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Json $veiculo
     */
    public function validandoVeiculo($veiculo)
    {
        $modelo = Modelo::where(['mod_codigo' => $veiculo->modelo])
            ->where('mod_marca', '=', $veiculo->marca)
            ->first();

        if (empty($modelo)) {
            throw new \Exception('Modelo informado não reconhecido para a Marca Informada!', 99);
        }

        $veiculo = UsuarioVeiculo::where(['usv_modelo' => $veiculo->modelo])
            ->where('usv_marca', '=', $veiculo->marca)
            ->where('usv_placa', '=', $veiculo->placa)
            ->first();

        if (!empty($veiculo)) {
            throw new \Exception('Veiculo informado já cadastrado anteriormente!', 99);
        }
    }
}
