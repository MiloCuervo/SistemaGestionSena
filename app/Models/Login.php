<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'logged_in_at',
        'logged_out_at',
        'session_id',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes útiles para consultas frecuentes
     */
    public function scopeActive($query)/* Saber si un usuario esta en linea */
    {
        return $query->whereNull('logged_out_at');
    }

    public function scopeInactive($query)/* Saber si un usuario esta desconectado */
    {
        return $query->whereNotNull('logged_out_at');
    }

    public function scopeToday($query)/* Saber si un usuario se conecto hoy */
    {
        return $query->whereDate('logged_in_at', today());
    }

    public function scopeThisMonth($query)/* Saber si un usuario se conecto este mes */
    {
        return $query->whereMonth('logged_in_at', today()->month);
    }

    public function scopeForUser($query, $userId)/* Saber si un usuario se conecto este mes */
    {
        return $query->where('user_id', $userId);
    }
}
