<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $fillable = ['nome', 'descricao', 'preco', 'quantidade_estoque', 'categoria','atributo'];
    protected $casts = [
        'categoria' => 'array',
        'atributo'  => 'array',
        'preco'     => 'decimal:2'
    ];
}
