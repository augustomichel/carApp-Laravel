<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    const INATIVO           = 0;
    const ATIVO             = 1;

    public $timestamps = false;

    protected $table = 'modelo';
    protected $primaryKey = 'mod_codigo';

    protected $fillable = [
        'mod_codigo', 'mod_marca', 'mod_nome', 'mod_status', 'mod_datetime'
    ];
}
