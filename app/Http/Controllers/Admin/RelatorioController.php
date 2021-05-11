<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Usuario;
use App\Models\UsuarioServico;
use App\Models\UsuarioServicoInfo;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateRelatorioRequest;

class RelatorioController extends Controller
{
    public function __construct(Request $request, Servico $servico, Usuario $usuario, UsuarioServico $usuarioservicos, UsuarioServicoInfo $usuarioservicoinfo)
    {
        $this->middleware('auth');

        $this->request        = $request;
        $this->repositorio    = $servico;
        $this->usuario        = $usuario;
        $this->usuarioservico = $usuarioservicos;
        $this->usuarioservicoinfo = $usuarioservicoinfo;
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $mecanicos = Usuario::where([
            'usu_nivel' => Usuario::MECANICO,
        ])->where(['usu_status' => Usuario::ATIVO])->get();
        
               
        return view('admin.relatorio.index', [
            'titulo'     => 'Relatórios',
            'usuario' => session()->get('user-nome'),
            'error' => false,
            'mecanicos' => $mecanicos
        ]);
    }

    /**
     * Display a listing of the resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function result(StoreUpdateRelatorioRequest $request )
    {
       
        $user =  $this->request->session()->get('user-id');
        $DateDe = date('Y-m-d', strtotime($request->datede));
        $DateAte =  date('Y-m-d', strtotime($request->dateate));

        if (empty($request->mecanico)){
            $operador = '<>';
            $mecanico = '0';
        } else {
            $operador = '=';
            $mecanico = $request->mecanico;
        }
        $usuarioservicoinfo = $this->usuarioservicoinfo
            
            
            ->join('usuario_servico', 'usuario_servico.uss_codigo', '=', 'usuario_servico_info.usuario_servico_uss_codigo')  
            ->join('servico', 'usuario_servico.uss_ser_codigo', '=', 'servico.ser_codigo')
            ->join('usuario_veiculo', 'usuario_servico.usv_codigo', '=', 'usuario_veiculo.usv_codigo')
            ->join('usuario','usuario.usu_codigo','=','usuario_servico_info.usu_codigo')
            ->select(
                'usuario_servico_info.usi_codigo  as id',
                'servico.ser_descricao',
                'servico.ser_tipo_servico',
                'usuario_servico.uss_ser_codigo',
                'servico.ser_time_execucao',
                'usuario_servico.uss_observacao',
                'usuario_servico.uss_status',
                'usuario_servico.uss_datetime',
                'usuario_veiculo.usv_placa',
                'usuario_veiculo.usv_codigo',
                'usuario_servico_info.usi_datetime',
                'usuario_servico_info.usi_datetime_fim',
                'usuario_servico_info.usi_status_checkin',
                'usuario.usu_nome'                                            
            )
            
            ->where('usuario_servico_info.usu_codigo', $operador,  $mecanico)
            ->whereDate('usuario_servico_info.usi_datetime', '>=', $DateDe)
            ->whereDate('usuario_servico_info.usi_datetime', '<=', $DateAte)
           // ->whereBetween('usuario_servico_info.usi_datetime',[$DateDe,$DateAte])
            ->orderBy('usuario_servico_info.usi_datetime' , 'asc')
            ->distinct()
            ->paginate(100);
        
           

        return view('admin.relatorio.result', [
            'titulo'     => 'Resultado',
            'datede'       => $request->datede,
            'dateate'       => $request->dateate,
            'usuarioservicos' => $usuarioservicoinfo,
            'pagination' => $usuarioservicoinfo,
            'total'      => $usuarioservicoinfo->total(),
            
        ]);
    }
}
