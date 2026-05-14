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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->string('estado_conservacion');
            $table->boolean('tiene_caja_original')->default(false);
            $table->string('imagen_url')->nullable();
        
            // Conecta el producto con el usuario que lo vende
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        
            $table->timestamps(); // Guarda la fecha de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
