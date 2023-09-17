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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};