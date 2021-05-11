<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioServicoInfo extends Model
{
    protected $table = 'usuario_servico_info';
    protected $primaryKey = 'usi_codigo';
    public $timestamps = false;

    protected $fillable = [
        'usuario_servico_uss_codigo',
        'uss_codigo',
        'usi_descricao',
        'usu_codigo',
        'usi_deletado',
        'usi_datetime',
        'usi_status_checkin'
    ];
}
