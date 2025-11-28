<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LoteItem extends Model {
    protected $fillable = ['lote_id','equipamento_id','situacao'];
}
