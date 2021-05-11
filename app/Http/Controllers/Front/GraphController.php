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

class GraphController extends Controller
{
    public function __construct(Request $request,UsuarioServico $usuarioservico, servico $servico,Usuario $usuario, UsuarioServicoInfo $usuarioservicoinfo)
    {
       // $this->middleware('auth');

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
        //buscar dados do banco para popular graficos
        $ser = [5, 2, 3, 5];
        $labelBar = "Atividades por Mecânico";
        $labelsBar = ['José', 'João', 'Paulo', 'Pedro'];

        $serLine = [10,5,6,7];
        $labelLine = "Atividades por período";
        $labelsLine = ['Março', 'Abril', 'Maio', 'Junho'];

        //retorna pagina contendo os graficos
        return view('front.graph.index', [
            'titulo'     => 'Gráficos',
            'usuario' => session()->get('user-nome'),
            'servico' =>  json_encode($ser,JSON_NUMERIC_CHECK),
            'labelBar' => json_encode($labelBar),
            'labelsBar' => json_encode($labelsBar),
            'servicoLine' =>  json_encode($serLine,JSON_NUMERIC_CHECK),
            'labelLine' => json_encode($labelLine),
            'labelsLine' => json_encode($labelsLine)
        ]);
        
    }

}
