<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helper\Util;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Servico;

class DashboardController extends Controller
{
    public function __construct(Request $request, Usuario $usuario)
    {
        $this->middleware('auth');

        $this->request     = $request;
        $this->repositorio = $usuario;
    }

    public function index()
    {
        $usuariosCadastrados        = Usuario::where('usu_status', 'S')->get();
        $concessionariasCadastradas = Cliente::where('cli_status', 'S')->get();
        $servicosCadastrados        = Servico::where('ser_status', 'S')->get();
        $produtosCadastrados        = Produto::where('pro_status', 'S')->get();

        return View('admin.dashboard.index', [
            'titulo'  => 'Dashboard',
            'usuariosCadastrados' => $usuariosCadastrados->count(),
            'concessionariasCadastradas' => $concessionariasCadastradas->count(),
            'servicosCadastrados' => $servicosCadastrados->count(),
            'produtosCadastrados' => $produtosCadastrados->count()
        ]);
    }
}
