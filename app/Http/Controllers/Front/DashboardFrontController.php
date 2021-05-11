<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helper\Util;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Servico;
use App\Models\UsuarioVeiculo;

class DashboardFrontController extends Controller
{
    public function __construct(Request $request, Usuario $usuario)
    {    
        $this->request     = $request;
        $this->repositorio = $usuario;
    }

    public function manager()
    {
        return View('front.login.index', [
            'titulo'  => 'Dashboard',
            'usuario' => session()->get('user-nome')
        ]);
    }

    public function forgot()
    {
        return View('front.login.recuperar-senha', [
            'titulo'  => 'Dashboard',
            'usuario' => session()->get('user-nome')
        ]);
    }
}
