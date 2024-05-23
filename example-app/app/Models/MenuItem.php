<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'tbl_menuitem';
    protected $primaryKey = 'itemID';
    public $timestamps = false;

    protected $fillable = ['menuID', 'menuItemName', 'price', 'activate']; // Agrega 'estatus' a los atributos asignables

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menuID');
    }
    
    // Activar o desactivar un plato
public function cambiarEstadoPlato(Request $request, $itemID)
{
    $plato = MenuItem::find($itemID);
    if (!$plato) {
        return response()->json(['message' => 'Plato no encontrado'], 404);
    }

    // Verificar si se proporciona el estado en la solicitud
    if ($request->has('activate')) {
        // Obtener el nuevo estado y asegurarse de que sea booleano
        $activate = filter_var($request->input('activate'), FILTER_VALIDATE_BOOLEAN);
        $plato->activate = $activate;
        $plato->save();

        $mensaje = $activate ? 'Plato activado' : 'Plato desactivado';
        return response()->json(['message' => $mensaje], 200);
    } else {
        return response()->json(['message' => 'Estado no proporcionado en la solicitud'], 400);
    }
}

}
