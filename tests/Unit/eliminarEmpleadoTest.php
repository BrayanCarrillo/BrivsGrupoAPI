<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Staff;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmployeeControllerTest extends TestCase
{
    /**
     * Test eliminarEmpleado function.
     */
    public function test_eliminar_empleado()
    {
        // Crear un mock del modelo Staff
        $staffMock = Mockery::mock(Staff::class);

        // Configurar el mock para que el método find devuelva el mock de Staff
        $staffMock->shouldReceive('find')->with(1)->andReturn($staffMock);
        $staffMock->shouldReceive('delete')->andReturn(true);

        // Reemplazar el modelo Staff por el mock
        $this->instance(Staff::class, $staffMock);

        // Instanciar el controlador y llamar a la función eliminarEmpleado
        $controller = new EmployeeController();
        $response = $controller->eliminarEmpleado(1);

        // Verificar que la respuesta sea la esperada
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(['message' => 'Empleado eliminado'], $response->getData(true));
    }
}
