<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helper\Util;

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
        return View('admin.dashboard.index', [
            'titulo'  => 'Dashboard'
        ]);
    }
}
