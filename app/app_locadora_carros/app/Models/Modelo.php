<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id','nome','imagem','numero_portas','lugares','air_bag','abs'];

    public function rules()
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,' . $this->id.'',
            'imagem' => 'required|file|mimes:jpg,png,jpeg',
            'numero_portas' => 'required|numeric',
            'lugares' => 'required|numeric',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
        ];
    }

    public function marca(){
        //um modelo pertence a uma marca
        return $this->belongsTo('App\Models\Marca');
    }
}
