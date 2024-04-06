<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::post('tabla_productos', [ProductoController::class, 'tablaProductos'])->name('tabla_productos');
Route::post('registrar_producto', [ProductoController::class, 'registrar'])->name('registrar_producto');
Route::post('editar_producto', [ProductoController::class, 'editar'])->name('editar_producto');
Route::post('cargar_producto', [ProductoController::class, 'cargar'])->name('cargar_producto');
Route::post('eliminar_producto', [ProductoController::class, 'eliminar'])->name('eliminar_producto');
