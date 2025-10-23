<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jogo extends Model
{
    use HasFactory;
    
    protected $fillable = [ //fillable = propriedades preenchíveis 
            'nome',
            'categoria',
            'ano_criacao',
            'valor',   
    ];

}
