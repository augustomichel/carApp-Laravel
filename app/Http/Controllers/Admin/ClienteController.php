<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateClienteRequest;
use App\Services\ClienteService;

class ClienteController extends Controller
{
    public function __construct(
        Request $request,
        Cliente $cliente,
        Usuario $usuario,
        ClienteService $service
    ) {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $cliente;
        $this->usuario     = $usuario;
        $this->service     = $service;
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('c'))) ? 'cli_nome' : $this->request->input('c');
        $dirOrder   = (empty($this->request->input('o'))) ? 'asc'  : $this->request->input('o');

        if (!empty($this->request->input('s'))) {
            $busca = strtoupper(trim($this->request->input('s')));
            $operador = 'like';
            $filtro = "%$busca%";
        } else {
            $operador = '<>';
            $filtro   = '00';
        }

        if ($this->request->input('f') != '') {
            $status = strtoupper(trim($this->request->input('f')));
            $opStatus  = '=';
            $ftrStatus = $status;
        } else {
            $opStatus  = '=';
            $ftrStatus = 'S';
        }

        $clientes = $this->repositorio
            ->select(
                'cliente.cli_nome',
                'cliente.cli_codigo  as id',
                'cliente.cli_cnp',
                'cliente.cli_status',
                'cliente.cli_matriz'
            )
            ->where('cliente.cli_nome', $operador, $filtro)
            ->where('cliente.cli_status', $opStatus, $ftrStatus)
            ->orderBy('cliente.' . $campoOrder, $dirOrder)
            ->paginate(10);

        $matrizes = $this->service->getConcessionariasMatriz();

        $clientes = $this->tratarDadosCliente($clientes);

        return view('admin.cliente.index', [
            'titulo'     => 'Concessionárias',
            'clientes'   => $clientes,
            'matrizes'   => $matrizes,
            'pagination' => $clientes,
            'total'      => $clientes->total()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matrizes = Cliente::where([
            'cli_status' => Cliente::ATIVO,
        ])->whereNull('cli_matriz')->get();

        return view('admin.cliente.create', [
            'titulo'    => 'Novo Cliente',
            'matrizes'  => $matrizes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  StoreUpdateClienteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateClienteRequest $request)
    {
        $dataCriacao = new \DateTime();

        $data = $request->only(
            'cli_nome',
            'cli_cnp',
            'cli_status',
            'cli_datetime',
            'cli_matriz'
        );

        $data['cli_nome']     = mb_strtoupper($request->cli_nome, 'UTF-8');
        $data['cli_status']   = Cliente::ATIVO;
        $data['cli_cnp']      = $request->cli_cnp;
        $data['cli_datetime'] = $dataCriacao->format('Y-m-d H:i:s');
        $data['cli_matriz']   = $request->cli_matriz;

        $this->repositorio->create($data);

        return redirect()->route('cliente.create', 'success=true');
    }

    /**
     * Show the form for editing the specified resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = $this->repositorio->where(['cli_codigo' => $id])->first();

        if (!$cliente) {
            return Redirect()->back();
        }

        $matrizes = Cliente::where([
            'cli_status' => Cliente::ATIVO,
        ])->whereNull('cli_matriz')->whereNotIn('cli_codigo', [$id])->get();

        return view('admin.cliente.edit', [
            'titulo'   => 'Cliente',
            'cliente'  => $cliente,
            'matrizes' => $matrizes
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  StoreUpdateClienteRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClienteRequest $request, $id)
    {
        $cliente = $this->repositorio->where(['cli_codigo' => $id])->first();

        $data['cli_nome']   = mb_strtoupper($request->cli_nome, 'UTF-8');
        $data['cli_cnp']    = $request->cli_cnp;
        $data['cli_status'] = $request->cli_status;
        $data['cli_matriz'] = $request->cli_matriz;

        $cliente->update($data);

        return redirect('cliente/' . $id . '/edit?edicao=true');
    }

    /**
     * Atualiza o Status do Produto
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $cliente = $this->repositorio->where(['cli_codigo' => $id])->first();

        if ($cliente->cli_status == Cliente::ATIVO) {
            $cliente->cli_status = Cliente::INATIVO;
        } else {
            $cliente->cli_status = Cliente::ATIVO;
        }

        $cliente->save();

        $pathInfo = explode('=', $this->request->getPathInfo());

        return redirect()->route('cliente.index', ['page' => end($pathInfo)]);
    }

    /**
     * Tratando os dados antes da Renderização
     * @author Augusto Michel <augustomichel@gmail.com>
     * @params LengthAwarePaginator clientes
     */
    public function tratarDadosCliente($clientes)
    {
        foreach ($clientes as $cliente) {
            $cliente->cli_cnp = Util::formata_cpf_cnpj($cliente->cli_cnp);
        }

        return $clientes;
    }
}
