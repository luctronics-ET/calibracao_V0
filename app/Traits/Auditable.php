<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Boot the trait and register model event listeners.
     */
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->audit('create');
        });

        static::updated(function ($model) {
            $model->audit('update');
        });

        static::deleted(function ($model) {
            $model->audit('delete');
        });
    }

    /**
     * Create an audit log entry.
     *
     * @param string $action
     * @return void
     */
    public function audit(string $action): void
    {
        $changes = [];

        if ($action === 'update') {
            $changes = [
                'before' => $this->getOriginal(),
                'after' => $this->getAttributes()
            ];
        } elseif ($action === 'create') {
            $changes = [
                'after' => $this->getAttributes()
            ];
        } elseif ($action === 'delete') {
            $changes = [
                'before' => $this->getOriginal()
            ];
        }

        Log::create([
            'usuario_id' => Auth::id() ?? null,
            'acao' => $action,
            'tabela' => $this->getTable(),
            'referencia_id' => $this->id,
            'detalhe' => json_encode($changes),
        ]);
    }

    /**
     * Get audit logs for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function auditLogs()
    {
        return $this->morphMany(Log::class, 'auditable');
    }
}
