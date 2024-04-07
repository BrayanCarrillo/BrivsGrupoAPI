<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OrdenController;
use App\Models\Staff;
use App\Models\Admin;
use App\Models\Mesa;
use App\Models\MenuItem;
use App\Models\Menu;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuPlatoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GananciasController;
use App\Http\Controllers\ListaVentasController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Http\Controllers\InsertarOrdenController;
use App\Http\Controllers\ContrasenaController;
use App\Http\Controllers\ChefController;
// controlador categoria menu 


#/////////////////////General para todos los usuarios//////////////////////////
# Inicio Usuarios
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin_dashboard', [AuthController::class, 'adminDashboard'])->name('admin_dashboard');
Route::get('/chef_dashboard', [AuthController::class, 'chefDashboard'])->name('chef_dashboard');
Route::get('/mesero_dashboard', [AuthController::class, 'meseroDashboard'])->name('mesero_dashboard');



#Lista de Ordenes que ya estan listas
Route::get('/ordenes/listas', [OrdenController::class, 'listarOrdenesListas']);
#Actualizar contraseña usuarios



// Ruta para cambiar la contraseña de usuarios
Route::get('/empleados', [ContrasenaController::class, 'index'])->name('empleados.index');

Route::put('/empleados/{id}/cambiar-contrasena', [ContrasenaController::class, 'cambiarContrasena'])->name('empleados.cambiar_contrasena');

// Controlador para cambiar la contraseña de usuarios
Route::put('/cambiar-contrasena/{userID}', function ($userID, Request $request) {
    // Validar los datos de la solicitud
    $request->validate([
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,staff',
    ]);

    // Buscar al usuario por su ID
    $user = null;
    if ($request->role === 'admin') {
        $user = Admin::find($userID);
    } elseif ($request->role === 'staff') {
        $user = Staff::find($userID);
    }

    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    // Cambiar la contraseña del usuario
    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
});

#////////////////////////ADMINISTRADOR/////////////////////////////////////

#Lista del nombre de todos los empleados con su estado Nombre - estado

Route::get('/employees', function () {
    // Obtener todos los empleados con solo el nombre y su estado
    $employees = Staff::all(['username', 'status']);

    // Devolver la respuesta como JSON con la lista de empleados
    return response()->json(['employees' => $employees]);
});


// Rutas para platos del menú
Route::post('/platos', [MenuPlatoController::class, 'agregarPlato']);
Route::put('/platos/{itemID}', [MenuPlatoController::class, 'editarPlato']);
Route::delete('/platos/{itemID}', [MenuPlatoController::class, 'eliminarPlato']);

#-----------------Admnistración del menu-----------------------------

#-----------------Categoria------------------------------------------

// Rutas relacionadas con la administración de categorías de menú
Route::get('/menu-categories', [MenuCategoryController::class, 'index']); // Obtener todas las categorías de menú
Route::get('/menu-categories/{id}', [MenuCategoryController::class, 'show']); // Mostrar una categoría de menú específica
Route::post('/menu-categories', [MenuCategoryController::class, 'store']); // Crear una nueva categoría de menú
Route::put('/menu-categories/{id}', [MenuCategoryController::class, 'update']); // Actualizar una categoría de menú existente
Route::delete('/menu-categories/{id}', [MenuCategoryController::class, 'destroy']); // Eliminar una categoría de menú

#----------------------Menu PLatos-----------------------------------

// ver todos los platos 
Route::get('/menu-items', [MenuPlatoController::class, 'obtenerPlatos']);

//mostratar cada plato dependiendo de su categoria

Route::get('/menu/{menu_id?}', function ($menu_id = null) {

    if ($menu_id !== null) {
        $menu = Menu::find($menu_id);

        if ($menu) {
            $menu_items = MenuItem::where('menuID', $menu_id)->get();

            $serialized_menu = $menu->toArray();
            $serialized_menu_items = $menu_items->toArray();

            return response()->json(["menu" => $serialized_menu, "menu_items" => $serialized_menu_items]);
        } else {
            return response()->json(["error" => "Categoría no encontrada"], 404);
        }
    } else {
        $all_menus = Menu::all();

        $serialized_menus = $all_menus->toArray();

        return response()->json(["menus" => $serialized_menus]);
    }
});

// Obtener todos los platos
Route::get('/menu-platos', [MenuPlatoController::class, 'obtenerPlatos']);

// Obtener un plato por ID
Route::get('/menu-platos/{itemID}', [MenuPlatoController::class, 'obtenerPlato']);

// Editar plato
Route::put('/menu-platos/{itemID}', [MenuPlatoController::class, 'editarPlato']);

// Eliminar plato
Route::delete('/menu-platos/{itemID}', [MenuPlatoController::class, 'eliminarPlato']);

// Agregar plato
Route::post('/menu-platos', [MenuPlatoController::class, 'agregarPlato']);

#---------------------Administracion de ventas-----------------------
#Consulta - Estadisticas de ganancia de ventas


Route::get('/ganancias/hoy', [GananciasController::class, 'gananciasHoy']);
Route::get('/ganancias/semana', [GananciasController::class, 'gananciasSemana']);
Route::get('/ganancias/mes', [GananciasController::class, 'gananciasMes']);
Route::get('/ganancias/todo-el-tiempo', [GananciasController::class, 'gananciasTodoElTiempo']);

#Lista de ordenes vendidas

Route::get('/ordenes', [ListaVentasController::class, 'listarOrdenes']);

