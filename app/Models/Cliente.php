<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    const INATIVO           = 'N';
    const ATIVO             = 'S';

    public $timestamps = false;

    protected $table = 'cliente';
    protected $primaryKey = 'cli_codigo';

    protected $fillable = [
        'cli_nome', 'cli_cnp', 'cli_status', 'cli_datetime', 'cli_matriz'
    ];
}
