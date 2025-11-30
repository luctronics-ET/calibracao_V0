<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class ReferenceStandard extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'codigo',
        'descricao',
        'fabricante',
        'modelo',
        'numero_serie',
        'data_calibracao',
        'data_validade',
        'certificado_rastreabilidade',
        'cadeia_rastreabilidade',
        'incerteza',
        'status',
    ];

    protected $casts = [
        'data_calibracao' => 'date',
        'data_validade' => 'date',
        'incerteza' => 'decimal:4',
    ];

    public function isVencido(): bool
    {
        return $this->data_validade && $this->data_validade < now();
    }

    public function diasParaVencimento(): ?int
    {
        if (!$this->data_validade) {
            return null;
        }
        return now()->diffInDays($this->data_validade, false);
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeVencidos($query)
    {
        return $query->where('data_validade', '<', now());
    }
}
