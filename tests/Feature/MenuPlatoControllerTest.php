<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\MenuItem;
use App\Models\Menu;

class MenuPlatoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_obtener_platos()
    {
        $menu = Menu::create(['menuName' => 'Test Menu']);
        $plato = MenuItem::create(['menuItemName' => 'Test Item', 'price' => 100, 'menuID' => $menu->id]);

        $response = $this->getJson('/api/platos');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'menuItemName' => 'Test Item',
                'menu' => 'Test Menu',
                'price' => 100,
            ]);
    }

    /** @test */
    public function it_should_editar_plato()
    {
        $menu = Menu::create(['menuName' => 'Test Menu']);
        $plato = MenuItem::create(['menuItemName' => 'Test Item', 'price' => 100, 'menuID' => $menu->id]);

        $response = $this->putJson('/api/platos/' . $plato->id, [
            'menuItemName' => 'Updated Item',
            'price' => 150,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'menuItemName' => 'Updated Item',
                'price' => 150,
            ]);

        $this->assertDatabaseHas('menu_items', [
            'id' => $plato->id,
            'menuItemName' => 'Updated Item',
            'price' => 150,
        ]);
    }

    /** @test */
    public function it_should_eliminar_plato()
    {
        $plato = MenuItem::create(['menuItemName' => 'Test Item', 'price' => 100]);

        $response = $this->deleteJson('/api/platos/' . $plato->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Plato eliminado']);

        $this->assertDatabaseMissing('menu_items', ['id' => $plato->id]);
    }

    /** @test */
    public function it_should_agregar_plato()
    {
        $menu = Menu::create(['menuName' => 'Test Menu']);

        $response = $this->postJson('/api/platos', [
            'menuItemName' => 'New Item',
            'price' => 120,
            'menuID' => $menu->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'menuItemName' => 'New Item',
                'price' => 120,
                'menuID' => $menu->id,
            ]);

        $this->assertDatabaseHas('menu_items', [
            'menuItemName' => 'New Item',
            'price' => 120,
            'menuID' => $menu->id,
        ]);
    }

    /** @test */
    public function it_should_obtener_platos_por_categoria()
    {
        $menu = Menu::create(['menuName' => 'Test Menu']);
        $plato = MenuItem::create(['menuItemName' => 'Test Item', 'price' => 100, 'menuID' => $menu->id]);

        $response = $this->getJson('/api/platos/categoria/' . $menu->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'menuItemName' => 'Test Item',
                'menu' => 'Test Menu',
                'price' => 100,
            ]);
    }

    /** @test */
    public function it_should_cambiar_estado_plato()
    {
        $plato = MenuItem::create(['menuItemName' => 'Test Item', 'price' => 100, 'activate' => true]);

        $response = $this->patchJson('/api/platos/' . $plato->id . '/estado', ['activate' => false]);

        $response->assertStatus(200)
            ->assertJsonFragment(['activate' => false]);

        $this->assertDatabaseHas('menu_items', [
            'id' => $plato->id,
            'activate' => false,
        ]);
    }
}
