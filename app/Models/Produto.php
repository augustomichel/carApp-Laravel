<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    const INATIVO           = 'N';
    const ATIVO             = 'S';

    public $timestamps = false;

    protected $table = 'produto';
    protected $primaryKey = 'pro_codigo';

    protected $fillable = [
        'pro_nome', 'pro_cliente', 'pro_status', 'pro_datetime'
    ];
}
