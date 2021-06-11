<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class inscrito extends Model
{
    protected $fillable = [
        'email', 'nome', 'empresa', 'telefone', 'celular', 'ocupacao'
    ];
}