<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Usuario;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateServicoRequest;

class ServicoController extends Controller
{
    public function __construct(Request $request, Servico $servico, Usuario $usuario)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $servico;
        $this->usuario     = $usuario;
    }

    /**
     * Display a listing of the resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('c'))) ? 'ser_descricao' : $this->request->input('c');
        $dirOrder   = (empty($this->request->input('o'))) ? 'asc'  : $this->request->input('o');

        $clienteID = $this->request->session()->get('cliente-id');

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

        $servicos = $this->repositorio
            ->select(
                'servico.ser_codigo  as id',
                'servico.ser_descricao',
                'servico.ser_tipo_servico',
                'servico.ser_time_execucao',
                'servico.ser_status'
            )
            ->where('servico.ser_cliente', '=', $clienteID)
            ->where('servico.ser_descricao', $operador, $filtro)
            ->where('servico.ser_status', $opStatus, $ftrStatus)
            ->orderBy('servico.' . $campoOrder, $dirOrder)
            ->paginate(10);

        return view('admin.servico.index', [
            'titulo'     => 'Serviços',
            'servicos'   => $servicos,
            'pagination' => $servicos,
            'total'      => $servicos->total()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.servico.create', [
            'titulo'    => 'Novo Serviço'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  StoreUpdateServicoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateServicoRequest $request)
    {
        $data = $request->only(
            'ser_descricao',
            'ser_tipo_servico',
            'ser_time_execucao',
            'ser_status'
        );

        $clienteID = $this->request->session()->get('cliente-id');

        $data['ser_cliente']       = $clienteID;
        $data['ser_descricao']     = mb_strtoupper($request->ser_descricao, 'UTF-8');
        $data['ser_status']        = Servico::ATIVO;
        $data['ser_tipo_servico']  = $request->ser_tipo_servico;
        $data['ser_time_execucao'] = $request->ser_time_execucao;

        $this->repositorio->create($data);

        return redirect()->route('servico.create', 'success=true');
    }

    /**
     * Show the form for editing the specified resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servico = $this->repositorio->where(['ser_codigo' => $id])->first();

        if (!$servico) {
            return Redirect()->back();
        }

        $idUsuario = $this->request->session()->get('user-id');

        $usuario = $this->usuario->where(['usu_codigo' => $idUsuario])->first();
        $usuario = Util::usuarioLogado($usuario->usu_nome);

        return view('admin.servico.edit', [
            'titulo'  => 'Serviço',
            'servico' => $servico,
            'usuario' => $usuario
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  StoreUpdateServicoRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateServicoRequest $request, $id)
    {
        $servico = $this->repositorio->where(['ser_codigo' => $id])->first();

        $clienteID = $this->request->session()->get('cliente-id');

        $data['ser_cliente']       = $clienteID;
        $data['ser_descricao']     = mb_strtoupper($request->ser_descricao, 'UTF-8');
        $data['ser_tipo_servico']  = $request->ser_tipo_servico;
        $data['ser_time_execucao'] = $request->ser_time_execucao;
        $data['ser_status']        = $request->ser_status;

        $servico->update($data);

        return redirect('servico/' . $id . '/edit?edicao=true');
    }

    /**
     * Atualiza o Status do Produto
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $servico = $this->repositorio->where(['ser_codigo' => $id])->first();

        if ($servico->ser_status == Servico::ATIVO) {
            $servico->ser_status = Servico::INATIVO;
        } else {
            $servico->ser_status = Servico::ATIVO;
        }

        $servico->save();

        $pathInfo = explode('=', $this->request->getPathInfo());

        return redirect()->route('servico.index', ['page' => end($pathInfo)]);
    }
}
