<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    public function produtos()
    {
        // return $this->belongsToMany('App\Models\Produto', 'pedido_produtos');
        return $this->belongsToMany('App\Models\Item', 'pedidos_produtos' , 'pedido_id' , 'produto_id');
        /*
         1- Modelo do relacionamento NxN em relação o Modelo que estamos implementando
         2- Tabela auxiliar que armazena os registros de relacionamento
         3 - Representa o nome da FK da tabela mapeada pelo Modelo que estamos implementando
         4- Representa o nome da FK da tabela mapeada pelo Modelo que está sendo relacionado

        */
        
    }
}
