<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratorio extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cnpj', 'acreditado', 'escopo', 'contato', 'endereco'];
    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }
}
