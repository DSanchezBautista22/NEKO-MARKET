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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            
            // Emisor y Receptor vinculados a la tabla users
            $table->foreignId('emisor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receptor_id')->constrained('users')->onDelete('cascade');
            
            // Vinculamos el mensaje a un producto para saber de qué hablan
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            $table->text('contenido');
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};