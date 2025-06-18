<?php

namespace App\Models;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'archivo',
        'nombre_archivo',
        'tamaño_archivo',
        'estado',
        'comentarios',
        'fecha_revision',
        'revisado_por',
    ];

    protected $casts = [
        'fecha_revision' => 'datetime',
        'tamaño_archivo' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'fecha_revision',
        'deleted_at',
    ];

    // Estados disponibles
    public const ESTADOS = [
        'pendiente' => 'Pendiente',
        'revisado_por_tutor' => 'Revisado por Tutor',
        'aprobado' => 'Aprobado',
        'rechazado' => 'Rechazado',
    ];

    // Colores para cada estado
    public const COLORES_ESTADO = [
        'pendiente' => 'yellow',
        'revisado_por_tutor' => 'blue',
        'aprobado' => 'green',
        'rechazado' => 'red',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el usuario que revisó el documento
     */
    public function revisor()
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Accessor para obtener el tamaño del archivo formateado
     */
    public function getTamañoFormateadoAttribute()
    {
        if (!$this->tamaño_archivo) {
            return 'N/A';
        }

        $bytes = $this->tamaño_archivo;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Accessor para obtener la extensión del archivo
     */
    public function getExtensionArchivoAttribute()
    {
        return pathinfo($this->nombre_archivo, PATHINFO_EXTENSION);
    }

    /**
     * Accessor para obtener el estado formateado
     */
    public function getEstadoFormateadoAttribute()
    {
        return self::ESTADOS[$this->estado] ?? ucfirst(str_replace('_', ' ', $this->estado));
    }

    /**
     * Accessor para obtener el color del estado
     */
    public function getColorEstadoAttribute()
    {
        return self::COLORES_ESTADO[$this->estado] ?? 'gray';
    }

    /**
     * Accessor para obtener la URL del archivo
     */
    public function getUrlArchivoAttribute()
    {
        if (!$this->archivo) {
            return null;
        }

        return Storage::disk('public')->url($this->archivo);
    }

    /**
     * Verificar si el archivo existe físicamente
     */
    public function archivoExiste()
    {
        return $this->archivo && Storage::disk('public')->exists($this->archivo);
    }

    /**
     * Obtener el ícono según la extensión del archivo
     */
    public function getIconoArchivo()
    {
        $extension = strtolower($this->extension_archivo);

        switch ($extension) {
            case 'pdf':
                return '📄';
            case 'doc':
            case 'docx':
                return '📝';
            default:
                return '📎';
        }
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para documentos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para documentos aprobados
     */
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    /**
     * Scope para documentos rechazados
     */
    public function scopeRechazados($query)
    {
        return $query->where('estado', 'rechazado');
    }

    /**
     * Scope para búsqueda por nombre
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('descripcion', 'like', '%' . $termino . '%');
    }

    /**
     * Marcar como revisado
     */
    public function marcarComoRevisado($revisorId = null, $comentarios = null)
    {
        $this->update([
            'estado' => 'revisado_por_tutor',
            'fecha_revision' => now(),
            'revisado_por' => $revisorId,
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Aprobar documento
     */
    public function aprobar($revisorId = null, $comentarios = null)
    {
        $this->update([
            'estado' => 'aprobado',
            'fecha_revision' => now(),
            'revisado_por' => $revisorId,
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Rechazar documento
     */
    public function rechazar($revisorId = null, $comentarios = null)
    {
        $this->update([
            'estado' => 'rechazado',
            'fecha_revision' => now(),
            'revisado_por' => $revisorId,
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Verificar si el documento puede ser editado
     */
    public function puedeSerEditado()
    {
        return in_array($this->estado, ['pendiente', 'rechazado']);
    }

    /**
     * Verificar si el documento está en proceso de revisión
     */
    public function estaEnRevision()
    {
        return $this->estado === 'revisado_por_tutor';
    }

    /**
     * Verificar si el documento está finalizado (aprobado o rechazado)
     */
    public function estaFinalizado()
    {
        return in_array($this->estado, ['aprobado', 'rechazado']);
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Al eliminar un documento, también eliminar el archivo físico
        static::deleting(function ($documento) {
            if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                Storage::disk('public')->delete($documento->archivo);
            }
        });
    }
}
