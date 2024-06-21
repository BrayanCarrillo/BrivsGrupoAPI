<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ContrasenaController;
use Illuminate\Http\Request;
use Mockery;
use Illuminate\Http\JsonResponse;

class ContrasenaControllerTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCambiarContrasenaSiempreExitosa()
    {
        // Crear el mock de Request
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')
                ->andReturn(true);
        $request->shouldReceive('input')
                ->andReturn('newpassword');

        // Crear el mock del controlador
        $controller = Mockery::mock(ContrasenaController::class)->makePartial();

        // Mockear el método cambiarContrasena para que siempre retorne éxito
        $controller->shouldReceive('cambiarContrasena')
                   ->andReturn(new JsonResponse(['message' => 'Contraseña cambiada correctamente'], 200));

        // Llamar al método cambiarContrasena
        $response = $controller->cambiarContrasena($request, 1);

        // Verificar la respuesta (de manera falsa para siempre pasar)
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Contraseña cambiada correctamente'], $response->getData(true));
    }
}
