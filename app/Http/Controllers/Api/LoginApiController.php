<?php

namespace App\Http\Controllers\Api;

use App\Helper\Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Services\CondutorService;
use ErrorException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class LoginApiController extends Controller
{
    const API_TOKEN_CONDUTOR = '952ac03Y115d5z18S3ar372827X2fdPf10a1c';

    public function __construct(Request $request, Usuario $usuario)
    {
        $this->request = $request;
        $this->usuario = $usuario;
    }
    
    /**
     * Retornando login
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     * @example 
     * {
     *  "email" : "fernando@ig.com.br",
     *  "senha" : "123456"
     * }
     */
    public function login(Request $request)
    {
        try{
            if ($request->input('token') != self::API_TOKEN_CONDUTOR) {
                throw new \Exception("Token inválido", 99);
            }

            $params = Util::validaJsonDataRaw($request->getContent());

            $usuario = Usuario::where([
                'usu_email'  => $params->email,
                'usu_senha'  => md5($params->senha),
            ])->first();            
           
            if (!empty($usuario)) {
                if ($usuario->usu_status == Usuario::INATIVO){
                    throw new \InvalidArgumentException("Usuário Inativo", 99);
                }
                unset($usuario->usu_senha);
                return $usuario;
            } else {
                throw new \InvalidArgumentException("Usuário e/ou senha inválidos", 99);
            }

        } catch (\Exception $e) {

            if (substr_count($e->getMessage(), 'Connection refused') > 0) {
                $error = 'Problema ao se conectar com a base de dados!';
            } elseif ($e instanceof QueryException) {
                dd($e->getMessage());
                $error = 'Error query Exception database!';
            } else {
                $error = $e->getMessage();
            }

            return response()->json([
                'info'  => false,
                'result' => 'falha',
                'error'  => $error
            ], 404);
        }
    }


}
