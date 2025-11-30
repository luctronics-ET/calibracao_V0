<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;

class Certificate extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'calibracao_id',
        'numero_certificado',
        'arquivo_pdf',
        'data_emissao',
        'data_validade',
        'organismo_acreditacao',
        'numero_acreditacao',
        'observacoes',
        'valido',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
        'valido' => 'boolean',
    ];

    public function calibracao(): BelongsTo
    {
        return $this->belongsTo(Calibracao::class);
    }

    public function measurementParameters(): HasMany
    {
        return $this->hasMany(MeasurementParameter::class);
    }

    public function isVencido(): bool
    {
        return $this->data_validade < now();
    }

    public function diasParaVencimento(): int
    {
        return now()->diffInDays($this->data_validade, false);
    }
}
