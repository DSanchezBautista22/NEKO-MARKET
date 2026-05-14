<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Producto;
use App\Models\Mensaje;
use Tests\TestCase;

class MensajeActionsTest extends TestCase
{
    public function test_no_puedes_enviar_a_un_receptor_que_no_es_vendedor()
    {
        $sender = User::factory()->create();
        $vendedor = User::factory()->create();
        $otro = User::factory()->create();

        $producto = Producto::factory()->create(['user_id' => $vendedor->id]);

        $response = $this->actingAs($sender)->post(route('mensajes.store'), [
            'receptor_id' => $otro->id, // no es el vendedor
            'producto_id' => $producto->id,
            'contenido' => 'Hola',
        ]);

        $response->assertSessionHasErrors('receptor_id');
    }

    public function test_el_receptor_puede_marcar_mensaje_como_leido()
    {
        $sender = User::factory()->create();
        $vendedor = User::factory()->create();
        $producto = Producto::factory()->create(['user_id' => $vendedor->id]);

        $mensaje = Mensaje::create([
            'emisor_id' => $sender->id,
            'receptor_id' => $vendedor->id,
            'producto_id' => $producto->id,
            'contenido' => 'Hola',
        ]);

        $response = $this->actingAs($vendedor)->post(route('mensajes.leido', $mensaje->id));
        $response->assertSessionHas('success');

        $this->assertTrue(Mensaje::find($mensaje->id)->leido);
    }
}
