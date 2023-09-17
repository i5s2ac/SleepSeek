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
            $table->string('title'); 
            $table->text('description'); 
            $table->string('location')->nullable();  
            $table->date('start_date')->nullable();  
            $table->date('end_date')->nullable();  
            $table->string('status')->default('disponible');  
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