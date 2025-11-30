<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'parametro_nome',
        'unidade',
        'valor_nominal',
        'valor_medido',
        'incerteza',
        'erro',
        'padrao_referencia',
        'resultado',
        'observacoes',
    ];

    protected $casts = [
        'valor_nominal' => 'decimal:4',
        'valor_medido' => 'decimal:4',
        'incerteza' => 'decimal:4',
        'erro' => 'decimal:4',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    public function calcularErro(): void
    {
        if ($this->valor_nominal && $this->valor_medido) {
            $this->erro = $this->valor_medido - $this->valor_nominal;
        }
    }
}
