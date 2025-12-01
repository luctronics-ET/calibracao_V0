<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model {
    protected $table = 'auditoria';
    const CREATED_AT = 'data_evento';
    const UPDATED_AT = null;
    protected $fillable = ['usuario', 'acao', 'entidade', 'entidade_id', 'detalhes'];
}
