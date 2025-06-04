<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'archivo',
        'estado',
        'comentarios',
    ];

    // Relación con el modelo User (opcional, útil para roles más adelante)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
