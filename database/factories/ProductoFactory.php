<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'precio' => $this->faker->randomFloat(2, 1, 1000),
            'estado_conservacion' => 'Usado',
            'tiene_caja_original' => false,
            'imagen_url' => null,
            'user_id' => User::factory(),
        ];
    }
}
