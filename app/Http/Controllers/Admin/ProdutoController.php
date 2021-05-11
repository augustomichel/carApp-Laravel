<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Usuario;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateProdutoRequest;

class ProdutoController extends Controller
{
    public function __construct(Request $request, Produto $produto, Usuario $usuario)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $produto;
        $this->usuario     = $usuario;
    }

    /**
     * Display a listing of the resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('c'))) ? 'pro_nome' : $this->request->input('c');
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

        $produtos = $this->repositorio
            ->select(
                'produto.pro_nome',
                'produto.pro_codigo  as id',
                'produto.pro_status'
            )
            ->join('cliente', 'produto.pro_cliente', '=', 'cliente.cli_codigo')
            ->where('produto.pro_cliente', '=', $clienteID)
            ->where('produto.pro_nome', $operador, $filtro)
            ->where('produto.pro_status', $opStatus, $ftrStatus)
            ->orderBy('produto.' . $campoOrder, $dirOrder)
            ->paginate(10);

        return view('admin.produto.index', [
            'titulo'     => 'Produtos',
            'produtos'   => $produtos,
            'pagination' => $produtos,
            'total'      => $produtos->total()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.produto.create', [
            'titulo' => 'Novo Produto'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  StoreUpdateProdutoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProdutoRequest $request)
    {
        $dataCriacao = new \DateTime();
        $clienteID = $this->request->session()->get('cliente-id');

        $data = $request->only(
            'pro_nome',
            'pro_cliente',
            'pro_status',
            'pro_datetime'
        );

        $data['pro_cliente']  = $clienteID;
        $data['pro_nome']     = mb_strtoupper($request->pro_nome, 'UTF-8');
        $data['pro_status']   = Produto::ATIVO;
        $data['pro_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

        $this->repositorio->create($data);

        return redirect()->route('produto.create', 'success=true');
    }

    /**
     * Show the form for editing the specified resource.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = $this->repositorio->where(['pro_codigo' => $id])->first();

        if (!$produto) {
            return Redirect()->back();
        }

        return view('admin.produto.edit', [
            'titulo'  => 'Produto',
            'produto' => $produto
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  StoreUpdateProdutoRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProdutoRequest $request, $id)
    {
        $produto = $this->repositorio->where(['pro_codigo' => $id])->first();

        $data['pro_nome']   = mb_strtoupper($request->pro_nome, 'UTF-8');
        $data['pro_status'] = $request->pro_status;

        $produto->update($data);

        return redirect('produto/' . $id . '/edit?edicao=true');
    }

    /**
     * Atualiza o Status do Produto
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $produto = $this->repositorio->where(['pro_codigo' => $id])->first();

        if ($produto->pro_status == Produto::ATIVO) {
            $produto->pro_status = Produto::INATIVO;
        } else {
            $produto->pro_status = Produto::ATIVO;
        }

        $produto->save();

        $pathInfo = explode('=', $this->request->getPathInfo());

        return redirect()->route('produto.index', ['page' => end($pathInfo)]);
    }
}
