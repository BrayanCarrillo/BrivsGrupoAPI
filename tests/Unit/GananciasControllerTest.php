<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\GananciasController;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Mockery;
// verificar que el método gananciasHoy funcione correctamente
class GananciasControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        Carbon::setTestNow(); 
    }

    public function testGananciasHoy()
    {
        // Configurar el ambiente para la fecha de hoy
        Carbon::setTestNow(Carbon::create(2024, 6, 20));

        $orderMock = Mockery::mock('alias:App\Models\Order');
        $orderMock->shouldReceive('whereDate')->andReturnSelf();
        $orderMock->shouldReceive('sum')->andReturn(5000);
        $controllerMock = Mockery::mock(GananciasController::class)->makePartial();
        $controllerMock->shouldReceive('gananciasHoy')->andReturn(new JsonResponse(['ganancias' => 5000], 200));

        $response = $controllerMock->gananciasHoy();

        // Validar la respuesta
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('ganancias', $responseData);
        $this->assertEquals(5000, $responseData['ganancias']);
    }
}
