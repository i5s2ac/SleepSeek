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
    Schema::create('detalles_usuario', function (Blueprint $table) {
        $table->id();
        $table->string('correo')->unique();  // Esto debería coincidir con el correo en la tabla de usuarios
        $table->string('avatar')->nullable();
        $table->string('number')->unique()->nullable();
        $table->date('birthday')->nullable();
        $table->string('gender')->nullable();
        $table->string('country')->nullable();
        $table->string('direction')->nullable();
        $table->string('dpi_photo')->nullable();
        $table->string('DPI')->unique()->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_usuario');
    }
};
