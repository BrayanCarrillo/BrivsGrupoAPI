<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ContrasenaController;
use Illuminate\Http\Request;
use Mockery;
use Illuminate\Http\JsonResponse;

//cambiar la contraseña de un usuario, en este caso pedro
class ContrasenaControllerTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCambiarContrasenaSiempreExitosa()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')
                ->andReturn(true);
        $request->shouldReceive('input')
                ->andReturn('newpassword');

        $controller = Mockery::mock(ContrasenaController::class)->makePartial();

        $controller->shouldReceive('cambiarContrasena')
                   ->andReturn(new JsonResponse(['message' => 'Contraseña cambiada correctamente'], 200));

        $response = $controller->cambiarContrasena($request, 1);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Contraseña cambiada correctamente'], $response->getData(true));
    }
}
