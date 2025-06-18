<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('archivo');
            $table->string('nombre_archivo')->nullable(); // Nombre original del archivo
            $table->unsignedBigInteger('tamaño_archivo')->nullable(); // Tamaño en bytes
            $table->enum('estado', ['pendiente', 'revisado_por_tutor', 'aprobado', 'rechazado'])
                ->default('pendiente');
            $table->text('comentarios')->nullable();
            $table->timestamp('fecha_revision')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Índices para mejorar el rendimiento
            $table->index(['user_id', 'estado']);
            $table->index(['estado']);
            $table->index(['created_at']);
            $table->index(['user_id', 'created_at']);

            // Índice único para evitar nombres duplicados por usuario
            $table->unique(['user_id', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
