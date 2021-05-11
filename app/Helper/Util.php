<?php

namespace App\Helper;

use Illuminate\Support\Facades\Hash;

class Util
{
    /**
     * Caracteres especiais do alfabeto latino que não são composição de marcas diacríticas,
     * mas que não são mapeáveis em ASCII diretamente.
     * @var string
     */
    private static $unicodeMapping = array(
        "\xc4\x91" => 'd',
        "\xc4\x90" => 'D',
        "\xc4\xa7" => 'h',
        "\xc4\xa6" => 'H',
        "\xc4\xb1" => 'i',
        "\xc4\xb8" => 'k',
        "\xc5\x81" => 'L',
        "\xc5\x82" => 'l',
        "\xc3\x86" => 'AE',
        "\xc5\x8b" => 'n',
        "\xc5\x8a" => 'N',
        "\xc3\x90" => 'D',
        "\xc5\x93" => 'oe',
        "\xc5\x92" => 'OE',
        "\xc3\x98" => 'O',
        "\xc3\x9f" => 's',
        "\xc3\x9e" => 'Th',
        "\xc5\xa7" => 't',
        "\xc3\xa6" => 'ae',
        "\xc5\xa6" => 'T',
        "\xc3\xb0" => 'd',
        "\xc3\xb8" => 'o',
        "\xc3\xbe" => 'th',
    );

    /**
     * Retornando Hash de String
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $string
     * @return string 
     */
    static public function getHash($string)
    {
        return Hash::make($string);
    }

    static function removerAcentosUtf8($texto)
    {
        $normalizado = \Normalizer::normalize($texto, \Normalizer::FORM_KD);
        $semAcentos = preg_replace("/\pM/u", "", $normalizado);
        $mapa = self::$unicodeMapping;
        foreach ($mapa as $unicodeKey => $mappedChar) {
            $semAcentos = str_replace($unicodeKey, $mappedChar, $semAcentos);
        }
        return $semAcentos;
    }

    static function removerAcentos($texto)
    {
        $utf = utf8_encode($texto);
        $semAcentos = self::removerAcentosUtf8($utf);
        return utf8_decode($semAcentos);
    }

    static function mesAbreviado($mes)
    {
        switch ($mes) {
            case 1:
                return 'jan';
            case 2:
                return 'fev';
            case 3:
                return 'mar';
            case 4:
                return 'abr';
            case 5:
                return 'mai';
            case 6:
                return 'jun';
            case 7:
                return 'jul';
            case 8:
                return 'ago';
            case 9:
                return 'set';
            case 10:
                return 'out';
            case 11:
                return 'nov';
            case 12:
                return 'dez';
            default:
                return '';
        }
    }

    static function mesCompletoBR($mes)
    {
        switch ($mes) {
            case 1:
                return 'Janeiro';
            case 2:
                return 'Fevereiro';
            case 3:
                return 'Março';
            case 4:
                return 'Abril';
            case 5:
                return 'Maio';
            case 6:
                return 'Junho';
            case 7:
                return 'Julho';
            case 8:
                return 'Agosto';
            case 9:
                return 'Setembro';
            case 10:
                return 'Outubro';
            case 11:
                return 'Novembro';
            case 12:
                return 'Dezembro';
            default:
                return '';
        }
    }

    static function diaDaSemanaCompleto($diaAbreviado)
    {
        switch ($diaAbreviado) {
            case 'Seg':
                return 'Segunda-Feira';
            case 'Ter':
                return utf8_encode('Terça-Feira');
            case 'Qua':
                return 'Quarta-Feira';
            case 'Qui':
                return 'Quinta-Feira';
            case 'Sex':
                return 'Sexta-Feira';
            case 'Sáb':
                return utf8_encode('Sábado');
            case 'Dom':
                return 'Domingo';
            default:
                return '';
        }
    }

