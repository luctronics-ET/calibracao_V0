<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'permissao',
        'setor',
    ];

    protected $hidden = [
        'senha_hash',
        'remember_token',
    ];

    // Accessor para compatibilidade com auth
    public function getAuthPassword()
    {
        return $this->senha_hash;
    }

    // Accessor para nome como name
    public function getNameAttribute()
    {
        return $this->attributes['nome'] ?? null;
    }

    // Accessor para role
    public function getRoleAttribute()
    {
        return $this->attributes['permissao'] ?? 'visualizador';
    }

    // Helper methods para verificar roles
    public function isAdmin()
    {
        return $this->permissao === 'admin';
    }

    public function isTecnico()
    {
        return $this->permissao === 'tecnico';
    }

    public function isVisualizador()
    {
        return $this->permissao === 'visualizador';
    }

    public function canEdit()
    {
        return in_array($this->permissao, ['admin', 'tecnico']);
    }
}
