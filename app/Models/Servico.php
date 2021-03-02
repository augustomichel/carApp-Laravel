<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    const INATIVO           = 'N';
    const ATIVO             = 'S';

    public $timestamps = false;

    protected $table = 'servico';
    protected $primaryKey = 'ser_codigo';

    protected $fillable = [
        'ser_codigo', 'ser_cliente', 'ser_descricao', 'ser_tipo_servico', 'ser_time_execucao', 'ser_status'
    ];
}
