<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsuarioVeiculo;
use App\Models\Modelo;
use App\Models\Marca;

class VeiculoController extends Controller
{
    public function __construct(
        Request $request,     
        UsuarioVeiculo $veiculo
    ) {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $veiculo;
        $this->veiculo     = $veiculo;
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('v'))) ? 'usv_placa' : $this->request->input('v');
        $dirOrder   = (empty($this->request->input('o'))) ? 'asc'  : $this->request->input('o');

        $user =  $this->request->session()->get('user-id');
        
        if (!empty($this->request->input('s'))) {
            $busca = strtoupper(trim($this->request->input('s')));
            $operador = 'like';
            $filtro = "%$busca%";
        } else {
            $operador = '<>';
            $filtro   = '00';
        }

        $veiculos = $this->repositorio
            ->select(
               
                'usuario_veiculo.usv_codigo',
                'usuario_veiculo.usv_usuario',
                'usuario_veiculo.usv_placa', 
                'usuario_veiculo.usv_marca', 
                'usuario_veiculo.usv_modelo', 
                'usuario_veiculo.usv_versao', 
                'usuario_veiculo.km_atual', 
                'usuario_veiculo.usv_datetime'
                
            )
            ->where('usuario_veiculo.usv_usuario', "=" , $user)
            ->where('usuario_veiculo.usv_placa', $operador, $filtro)
            ->orderBy('usuario_veiculo.' . $campoOrder, $dirOrder)
            ->paginate(10);
            
        $veiculos = $this->tratarDadosVeiculos($veiculos);
       
        return view('front.veiculo.index', [
            'titulo'     => 'Concessionárias',
            'veiculos'   => $veiculos,
            'pagination' => $veiculos,
            'total'      => $veiculos->total()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::orderBy('mac_nome', 'ASC')->get();
               
        return view('front.veiculo.create', [
            'titulo'    => 'Novo Veículo',
            'usuario' => $this->request->session()->get('user-id'),
            'marcas'  => $marcas,
            'error'   => null,
            'success' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  StoreUpdateVeiculoClienteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {            
            $marcas = Marca::orderBy('mac_nome', 'ASC')->get();
            $dataCriacao  = new \DateTime();
            $user =  $this->request->session()->get('user-id');

            $this->validacaoCampos($request);
            
            $this->validandoVeiculo($request->usv_marca, $request->usv_modelo, $request->usv_placa);

            $data = $request->only(                    
                'usv_placa',
                'usv_marca',
                'usv_modelo',

            );

            $dataVeiculo['usv_usuario']  = $user;
            $dataVeiculo['usv_placa']    = $request->usv_placa;
            $dataVeiculo['usv_marca']    = $request->usv_marca;
            $dataVeiculo['usv_modelo']   = $request->usv_modelo;
            $dataVeiculo['usv_versao']   = null;
            $dataVeiculo['km_atual']     = $request->km_atual;
            $dataVeiculo['usv_status']   = UsuarioVeiculo::ATIVO;
            $dataVeiculo['usv_datetime'] = $dataCriacao->format('Y-m-d H:i:s');
            
            $this->veiculo->create($dataVeiculo);                

            return View('front.veiculo.create', [
                'titulo'  => 'Veículos',
                'usuario' => $user,
                'marcas'  => $marcas,
                'error'   => false,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return View('front.veiculo.create', [
                'titulo'  => 'Veículos',
                'usuario' => $user,
                'marcas'  => $marcas,
                'error'   => $e->getMessage(),
                'success' => false
            ]);
        }    
    }

    
    /**
     * Tratando os dados antes da Renderização
     * @author Augusto Michel <augustomichel@gmail.com>
     * @params LengthAwarePaginator veiculos
     */
    public function tratarDadosVeiculos($veiculos)
    {
        foreach ($veiculos as $veiculo) {
            $veiculo->usv_marca = Marca::where(['mac_codigo' => $veiculo->usv_marca])->get('mac_nome');
            $veiculo->usv_modelo = Modelo::where(['mod_codigo' => $veiculo->usv_modelo])->get('mod_nome');
        }

        return $veiculos;
    }

     /**
     * Validação dos Campos de Cadastro de novo veiculo
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param Request $request
     */
    public function validacaoCampos(Request $request)
    {
        if (empty($request->usv_marca)) {
            throw new \Exception('Marca não informada!', 99);
        }

        if (empty($request->usv_modelo)) {
            throw new \Exception('Modelo não informado!', 99);
        }

        if (empty($request->usv_placa)) {
            throw new \Exception('Placa não informada!', 99);
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
