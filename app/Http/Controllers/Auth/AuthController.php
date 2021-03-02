<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Helper\Util;
use App\Helper\SmtpEmail;
use stdClass;

class AuthController extends Controller
{
    public function __construct(Request $request, Usuario $usuario)
    {
        $this->request     = $request;
        $this->repositorio = $usuario;
    }

    /**
     * Autenticação do Usuário
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     */
    public function auth(Request $request)
    {
        $usuario = Usuario::where([
            'usu_email'  => $request->input('email'),
            'usu_senha'  => md5($request->input('senha')),
            'usu_status' => Usuario::ATIVO
        ])->first();

        if (!empty($usuario)) {
            //abre sessao
            $request->session()->put('carapp-session', Util::getHash($usuario->usu_email));
            $request->session()->put('user-id', $usuario->usu_codigo);
            $request->session()->put('user-nome', Util::usuarioLogado($usuario->usu_nome));
            $request->session()->put('nivel-user', $usuario->usu_nivel);
            $request->session()->put('cliente-id', $usuario->usu_cliente);

            //refireciona para o controller dashboard
            return redirect('/dashboard');
        } else {
            //redireciona para o login com error
            return redirect('/manager?error=1');
        }
    }

    /**
     * Recuperação de Senha do Usuário
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     */
    public function forgot(Request $request)
    {
        return redirect('/forgot?success=1');

        $usuario = Usuario::where(['usu_email' => $request->email])->first();

        //gerar uma nova senha aleatoria e enviar por email
        $senhaProvisoria = substr(Util::getHash(date('HisYms')), 15, 6);

        $usuario = $this->repositorio->where(['usu_email' => $request->email])->first();
        $dataUsuario['usu_senha'] = md5($senhaProvisoria);

        $usuario->update($dataUsuario);

        $textoMensagem  = 'Olá, ' . $usuario->usu_nome . '<br>';
        $textoMensagem  = 'Foi gerada uma nova senha para acesso ao sistema<br>';
        $textoMensagem .= 'Senha: ' . $senhaProvisoria . '<br><br>';
        $textoMensagem .= 'Realize o login com esta senha provisória e posteriormente atualize sua senha!<br>';
        $textoMensagem .= 'At. Suporte CarApp';

        $email = new stdClass();
        $email->subject = 'Recuperação de Senha - CarApp';
        $email->text    = $textoMensagem;
        $email->email   = $request->email;
        $email->name    = $usuario->usu_nome;

        if (SmtpEmail::email($email)) {
            return redirect('/forgot?success=1');
        } else {
            return redirect('/forgot?error=Email informado é Inválido');
        }
    }

    /**
     * Logout de Sistema
     * @author Augusto Michel <augustomichel@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout(Request $request)
    {
        //deletando session de login
        $request->session()->forget('carapp-session');

        return redirect('/manager');
    }
}
