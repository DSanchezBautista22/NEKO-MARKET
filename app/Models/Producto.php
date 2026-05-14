<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
    'categoria',
        'precio',
        'estado_conservacion',
        'tiene_caja_original',
        'imagen_url',
        'user_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE LA BASE DE DATOS
    |--------------------------------------------------------------------------
    | Aquí le decimos a Laravel que cada Producto "pertenece a" (belongsTo) 
    | un Usuario específico. Esto soluciona el RelationNotFoundException.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}