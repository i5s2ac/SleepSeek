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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('correo_creador'); 
            $table->string('title'); 
            $table->text('description'); 
            $table->string('location')->nullable();  
            $table->date('start_date')->nullable();  
            $table->date('end_date')->nullable();  
            $table->string('status')->default('disponible');  
            $table->timestamps();
        });

        Schema::create('reserva_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserva_id');
            $table->text('image_path');
            $table->timestamps();

            // Esto crea una llave foránea que relaciona la imagen con la reserva.
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Importante: Eliminamos en el orden inverso al que creamos.
        Schema::dropIfExists('reserva_images');
        Schema::dropIfExists('reservas');
    }
};
