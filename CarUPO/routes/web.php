<?php

use Illuminate\Support\Facades\Route;

// Aqui estan todos los controllers que se usarán
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AccesoriosController;
use App\Http\Controllers\Carrito_comprasController;
use App\Http\Controllers\CochesController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\Linea_carritosController;
use App\Http\Controllers\Linea_comprasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsersController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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


// REDIRECCIONES (La unica funcionalidad es llevarte a una pagina web)

Route::get('/', [PagesController::class, 'inicio'])->name('inicio');
Route::get('/crearAccesorio', [PagesController::class, 'crearAccesorio'])->name('crearAccesorio')->middleware(['auth', 'verified']);
Route::get('/crearCoche', [PagesController::class, 'crearCoche'])->name('crearCoche')->middleware(['auth', 'verified']);
Route::get('/perfil', [PagesController::class, 'verPerfil'])->name('miPerfil')->middleware(['auth', 'verified']);


// AUTENTIFICACIÓN
Route::get('/home', function () {
    return view('auth.dashboard');
})->middleware(['auth', 'verified']);



//PRODUCTOS
Route::get('/productos', [ProductosController::class, 'mostrarProductos'])->name('mostrarProductos')->middleware(['auth', 'verified']);
Route::get('/productosFiltrados', [ProductosController::class, 'filtrarProductos'])->name('filtrarProductos')->middleware(['auth', 'verified']);



//ACCESORIOS
Route::get('/accesorio', [AccesoriosController::class, 'verMostrarAccesorio'])->name('verAccesorio')->middleware(['auth', 'verified']);
Route::get('/accesorios', [AccesoriosController::class, 'mostrarAccesorios'])->name('mostrarAccesorios')->middleware(['auth', 'verified']);
Route::get('/accesoriosFiltrados', [AccesoriosController::class, 'filtrarAccesorios'])->name('filtrarAccesorios')->middleware(['auth', 'verified']);
Route::get('/editarAccesorio', [AccesoriosController::class, 'verEditarAccesorio'])->name('ver.accesorio.editar')->middleware(['auth', 'verified']);
Route::post('/accesorios', [AccesoriosController::class, 'crearAccesorio'])->name('addAccesorio')->middleware(['auth', 'verified']);
Route::post('/accesorio', [AccesoriosController::class, 'verMostrarAccesorio'])->name('verAccesorio')->middleware(['auth', 'verified']);
Route::post('/editarAccesorio', [AccesoriosController::class, 'verEditarAccesorio'])->name('ver.accesorio.editar')->middleware(['auth', 'verified']);
Route::put('/accesorios', [AccesoriosController::class, 'editarAccesorio'])->name('editar.accesorio')->middleware(['auth', 'verified']);
Route::post('/borrarAccesorio', [AccesoriosController::class, 'verBorrarAccesorio'])->name('ver.accesorio.borrar')->middleware(['auth', 'verified']);
Route::delete('/accesorios', [AccesoriosController::class, 'eliminarAccesorio'])->name('accesorio.borrar')->middleware(['auth', 'verified']);


//COCHES
Route::get('/coche', [CochesController::class, 'verMostrarCoche'])->name('verCoche')->middleware(['auth', 'verified']);
Route::get('/coches', [CochesController::class, 'mostrarCoches'])->name('mostrarCoches')->middleware(['auth', 'verified']);
Route::get('/cochesFiltrados', [CochesController::class, 'filtrarCoches'])->name('filtrarCoches')->middleware(['auth', 'verified']);
Route::get('/editarCoche', [CochesController::class, 'verEditarCoche'])->name('ver.coche.editar')->middleware(['auth', 'verified']);
Route::post('/coches', [CochesController::class, 'crearCoche'])->name('addCoche')->middleware(['auth', 'verified']);
Route::post('/coche', [CochesController::class, 'verMostrarCoche'])->name('verCoche')->middleware(['auth', 'verified']);
Route::post('/editarCoche', [CochesController::class, 'verEditarCoche'])->name('ver.coche.editar')->middleware(['auth', 'verified']);
Route::put('/coches', [CochesController::class, 'editarCoche'])->name('editar.coche')->middleware(['auth', 'verified']);
Route::post('/borrarCoche', [CochesController::class, 'verBorrarCoche'])->name('ver.coche.borrar')->middleware(['auth', 'verified']);
Route::delete('/coches', [CochesController::class, 'eliminarCoche'])->name('coche.borrar')->middleware(['auth', 'verified']);


