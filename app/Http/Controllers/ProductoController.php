<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function registrar(Request $request)
    {

        try {
            // Excluye el token CSRF del request
            $data = $request->except('_token');

            // Crea el producto con los datos validados
            Producto::create($data);

            // Devuelve una respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Producto registrado correctamente'
            ]);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que ocurra durante el proceso de registro
            // Devuelve una respuesta de error
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar el producto: ' . $e->getMessage()
            ], 500); // Código de estado HTTP 500 para indicar un error interno del servidor
        }
    }

    public function editar(Request $request)
    {
        // Obtén el ID del producto que se está actualizando desde la solicitud
        $productoId = $request->id;

        try {
            // Excluye el token CSRF y el ID del request
            $data = $request->except(['_token', 'id']);

            // Encuentra el producto existente por su ID y actualiza los datos
            $producto = Producto::findOrFail($productoId);
            $producto->update($data);

            // Devuelve una respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Producto actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            // Maneja cualquier excepción que ocurra durante el proceso de actualización
            // Devuelve una respuesta de error
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500); // Código de estado HTTP 500 para indicar un error interno del servidor
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function tablaProductos()
    {
        //
        $productos = Producto::all();
        return DataTables()->of($productos)->make(true);
    }

    public function cargar(Request $request)
    {
        $producto = Producto::find($request->id);
        return response()->json($producto);
    }

    public function eliminar(Request $request)
    {
        try {
            // Encuentra el producto por su ID
            $producto = Producto::find($request->id);

            // Verifica si se encontró el producto
            if (!$producto) {
                // Si no se encuentra el producto, devuelve un mensaje de error
                return response()->json(['message' => 'Producto no encontrado'], 404);
            }

            // Elimina el producto
            $producto->delete();

            // Devuelve un mensaje de éxito
            return response()->json(['message' => 'Producto eliminado correctamente']);
        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje de error con el código de estado HTTP 500
            return response()->json(['message' => 'Error al eliminar el producto: ' . $e->getMessage()], 500);
        }
    }
}
