<?php

namespace App\Services;

use App\Helper\SmtpEmail;
use stdClass;

class CondutorService
{
    /**
     * Confirmacao de Condutor de Veiculo
     * @author Fernando Costa <fernando@primetec.tec.br>
     */
    public function confirmacaoCondutor($usuario)
    {
        $textoMensagem  = 'Olá, ' . $usuario->usu_nome . '<br>';
        $textoMensagem  = 'Você se cadastrou no sistema CarApp<br>';
        $textoMensagem .= 'Click no link abaixo para confirmar seu cadastro:<br>';
        $textoMensagem .= '<a href="">Clique aqui para confirmar seu cadastro!</a><br>';
        $textoMensagem .= 'At. Suporte CarApp';

        $email = new stdClass();
        $email->subject = 'Confirmação de Cadastro - CarApp';
        $email->text    = $textoMensagem;
        $email->email   = $usuario->usu_email;
        $email->name    = $usuario->usu_nome;

        /*
        if (SmtpEmail::email($email)) {
            return true;
        } else {
            return false;
        }
        */

        return true;
    }
}
