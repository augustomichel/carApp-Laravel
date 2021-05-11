<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Usuario;
use App\Models\UsuarioServico;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateServicoRequest;

class ServicoController extends Controller
{
    public function __construct(Request $request, UsuarioServico $usuarioservico, Usuario $usuario)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $usuarioservico;
        $this->usuario     = $usuario;
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campoOrder = (empty($this->request->input('c'))) ? 'ser_descricao' : $this->request->input('c');
        $dirOrder   = (empty($this->request->input('o'))) ? 'asc'  : $this->request->input('o');

        $clienteID = $this->request->session()->get('cliente-id');
        $user      = $this->request->session()->get('user-id');
        $niveluser = $this->request->session()->get('nivel-user');

        if (!empty($this->request->input('s'))) {
            $busca = strtoupper(trim($this->request->input('s')));
            $operador = 'like';
            $filtro = "%$busca%";
        } else {
            $operador = '<>';
            $filtro   = '00';
        }

        if ($this->request->input('f') != '') {
            $status = $this->request->input('f');
            $opStatus  = '=';
            $ftrStatus =  array($status) ;
        } else {
            $opStatus  = '<>';
            $ftrStatus = [UsuarioServico::AGENDADO,UsuarioServico::OFICINA,UsuarioServico::EXECUCAO];
        }

        if ($niveluser == Usuario::MECANICO) {
            $usuarioservicos = $this->repositorio
                ->join('servico', 'usuario_servico.uss_ser_codigo', '=', 'servico.ser_codigo')
                ->select(
                    'usuario_servico.uss_codigo  as id',
                    'servico.ser_descricao',
                    'servico.ser_tipo_servico',
                    'usuario_servico.uss_ser_codigo',
                    'servico.ser_time_execucao',
                    'usuario_servico.uss_observacao',
                    'usuario_servico.uss_status'
                )
                ->where('usuario_servico.cliente_cli_codigo', '=', $clienteID)
                ->where('usuario_servico.usu_codigo_executor', '=', $user)
                //->where('usuario_servico.uss_status', $opStatus, $ftrStatus)
                ->wherein('usuario_servico.uss_status',  $ftrStatus)
                ->orderBy('servico.' . $campoOrder, $dirOrder)
                ->paginate(10);
        } else {
             $usuarioservicos = $this->repositorio
                 ->join('servico', 'usuario_servico.uss_ser_codigo', '=', 'servico.ser_codigo')
                 ->select(
                     'usuario_servico.uss_codigo  as id',
                     'servico.ser_descricao',
                     'servico.ser_tipo_servico',
                     'usuario_servico.uss_ser_codigo',
                     'servico.ser_time_execucao',
                     'usuario_servico.uss_observacao',
                     'usuario_servico.uss_status'
                 )
                 ->where('usuario_servico.cliente_cli_codigo', '=', $clienteID)
                 ->where('usuario_servico.usuario_usu_codigo', '=', $user)
                 //->where('usuario_servico.uss_status', $opStatus, $ftrStatus)
                 ->wherein('usuario_servico.uss_status',  $ftrStatus)
                 ->orderBy('servico.' . $campoOrder, $dirOrder)
                 ->paginate(10);
        }
        return view('front.servico.index', [
            'titulo'     => 'Serviços',
            'usuarioservicos'   => $usuarioservicos,
            'pagination' => $usuarioservicos,
            'total'      => $usuarioservicos->total()
        ]);
    }

}
