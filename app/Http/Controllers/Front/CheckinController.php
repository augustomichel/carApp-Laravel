<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Usuario;
use App\Models\UsuarioServico;
use App\Models\UsuarioServicoInfo;
use App\Helper\Util;
use App\Http\Requests\StoreUpdateCheckinRequest;

class CheckinController extends Controller
{
    public function __construct(Request $request,UsuarioServico $usuarioservico, servico $servico,Usuario $usuario, UsuarioServicoInfo $usuarioservicoinfo)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->usuarioservico = $usuarioservico;
        $this->servico = $servico;
        $this->usuario     = $usuario;
        $this->servicoinfo = $usuarioservicoinfo;
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
        $user =  $this->request->session()->get('user-id');
        
        if ($this->request->input('s') != '') {
            $status = $this->request->input('s');
            $opStatus1  = '=';
            $ftrStatus = $status;
        } else {
            $opStatus1  = '<>';
            $ftrStatus = 0;
        }
    
    
        if ($this->request->input('f') != '') {
            $data = $this->request->input('f');
            $opStatus  = '=';
            $ftrData = date('Y-m-d', strtotime($data));
        } else {
            $data = date('d-m-Y');
            $opStatus  = '<=';
            $ftrData = date('Y-m-d');
        }
    
        $usuarioservicos = $this->usuarioservico
            ->join('servico', 'usuario_servico.uss_ser_codigo', '=', 'servico.ser_codigo')
            ->join('usuario_veiculo', 'usuario_servico.usv_codigo', '=', 'usuario_veiculo.usv_codigo')
            ->select(
                'usuario_servico.uss_codigo  as id',
                'servico.ser_descricao',
                'servico.ser_tipo_servico',
                'usuario_servico.uss_ser_codigo',
                'servico.ser_time_execucao',
                'usuario_servico.uss_observacao',
                'usuario_servico.uss_status',
                'usuario_servico.uss_datetime',
                'usuario_veiculo.usv_placa',
                'usuario_veiculo.usv_codigo'                               
            )
            ->where('usuario_servico.cliente_cli_codigo', '=', $clienteID)
           // ->where('usuario_servico.uss_status', '=', UsuarioServico::AGENDADO )
            ->whereDate('usuario_servico.uss_datetime_inicio', $opStatus, $ftrData)
            ->where('usuario_servico.uss_status', $opStatus1, $ftrStatus)
            ->orderBy('servico.' . $campoOrder, $dirOrder)
            ->paginate(10);
               
        return view('front.checkin.index', [
            'titulo'     => 'CheckIn',
            'usuario' => session()->get('user-nome'),
            'data'       => $data,
            'usuarioservicos'   => $usuarioservicos,
            'pagination' => $usuarioservicos,
            'total'      => $usuarioservicos->total(),
            'error' => false
        ]);
        
    }

   /**
     * Show the form for editing the specified resource.
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuarioservico = $this->usuarioservico
        ->join('servico', 'usuario_servico.uss_ser_codigo', '=', 'servico.ser_codigo')
        ->join('usuario_veiculo', 'usuario_servico.usv_codigo', '=', 'usuario_veiculo.usv_codigo')
        ->select(
            'usuario_servico.uss_codigo  as id',
            'servico.ser_descricao',
            'servico.ser_tipo_servico',
            'usuario_servico.uss_ser_codigo',
            'servico.ser_time_execucao',
            'usuario_servico.uss_observacao',
            'usuario_servico.uss_status',
            'usuario_servico.uss_datetime',
            'usuario_veiculo.usv_placa',
            'usuario_veiculo.usv_codigo'                               
        )
        ->where('usuario_servico.uss_codigo','=',$id)
        ->first();

        $idUsuario = $this->request->session()->get('user-id');

        $usuario = $this->usuario->where(['usu_codigo' => $idUsuario])->first();
        $usuario = Util::usuarioLogado($usuario->usu_nome);
       
        return view('front.checkin.check', [
            'titulo'  => 'Serviço',
            'usuarioservico' => $usuarioservico,
            'usuario' => $usuario,
            'error'   => null
        ]);
    }
    
    /**
     * Atualiza o Status do servico
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCheckinRequest $request,$id)
    {
        \DB::beginTransaction();
        try {

            $dataRegistro = new \DateTime();
            $user =  $this->request->session()->get('user-id');
            $servico = $this->usuarioservico->where(['uss_codigo' => $id])->first();
            
            switch ($servico->uss_status) {
                case UsuarioServico::AGENDADO:
                    $servico->uss_status          = UsuarioServico::OFICINA;
                    $servico->uss_datetime_inicio = $dataRegistro->format('Y-m-d H:i:s'); 
                    break;
                case UsuarioServico::OFICINA:
                    $this->usuarioservico->validandoServico($servico->usv_codigo, $servico->uss_codigo);
                    $servico->uss_status          = UsuarioServico::EXECUCAO; 
                    break;
                case UsuarioServico::EXECUCAO:
                    $servico->uss_status = UsuarioServico::POSEXEC;
                    break;
                case UsuarioServico::POSEXEC:
                    $servico->uss_status = UsuarioServico::LAVACAO;
                    break;
                case UsuarioServico::LAVACAO:
                    $servico->uss_status = UsuarioServico::PREENTREGA;
                    break;    
                default:
                    $this->usuarioservico->validandoServico($servico->usv_codigo, $servico->uss_codigo);
                    $servico->uss_status = UsuarioServico::FINALIZADO;
                    break;
            }

            $servico->uss_observacao = $request->usi_descricao;
            $servico->usu_codigo_executor = $user ;
            
            $servico->update();

            $data['usuario_servico_uss_codigo'] = $servico->uss_codigo;
            $data['usi_descricao']              = mb_strtoupper($servico->uss_observacao, 'UTF-8');
            $data['usu_codigo']                 = $user;
            $data['usi_datetime']               = $dataRegistro->format('Y-m-d H:i:s');
            $data['usi_status_checkin']         = $servico->uss_status;

            $this->servicoinfo->create($data);
            
            //atualiza a data fim do servico_info anterior
            $statusAnteriro = $servico->uss_status - 1;
            if ($statusAnteriro < 1) {
                $statusAnteriro = 1;
            }
            
            $servicoinfo = $this->servicoinfo->where(['usuario_servico_uss_codigo' => $servico->uss_codigo])
                ->where(['usi_status_checkin' => $statusAnteriro])
                ->first();

            if ($servicoinfo){    
                $servicoinfo->usi_datetime_fim  = $dataRegistro->format('Y-m-d H:i:s') ;
                $servicoinfo->update();  
            }


            $pathInfo = explode('=', $this->request->getPathInfo());

            \DB::commit();

            return redirect()->route('checkin.index', ['page' => end($pathInfo)]);
        } catch (\Exception $e) {
            
            \DB::rollback();

            $usuarioservico = $this->usuarioservico->where(['uss_codigo' => $id])->first();
            
            $servico = $this->servico->where(['ser_codigo' => $usuarioservico->uss_ser_codigo])->first();

            $usuario = $this->usuario->where(['usu_codigo' => $user])->first();
            $usuario = Util::usuarioLogado($usuario->usu_nome);

            return view('front.checkin.check', [
                'titulo'  => 'Serviço',
                'usuarioservico' => $usuarioservico,
                'servico' => $servico,
                'usuario' => $user,
                'error'   => $e->getMessage()
            ]);
           
        }
    }

}
