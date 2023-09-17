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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();  // ID único de la plaza
            $table->string('correo_creador')->unique(); 
            $table->string('title');  // Título de la plaza
            $table->text('description');  // Descripción detallada del trabajo
            $table->string('location')->nullable();  // Ubicación del trabajo (puede ser nulo)
            $table->date('start_date')->nullable();  // Fecha de inicio del trabajo (puede ser nulo)
            $table->date('end_date')->nullable();  // Fecha de finalización (puede ser nulo)
            $table->decimal('salary', 8, 2)->nullable();  // Salario ofrecido (puede ser nulo)
            $table->string('company');  // Nombre de la empresa que ofrece la plaza
            $table->string('status')->default('open');  // Estado de la plaza (puede ser 'open', 'closed', etc.)
            $table->timestamps();  // Crea las columnas 'created_at' y 'updated_at' automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};