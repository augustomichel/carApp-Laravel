<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioNivel extends Model
{
    const INATIVO           = 0;
    const ATIVO             = 1;

    protected $table = 'usuario_nivel';
}