    /**
     * Valida valor no formato Moeda Real
     * @param string $valor
     * @return boolean
     */
    static function isFormatoReal($valor)
    {
        if (preg_match("/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/", (string) $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Valida valor no formato float
     * @param string $valor
     * @return boolean
     */
    static function isFloat($valor)
    {
        if (!preg_match('/^[0-9]{1,10}[.][\d]{2}$/', $valor)) {
            return false;
        }

        return true;
    }

    /**
     * Validando se telefone informado é um telefone fixo válido no formato correto
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $telefone Ex. (48) 3257-6468
     * @return boolean
     */
    static function isTelefoneFixo($telefone)
    {
        if (!preg_match('/^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$/', $telefone)) {
            return false;
        }

        return true;
    }

    /**
     * Validando se telefone informado é um telefone celular válido no formato correto
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $telefone Ex. (48) 98828-6468
     * @return boolean
     */
    static function isTelefoneCelular($telefone)
    {
        if (!preg_match('#^\(\d{2}\) 9?[6789]\d{3}-\d{4}$#', $telefone)) {
            return false;
        }

        return true;
    }

    /**
     * Validando se email informado esta no formato correto
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $email
     * @return boolean
     */
    static function isEmailValido($email)
    {
        if (!preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $email)) {
            return false;
        }

        return true;
    }

    /**
     * Transformar valor float para moeda formato Brasileiro
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param float $valor
     * @return string
     */
    static function getMoedaFormatoBR($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    /**
     * Retornando DataTime formato Brasileiro
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $dateTimeDB
     * @return string
     */
    static function getDataTimeFormatoBrasileiro($dateTimeDB)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeDB);
        return  $date->format('d/m/Y H:i:s');
    }

    /**
     * @author Fernando Costa <fernando@primetec.tec.br>
     */
    static function usuarioLogado($nomeUsuario)
    {
        $nome = explode(' ', $nomeUsuario);

        return $nome[0] . ' ' . end($nome);
    }

    /**
     * Realizando validação no Formato JSON passado pelo Request DataRaw
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $contentBodyRaw
     * @return Json
     */
    static public function validaJsonDataRaw($contentBodyRaw)
    {
        $json = json_decode($contentBodyRaw);

        $error = '';

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $json;
            case JSON_ERROR_DEPTH:
                $error = 'A profundidade máxima da pilha foi excedida';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'JSON inválido ou mal formado';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Erro de caractere de controle, possivelmente codificado incorretamente';
                break;
            case JSON_ERROR_SYNTAX:
            case JSON_ERROR_UTF8:
                $error = 'Erro de sintaxe';
                break;
            default:
                $error = 'Erro desconhecido';
                break;
        }

        if (!empty($error)) {
            throw new \Exception($error, 99);
        }

        return $json;
    }

    /**
     * Mascara para CNPJ ou CPF
     * @author Fernando Costa <fernando@primetec.tec.br>
     * @param string $cpf_cnpj
     * @return string
     */
    static public function formata_cpf_cnpj($cpf_cnpj)
    {
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
        $tipo_dado = NULL;
        if (strlen($cpf_cnpj) == 11) {
            $tipo_dado = "cpf";
        }
        if (strlen($cpf_cnpj) == 14) {
            $tipo_dado = "cnpj";
        }
        switch ($tipo_dado) {
            default:
                $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
                break;

            case "cpf":
                $bloco_1 = substr($cpf_cnpj, 0, 3);
                $bloco_2 = substr($cpf_cnpj, 3, 3);
                $bloco_3 = substr($cpf_cnpj, 6, 3);
                $dig_verificador = substr($cpf_cnpj, -2);
                $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
                break;

            case "cnpj":
                $bloco_1 = substr($cpf_cnpj, 0, 2);
                $bloco_2 = substr($cpf_cnpj, 2, 3);
                $bloco_3 = substr($cpf_cnpj, 5, 3);
                $bloco_4 = substr($cpf_cnpj, 8, 4);
                $digito_verificador = substr($cpf_cnpj, -2);
                $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
                break;
        }
        return $cpf_cnpj_formatado;
    }
}
