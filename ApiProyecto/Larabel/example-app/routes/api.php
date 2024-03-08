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


#/////////////////////General para todos los usuarios//////////////////////////
# Inicio Usuarios
Route::post('/login', [AuthController::class, 'login']);
Route::get('/admin_dashboard', [AuthController::class, 'adminDashboard'])->name('admin_dashboard');
Route::get('/chef_dashboard', [AuthController::class, 'chefDashboard'])->name('chef_dashboard');
Route::get('/mesero_dashboard', [AuthController::class, 'meseroDashboard'])->name('mesero_dashboard');
#Lista de Ordenes que ya estan listas
Route::get('/ordenes-listas', [OrdenController::class, 'listarOrdenesListas']);

#////////////////////////ADMINISTRADOR/////////////////////////////////////

#Lista del nombre de todos los empleados con su estado Nombre - estado


#-----------------Admnistración del menu-----------------------------

#-----------------Categoria------------------------------------------
#Agregar Categoria
#Eliminar Categoria
#Editar nombre Categoria
#----------------------Menu PLatos-----------------------------------
#editar plato
#eliminar plato
#agregar plato
    
#---------------------Administracion de ventas-----------------------
#Consulta - Estadisticas de ganancia de ventas
#Lista de ordenes vendidas

#---------------------Adminitracion de empleados--------------------
#Lista de todos los empleados ID usuario Estado rol
#Eliminar empleados con una ID especifica
#Actualizar empleados
#Eliminar empleados
#Agregar empleados

#-------------------Mesas Admin Gestion-----------------------------
// Rutas CRUD para el modelo Mesa
#Lista de Mesas todas
Route::get('/mesas', [MesaController::class, 'index']);
#Lista de Mesa id especifica
Route::get('/mesas/{id}', [MesaController::class, 'show']);
#Agregar Mesa
Route::post('/mesas', [MesaController::class, 'store']);
#Actualizar mesa
Route::put('/mesas/{id}', [MesaController::class, 'update']);
#Eliminar mesa especifica con una ID
Route::delete('/mesas/{id}', [MesaController::class, 'destroy']);

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

#Lista de todo el menu 
Route::get('/menu', function () {
    $all_menus = Menu::all();
    $serialized_menus = $all_menus->toArray();
    return response()->json(["menus" => $serialized_menus]);
});

#Lista de menu dependiendo de la categoria seleccionada
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
#Crear pedido insertado osea insertar pedidos nuevos: Nombre-precio-mesa-Valor total (CORREGIR EXISTENTE)


#-------------------Ajustes-----------------------------------------
#Actualizar Contraseña de usuario logueado

#////////////////////////CHEF/////////////////////////////////////////
#GENERAL Lista de ordenes listas
#OPCIONAL Ver nombre de empleado que inicio sesión-Rol
#OPCIONAL Actualizar estado de empleado Online a offline

#--------------------Cocina planel de control-------------------
#numero de orden categoria nombre del plato cantidad estado
#Actualizar estado de orden a preparando y listo
#Eliminar orden de la lista
# Eliminar un pedido por su ID
# Obtener todos los detalles de un pedido por su ID


#-------------------Ajustes-----------------------------------------
#Actualizar Contraseña de usuario logueado
