<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    const INATIVO           = 0;
    const ATIVO             = 1;

    public $timestamps = false;

    protected $table = 'marca';
    protected $primaryKey = 'mac_codigo';

    protected $fillable = [
        'mac_codigo', 'mac_nome', 'mac_status', 'mac_datetime'
    ];
}
