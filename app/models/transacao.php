<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class transacao extends Model
{
    protected $fillable = [
        'referencia', 'status', 'id_inscrito'
    ];
}