//COMPRAS
Route::get('/compras', [ComprasController::class, 'mostrarCompras'])->name('mostrarCompras')->middleware(['auth', 'verified']);
Route::get('/compra', [ComprasController::class, 'mostrarCompra'])->name('mostrarCompra')->middleware(['auth', 'verified']);
Route::get('/misCompras', [ComprasController::class, 'misCompras'])->name('misCompras')->middleware(['auth', 'verified']);
Route::put('/estadoActualizado', [ComprasController::class, 'actualizarEstado'])->name('actualizarEstado')->middleware(['auth', 'verified']);


//CARRITO
Route::get('/carrito', [Carrito_comprasController::class, 'mostrarCarrito'])->name('mostrarCarrito')->middleware(['auth', 'verified']);
Route::post('/comprarCarrito', [Carrito_comprasController::class, 'comprarCarrito'])->name('comprarCarrito')->middleware(['auth', 'verified']);


//LINEA DE CARRITO
Route::post('/addAlCarrito', [Carrito_comprasController::class, 'addToCarrito'])->name('addToCarrito')->middleware(['auth', 'verified']);
Route::post('/masLineaCarrito', [Carrito_comprasController::class, 'aumentarLineaCarrito'])->name('masLineaCarrito')->middleware(['auth', 'verified']);
Route::post('/menosLineaToCarrito', [Carrito_comprasController::class, 'disminuirLineaCarrito'])->name('menosLineaCarrito')->middleware(['auth', 'verified']);

//FAVORITOS
Route::get('/misFavoritos', [FavoritosController::class, 'misFavoritos'])->name('misFavoritos')->middleware(['auth', 'verified']);
Route::post('/addFavorito', [FavoritosController::class, 'addToFavoritos'])->name('addToFavoritos')->middleware(['auth', 'verified']);
Route::delete('/deleteFavorito', [FavoritosController::class, 'removeToFavoritos'])->name('eliminarFavorito')->middleware(['auth', 'verified']);
Route::get('/rankingFavoritos', [FavoritosController::class, 'rankingFavoritos'])->name('mostrarRankingFavoritos')->middleware(['auth', 'verified']);

//CATEGORIAS
Route::get('/categorias', [CategoriasController::class, 'mostrarCategorias'])->name('verCategorias')->middleware(['auth', 'verified']);
Route::post('/addCategoria', [CategoriasController::class, 'addToCategorias'])->name('addToCategorias')->middleware(['auth', 'verified']);
Route::delete('/removeCategoria', [CategoriasController::class, 'removeToCategorias'])->name('removeToCategorias')->middleware(['auth', 'verified']);
Route::put('/editCategoria', [CategoriasController::class, 'editarCategoria'])->name('editarCategoria')->middleware(['auth', 'verified']);



//USUARIOS
Route::get('/usuarios', [UsersController::class, 'mostrarUsuarios'])->name('mostrarUsuarios')->middleware(['auth', 'verified']);
Route::get('/actualizaPass', [UsersController::class, 'actualizaPass'])->name('updatePass')->middleware(['auth', 'verified']);
Route::put('/actualizaPerfil', [UsersController::class, 'actualizarPerfil'])->name('updatePerfil')->middleware(['auth', 'verified']);
Route::put('/actualizaPass', [UsersController::class, 'updatePassword'])->name('updatePassword')->middleware(['auth', 'verified']);
