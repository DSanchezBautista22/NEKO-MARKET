<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = ['emisor_id', 'receptor_id', 'producto_id', 'contenido', 'leido'];

    /**
     * Casts
     *
     * @var array<string,string>
     */
    protected $casts = [
        'leido' => 'boolean',
    ];

    // Relaciones para saber quién envía y quién recibe
    public function emisor() { return $this->belongsTo(User::class, 'emisor_id'); }
    public function receptor() { return $this->belongsTo(User::class, 'receptor_id'); }
    public function producto() { return $this->belongsTo(Producto::class); }
}