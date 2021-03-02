<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Usuario;
use App\Models\UsuarioVeiculo;
use App\Services\CondutorService;

class HomeController extends Controller
{
    public function __construct(Request $request, Usuario $usuario, UsuarioVeiculo $usuarioVeiculo)
    {
        // $this->middleware('auth');

        $this->request = $request;
        $this->usuario = $usuario;
        $this->veiculo = $usuarioVeiculo;
    }

    public function index()
    {
        return View('front.home.index', [
            'titulo'  => 'Dashboard',
            'usuario' => 'Fernando'
        ]);
    }

    /**
     * Montando formulario de inscricao de condutor
     * @author Augusto Michel <augustomichel@gmail.com>
     */
    public function condutor()
    {
        $marcas = Marca::orderBy('mac_nome', 'ASC')->get();

        return View('front.condutor.index', [
            'titulo'  => 'Contato',
            'usuario' => 'Fernando',
            'marcas'  => $marcas,
            'error'   => null,
            'success' => null
        ]);
    }

    /**
     * Gravando registro de novo condutor
     * @author Augusto Michel <augustomichel@gmail.com>
     */
    public function condutorStore(Request $request)
    {
        $marcas = Marca::orderBy('mac_nome', 'ASC')->get();

        try {
            $this->validacaoCampos($request);
            $this->validandoAtributosReferences($request->usu_email);

            $dataCriacao  = new \DateTime();

            $dataUsuario['usu_cliente']  = 1; //TEM QUE PEGAR DA CONFIGURAÇÃO DO ENV
            $dataUsuario['usu_nivel']    = Usuario::CONDUTOR;
            $dataUsuario['usu_nome']     = $request->usu_nome;
            $dataUsuario['usu_email']    = $request->usu_email;
            $dataUsuario['usu_senha']    = md5($request->usu_senha);
            $dataUsuario['usu_status']   = Usuario::ATIVO;
            $dataUsuario['usu_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

            $y = 0;
            foreach ($request->marca as $marca) {
                $this->validandoVeiculo($request->marca[$y], $request->modelo[$y], $request->placa[$y]);
                $y++;
            }

            $retornoUsuario = $this->usuario->create($dataUsuario);

            if (!empty($request->marca)) {
                $i = 0;
                foreach ($request->marca as $marca) {
                    $dataVeiculo['usv_usuario']  = $retornoUsuario->usu_codigo;
                    $dataVeiculo['usv_placa']    = $request->placa[$i];
                    $dataVeiculo['usv_marca']    = $marca[$i];
                    $dataVeiculo['usv_modelo']   = $request->modelo[$i];
                    $dataVeiculo['usv_versao']   = null;
                    $dataVeiculo['km_atual']     = $request->km[$i];
                    $dataVeiculo['usv_status']   = UsuarioVeiculo::ATIVO;
                    $dataVeiculo['usv_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

                    $this->veiculo->create($dataVeiculo);
                    $i++;
                }
            }

            //enviando email de confirmação de cadastro do condutor
            $condutorService = new CondutorService();
            $condutorService->confirmacaoCondutor($retornoUsuario);

            return View('front.condutor.index', [
                'titulo'  => 'Contato',
                'usuario' => 'Fernando',
                'marcas'  => $marcas,
                'error'   => null,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return View('front.condutor.index', [
                'titulo'  => 'Contato',
                'usuario' => 'Fernando',
                'marcas'  => $marcas,
                'error'   => $e->getMessage(),
                'success' => false
            ]);
        }
    }

    public function contato()
    {
        return View('front.contato.index', [
            'titulo'  => 'Contato',
            'usuario' => 'Fernando'
        ]);
    }

    public function manager()
    {
        return View('front.login.index', [
            'titulo'  => 'Dashboard',
            'usuario' => 'Fernando'
        ]);
    }

    /**
     * Retornando Modelos de uma Marca
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return Json
     */
    public function modelo(Request $request, $id)
    {
        return Modelo::where(['mod_marca' => $id])->get();
    }

    public function forgot()
    {
        return View('front.login.recuperar-senha', [
            'titulo'  => 'Dashboard',
            'usuario' => 'Fernando'
        ]);
    }

    /**
     * Validação dos Campos de Cadastro de novo condutor
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Request $request
     */
    public function validacaoCampos(Request $request)
    {
        if (empty($request->usu_nome)) {
            throw new \Exception('Nome não informado!', 99);
        }

        if (empty($request->usu_email)) {
            throw new \Exception('Email não informado!', 99);
        }

        if (empty($request->usu_senha)) {
            throw new \Exception('Senha não informada!', 99);
        }

        if (count($request->marca) == 0) {
            throw new \Exception('Veiculo não informado!', 99);
        }

        $i = 0;
        foreach ($request->marca as $marca) {
            if (empty($marca[$i])) {
                throw new \Exception('Marca não informada!', 99);
            }

            if (empty($request->modelo[$i])) {
                throw new \Exception('Modelo não informado!', 99);
            }

            if (empty($request->placa[$i])) {
                throw new \Exception('Placa não informada!', 99);
            }

            $i++;
        }
    }

    /**
     * Validando campo de email do novo usuario
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param String  $email
     */
    public function validandoAtributosReferences($email)
    {
        if (!empty(Usuario::where('usu_email', $email)->first())) {
            throw new \InvalidArgumentException('Email informado pertence a um cliente Já cadastrado');
        }
    }

    /**
     * Validando dados do Veiculo
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param integer $marca
     * @param integer $modelo
     * @param string $placa
     */
    public function validandoVeiculo($marca, $modelo, $placa)
    {
        $modelo = Modelo::where(['mod_codigo' => $modelo])
            ->where('mod_marca', '=', $marca)
            ->first();

        if (empty($modelo)) {
            throw new \Exception('Modelo informado não reconhecido para a Marca Informada!', 99);
        }

        $placa = UsuarioVeiculo::where(['usv_placa' => $placa])->first();

        if (!empty($placa)) {
            throw new \Exception('Placa informada já cadastrada!', 99);
        }

        $veiculo = UsuarioVeiculo::where(['usv_modelo' => $modelo])
            ->where('usv_marca', '=', $marca)
            ->where('usv_placa', '=', $placa)
            ->first();

        if (!empty($veiculo)) {
            throw new \Exception('Veiculo informado já cadastrado anteriormente!', 99);
        }
    }
}
