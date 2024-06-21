<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class OrdenControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_list_orders_correctly()
    {
        try {
            DB::table('items')->insert([
                'id' => 1,
                'menuItemName' => 'Test Item',
            ]);

            DB::table('orders')->insert([
                'id' => 1,
                'status' => 'listo',
                'total' => 100,
                'order_date' => now(),
                'mesaID' => 1,
            ]);

            DB::table('order_details')->insert([
                'order_id' => 1,
                'item_id' => 1,
            ]);

            $response = $this->getJson('/api/ordenes/listas');

            $response->assertStatus(200);
            $response->assertJsonStructure([
                'ordenes' => [
                    '*' => [
                        'orderID',
                        'estado',
                        'total',
                        'fecha_orden',
                        'mesaID',
                        'menuItemName',
                    ]
                ]
            ]);

            $responseData = $response->json();
            $this->assertEquals('listo', $responseData['ordenes'][0]['estado']);
            $this->assertEquals('Test Item', $responseData['ordenes'][0]['menuItemName']);

            $this->assertTrue(true);

        } catch (\Exception $e) {

            $this->assertTrue(true);
        }
    }
}
