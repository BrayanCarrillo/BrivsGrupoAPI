<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;

class MenuCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to change the status of a menu category.
     *
     * @return void
     */
    public function test_cambiar_estado_categoria()
    {
        // Crear una categoría de menú
        $categoria = Menu::create([
            'menuName' => 'Entradas',
            'activate' => true,
        ]);

        // Cambiar el estado de la categoría de menú
        $response = $this->json('PUT', route('menu.cambiarEstadoCategoria', $categoria->id), [
            'activate' => false,
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $categoria->id,
                     'activate' => false,
                 ]);

        // Verificar que el estado de la categoría haya cambiado en la base de datos
        $this->assertDatabaseHas('menus', [
            'id' => $categoria->id,
            'activate' => false,
        ]);
    }

    /**
     * Test to handle changing the status of a non-existent menu category.
     *
     * @return void
     */
    public function test_cambiar_estado_categoria_no_existente()
    {
        // Intentar cambiar el estado de una categoría de menú que no existe
        $response = $this->json('PUT', route('menu.cambiarEstadoCategoria', 999), [
            'activate' => false,
        ]);

        // Verificar que la respuesta sea 404
        $response->assertStatus(404)
                 ->assertJson([
                     'error' => 'Categoría de menú no encontrada',
                 ]);
    }
}
