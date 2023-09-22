<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            // Datos del solicitant
            $table->unsignedBigInteger('reserva_id'); // Esto crea la columna reserva_id como una clave foránea
            $table->string('correo')->unique(); // Debería coincidir con el correo en la tabla de usuarios
            $table->string('avatar')->nullable();
            $table->string('number')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('direction')->nullable();
            $table->string('dpi_photo')->nullable();
            $table->string('DPI')->unique()->nullable();
            $table->string('estado')->default('pendiente'); // O el tipo de datos adecuado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
