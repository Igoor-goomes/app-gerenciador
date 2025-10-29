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
    protected $fillable = ['nome', 'descricao', 'preco', 'preco_unitario', 'preco_total', 'quantidade_estoque', 'categoria','atributo'];
    protected $attributes = ['categoria' => null, 'atributo' => null];
    protected $casts = [
        'categoria' => 'array',
        'atributo'  => 'array',
        'preco'           => 'decimal:2',
        'preco_unitario'  => 'decimal:2',
        'preco_total'     => 'decimal:2'
    ];

    // Keep computed total if preco_total is null, fallback to qty * unit
    public function getPrecoTotalAttribute($value)
    {
        if ($value !== null) return (float) $value;
        $qtd = (float) ($this->quantidade_estoque ?? 0);
        $unit = (float) ($this->preco_unitario ?? $this->preco ?? 0);
        return round($qtd * $unit, 2);
    }

    public function scopeNome($query, $termo)
    {
        return $query->where('nome', 'like', "%{$termo}%");  
    }
}