#---------------------Adminitracion de empleados--------------------
Route::get('/empleados', [EmployeeController::class, 'listarEmpleados']);
Route::post('/empleados', [EmployeeController::class, 'agregarEmpleado']);
Route::delete('/empleados/{id}', [EmployeeController::class, 'eliminarEmpleado']);
Route::put('/empleados/{id}', [EmployeeController::class, 'actualizarEmpleado']);
Route::put('/empleados/{id}/rol', [EmployeeController::class, 'actualizarRolEmpleado']);

#-------------------Mesas Admin Gestion-----------------------------
// Rutas para operaciones CRUD de mesas
Route::get('/mesas', [MesaController::class, 'index']); // Obtener todas las mesas
Route::get('/mesas/{id}', [MesaController::class, 'show']); // Mostrar una mesa específica
Route::post('/mesas', [MesaController::class, 'store']); // Crear una nueva mesa
Route::put('/mesas/{id}', [MesaController::class, 'update']); // Actualizar una mesa existente
Route::delete('/mesas/{id}', [MesaController::class, 'destroy']); // Eliminar una mesa
#-------------------Ajustes-----------------------------------------
#Actualizar Contraseña de usuario logueado

#-----------------Cerrarsesión?-------------------------------------
#Nose si se puede hacer con una ruta o como funcione

#///////////////////////////MESERO////////////////////////
#GENERAL lista de ordenes listas
#OPCIONAL ver nombre del empleado que inicio sesión y su rol
#OPCIONAL Actualizar estado de empleado de online a offline

#----------------------Tomar ordenes------------------------------
#Lista de todas las categorias

//Route::get('/categories', function () {
 //   $categories = Menu::all();
//    return response()->json(['categories' => $categories]);
//});

#Lista de todo el menu (Caegorias)
//Route::get('/menu', function () {
//    $all_menus = Menu::all();
//    $serialized_menus = $all_menus->toArray();
//    return response()->json(["menus" => $serialized_menus]);
//});

#Lista de menu dependiendo de la categoria seleccionada
//*Route::get('/menu/{menu_id?}', function ($menu_id = null) {

//if ($menu_id !== null) {
  //      $menu = Menu::find($menu_id);
//
    //    if ($menu) {
  //          $menu_items = MenuItem::where('menuID', $menu_id)->get();
//
    //        $serialized_menu = $menu->toArray();
  //          $serialized_menu_items = $menu_items->toArray();
//
  //          return response()->json(["menu" => $serialized_menu, "menu_items" => $serialized_menu_items]);
 //       } else {
//            return response()->json(["error" => "Categoría no encontrada"], 404);
//        }
//    } else {
 //       $all_menus = Menu::all();

//        $serialized_menus = $all_menus->toArray();
//
//        return response()->json(["menus" => $serialized_menus]);
//    }
//});

//obtener todas las mesas 
// Ruta para obtener todas las mesas
Route::get('obtener-mesas', [InsertarOrdenController::class, 'obtenerMesas']);

#Crear pedido insertado osea insertar pedidos nuevos: Nombre-precio-mesa-Valor total (CORREGIR EXISTENTE)
Route::get('/categorias-platos', [InsertarOrdenController::class, 'obtenerCategoriasPlatos']);

// Ruta para insertar una orden
Route::post('/insertar-orden', [InsertarOrdenController::class, 'insertarOrden']);


#-------------------Ajustes-----------------------------------------
#Actualizar Contraseña de usuario logueado

#////////////////////////CHEF/////////////////////////////////////////
#GENERAL Lista de ordenes listas
#OPCIONAL Ver nombre de empleado que inicio sesión-Rol
#OPCIONAL Actualizar estado de empleado Online a offline



//corregido 


Route::get('/chef/all-orders', [ChefController::class, 'getAllOrdersWithDetails']);
Route::put('/chef/update-order-status/{orderId}', [ChefController::class, 'updateOrderStatus']);
Route::delete('/chef/delete-order/{orderId}', [ChefController::class, 'deleteOrder']);



#--------------------Cocina planel de control-------------------

   // Obtener todos los detalles de un pedido por su ID
Route::get('/order-details/{orderId}', function ($orderId) {
    $orderDetails = OrderDetail::where('orderID', $orderId)->get();
    return response()->json($orderDetails);
});


    // Actualizar estado de orden a preparando y listo
// Actualizar estado de orden a preparando, waiting y listo
Route::put('/order-status/{orderId}', function (Request $request, $orderId) {
    $request->validate([
        'status' => 'required|in:preparando,Esperando,listo',
    ]);

    $order = Order::findOrFail($orderId);
    $order->status = $request->status;
    $order->save();

    return response()->json(['message' => 'Estado de orden actualizado con éxito']);
});


    // Obtener todas las órdenes
    Route::get('/orders', function () {
        $orders = Order::all();
        return response()->json($orders);
    });

  // Eliminar una orden y su detalle por su ID
Route::delete('/orders/{orderId}', function ($orderId) {
    // Buscar y eliminar la orden
    $order = Order::findOrFail($orderId);
    $order->delete();

    // Buscar y eliminar todos los detalles de la orden
    OrderDetail::where('orderID', $orderId)->delete();

    return response()->json(['message' => 'Orden y detalles de orden eliminados correctamente']);
});

#-------------------Ajustes-----------------------------------------
#Actualizar Contraseña de usuario logueado
