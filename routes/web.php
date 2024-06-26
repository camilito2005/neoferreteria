<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Models\Proveedor;
use App\Http\Controllers\paginacontrolador;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\HomeController;
use App\Models\Producto;

// use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth::routes();

/**
 * rutas de prueba
 * Route::get('nuevo', [cosasnuevasController::class, 'index'])->name('nuevo');
 */


//  Rutas finales
Route::get('/', function () {
    $card = Producto::all();
    return view('software.inicio.inicio-slider', compact('card'));
})->name('index.inicio');
Route::get('/Inicio Usuario', [HomeController::class, 'index_uno'])->name('inicio_home');
Route::get('yo', [ConfiguracionesController::class, 'yo'])->name('yo');
Route::put('yo/ag', ['as' => 'yoag', 'uses' => 'App\Http\Controllers\ConfiguracionesController@agregarUsuario']);
Route::post('mensaje', [MensajesController::class, 'mensajes'])->name('mensajes');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home_uno');
Route::get('/detalles/{id}', [CartController::class, 'verC'])->name('detalles');
Route::get('/catalogo', [CartController::class, 'shop'])->name('shop');
// Route::get('/carrito', [CartController::class, 'shop'])->name('shop');
Route::get('/carrito/actualizar', [CartController::class, 'actualizarCarrito'])->name('carrito.actualizar');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::post('/add', [CartController::class, 'add'])->name('cart.store');
Route::post('/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('pdf', [ProductoController::class, "pdf"])->name('pdf');
Route::get('pago', [CartController::class, "pago"])->name('pago');


/* Boquilla ruta modal */
Route::post('actualizarProveedor/{$id}' , [ProveedorController::class , 'update'])->name('actualizarProvee'); //no actualiza

Route::get('actualizar/{$id}' , [ProductoController::class , 'update'])->name('actualizarProducto'); // este es el de actualizar productos
/* La hora */

Route::get('/lahora', [ConfiguracionesController::class, "getDateTime"])->name('lahora');

/*  */
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('ingresar');
Route::put('/login', [LoginController::class, 'register'])->name('registrar');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/buscar', [ProductoController::class, "buscar"])->name('buscar');
Route::get('/buscarP', [ProductoController::class, 'buscarP'])->name('buscarP');

Route::middleware(['usuario'])->group(function () {
    // Route::get('/', function () {
    //     $card = Producto::all();
    //        return view('software.inicio.inicio-slider', compact('card'));
    // });

});

Route::middleware(['admin'])->group(function () {
    // Rutas para administradores
    Route::get('/homeAdmin', 'App\Http\Controllers\HomeController@inicioAdmin')->name('admin.inicio'); //->middleware('auth');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
        Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
        Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
        Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
        Route::get('usuarios', ['as' => 'pages.usuarios', 'uses' => 'App\Http\Controllers\PageController@usuarios']);
        Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
        Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
        Route::put('profile/actualizar', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
        Route::delete('profile/eliminar/{id}', ['as' => 'profile.eliminar', 'uses' => 'App\Http\Controllers\ProfileController@eliminar']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('agregar usuario', ['as' => 'profile.agregarruta', 'uses' => 'App\Http\Controllers\ProfileController@agregarruta']);
        Route::put('agregar usuario', ['as' => 'profile.agregar', 'uses' => 'App\Http\Controllers\ProfileController@agregarUsuario']);
        Route::put('/cambiar-rol/{user}/{nuevoRol}', ['as' => 'cambiar.rol', 'uses' => 'App\Http\Controllers\ProfileController@cambiarRol']);
    });
});

Route::middleware(['empleado'])->group(function () {
    // Rutas para los empleados
    Route::resource('productos', 'App\Http\Controllers\ProductoController')->middleware('auth');
    Route::resource('proveedor', 'App\Http\Controllers\ProveedorController');
    Route::get('proveedor', [ProveedorController::class, "index"])->name('proveedor')->middleware('auth');
    Route::put('profile/actualizar/empleado', ['as' => 'actualizar.empleado', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    // Route::delete('profile/eliminar/{id}', ['as' => 'profile.eliminar', 'uses' => 'App\Http\Controllers\ProfileController@eliminar']);
    Route::put('profile/password/empleado', ['as' => 'actualizarcontra.empleado', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::post('/obtener-direccion-proveedor', [ProveedorController::class, 'obtenerDireccionProveedor'])->name('obpro');
    Route::post('/obtener-pro', [ProductoController::class, 'obtenerP'])->name('obprodu');

    Route::get('facturacion', [ProductoController::class, "facturacion_vista"])->name('fa_vi');
    Route::post('factura', [ProductoController::class, "factura"])->name('factura');
    Route::get('ver producto', [ProductoController::class, "index"])->name('ver');
    Route::get('agregar', [paginacontrolador::class, "agregar"])->name('agregar');
    Route::get('token', [paginacontrolador::class, "token"])->name('token');
    Route::get('salir', [paginacontrolador::class, "principal"])->name('salir');
    Route::get('principal', [paginacontrolador::class, "principal"])->name('principal');
    Route::get('inicio', [paginacontrolador::class, "inicio"])->name('inicio');
    /*Route::get('graficas', [paginacontrolador::class, "graficas"])->name('graficas');*/
    Route::get('graficas', [ProductoController::class, "graficasventas"])->name('graficasventas');
    Route::post('agregar', [ProductoController::class, "guardar"])->name('guardar');
    Route::post('agregarc', [ProductoController::class, "guardarC"])->name('guardarC');
    Route::post('agregar/categoria', [CategoryController::class, "guardar_categoria"])->name('guardar.categoria');
    //Route::put('agregar/categoria', [CategoryController::class, "guardar_categoria"])->name('guardar.categoria');
    Route::get('ver productos', [ProductoController::class, "verproductos"])->name('verproductos');
    Route::get('agregar proveedor', [ProductoController::class, "agregarprovedor"])->name('agregarprovedor');
    Route::post('agregar proveedor', [ProveedorController::class, "aggpro"])->name('aggpro');
    // Route::get('login', [paginacontrolador::class, "login"])->name('login');
    // Route::post('registro', [paginacontrolador::class, "registro"])->name('registro');
    // Route::get('inicio/ajax', [paginacontrolador::class, "inicioajax"])->name('inicioajax');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::get('pagina principal', [ProductoController::class, "paginaprincipal"])->name('paginaprincipal');
    Route::get('cuenta', [paginacontrolador::class, "cuenta"])->name('cuenta');
    // Route::get('pdf', [ProductoController::class, "pdf"])->name('pdf');
    Route::get('graficass', [ProductoController::class, "graficasproduc"])->name('graficasproduc');
    Route::get('graficas lineales', [ProductoController::class, "graficasproducto1"])->name('graficasproducto1');

});
/* Route::get('graficass', [ProductoController::class, "graficasproduc"])->name('graficasproduc');
Route::get('graficas lineales', [ProductoController::class, "graficasproducto1"])->name('graficasproducto1'); */

