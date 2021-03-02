<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\UsuarioNivel;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateUsuarioRequest;

class UsuarioController extends Controller
{
    public function __construct(Request $request, Usuario $usuario)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $usuario;
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('c'))) ? 'usu_nome' : $this->request->input('c');
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

        $usuarios = $this->repositorio
            ->select(
                'usuario.usu_nome',
                'usuario.usu_codigo  as id',
                'usuario.usu_email',
                'usuario.usu_nivel',
                'usuario.usu_status',
                'usuario_nivel.usn_descricao as nome_nivel'
            )
            ->join('usuario_nivel', 'usuario.usu_nivel', '=', 'usuario_nivel.usn_codigo')
            ->where('usuario.usu_cliente', '=', $clienteID)
            ->where('usuario.usu_nome', $operador, $filtro)
            ->where('usuario.usu_status', $opStatus, $ftrStatus)
            ->where('usuario.usu_codigo', '<>', 1)
            ->orderBy('usuario.' . $campoOrder, $dirOrder)
            ->paginate(10);

        return view('admin.usuario.index', [
            'titulo'     => 'Usuários',
            'usuarios'   => $usuarios,
            'pagination' => $usuarios,
            'total'      => $usuarios->total()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id        = $this->request->session()->get('user-id');
        $usuario = $this->repositorio->where(['usu_codigo' => $id])->first();

        $niveisUsuario = UsuarioNivel::where(['usn_status' => 'S'])
            ->where('usn_codigo', '>=', $usuario->usu_nivel)
            ->where('usn_codigo', '<>', Usuario::CONDUTOR)
            ->get();

        return view('admin.usuario.create', [
            'titulo'    => 'Novo Usuário',
            'niveis'    => $niveisUsuario
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  StoreUpdateUsuarioRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateUsuarioRequest $request)
    {
        $dataCriacao = new \DateTime();
        $clienteID = $this->request->session()->get('cliente-id');

        $data = $request->only(
            'usu_nome',
            'usu_email',
            'usu_cliente',
            'usu_senha',
            'usu_nivel',
            'usu_status',
            'usu_datetime'
        );

        $data['usu_cliente']  = $clienteID;
        $data['usu_senha']    = md5($request->usu_senha);
        $data['usu_status']   = Usuario::ATIVO;
        $data['usu_datetime'] = $dataCriacao->format('Y-m-d H:i:s');

        $this->repositorio->create($data);

        return redirect()->route('usuario.create', 'success=true');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = $this->repositorio->where(['usu_codigo' => $id])->first();

        if (!$usuario) {
            return Redirect()->back();
        }

        $niveisUsuario = UsuarioNivel::where(['usn_status' => 'S'])
            ->where('usn_codigo', '>=', $usuario->usu_nivel)
            ->where('usn_codigo', '<>', Usuario::CONDUTOR)
            ->get();

        return view('admin.usuario.edit', [
            'titulo'  => 'Usuário',
            'usuarioed' => $usuario,
            'niveis'  => $niveisUsuario
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  StoreUpdateUsuarioRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateUsuarioRequest $request, $id)
    {
        if (md5($request->input('usu_senha')) != $request->input('usu_senha_ant')) {
            $request['usu_senha'] = md5($request->input('usu_senha'));
        } else {
            $request['usu_senha'] = $request->input('usu_senha_ant');
        }

        $usuario = $this->repositorio->where(['usu_codigo' => $id])->first();

        $usuario->update($request->all());

        return redirect('usuario/' . $id . '/edit?edicao=true');
    }

    /**
     * Atualiza o Status do Usuário
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $usuario = $this->repositorio->where(['usu_codigo' => $id])->first();

        if ($usuario->usu_status == Usuario::ATIVO) {
            $usuario->usu_status = Usuario::INATIVO;
        } else {
            $usuario->usu_status = Usuario::ATIVO;
        }

        $usuario->save();

        $pathInfo = explode('=', $this->request->getPathInfo());

        return redirect()->route('usuario.index', ['page' => end($pathInfo)]);
    }
}
