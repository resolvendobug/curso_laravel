<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules()
    {
        return [
            'nome' => 'required|unique:marcas,nome,' . $this->id.'',
            'imagem' => 'required|file|mimes:jpg,png,jpeg'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'imagem.mines' => 'O campo imagem deve ser do tipo jpg, png ou jpeg',   
            'nome.unique' => 'Já existe uma marca com esse nome'
        ];
    }
}
