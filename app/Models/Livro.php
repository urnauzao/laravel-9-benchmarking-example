<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    public $fillable = [
        'titulo',
        'editora',
        'email',
        'ano_lancamento',
        'numero_paginas',
    ];
}
