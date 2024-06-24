<?php

namespace Tests\Unit;
//verifica que todas las funciones del controlador messacontroller funcionen correctamente
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Mesa;

class MesaControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_and_retrieve_a_mesa()
    {
        // Crear una nueva mesa
        $mesaData = [
            'mesaID' => 1,
            'activate' => true,
        ];

        // Crear la mesa
        $response = $this->postJson('/api/mesas', $mesaData);
        $response->assertStatus(201)
                 ->assertJson($mesaData);

        // Obtener la mesa creada
        $response = $this->getJson('/api/mesas/1');
        $response->assertStatus(200)
                 ->assertJson($mesaData);
    }
}
