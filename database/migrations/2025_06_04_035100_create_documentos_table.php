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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con estudiante
            $table->string('nombre');  // Nombre del documento
            $table->string('archivo'); // Ruta del archivo
            $table->enum('estado', ['Pendiente', 'Revisado por Tutor', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->text('comentarios')->nullable(); // Comentarios del tutor o coordinador
            $table->timestamps();
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
