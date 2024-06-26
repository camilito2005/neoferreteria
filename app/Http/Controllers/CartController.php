<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function shop()
    {
        $productos = Producto::all();
        /*         $totalQuantity = Session::has('carrito') ? count(Session::get('carrito')) : 0;
 */
        $cartCollection = Session::get('carrito', []);
        return view('software.carrito.shop')->withTitle('Catálogo')->with(['productos' => $productos, 'cartCollection' => $cartCollection]);
    }

    public function cart()
    {
        $cartCollection = Session::get('carrito', []);
        return view('software.carrito.cart')->withTitle('Catálogo | Carrito')->with(['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $cartCollection = Session::get('carrito', []);

        if (isset($cartCollection[$id])) {
            unset($cartCollection[$id]);
            Session::put('carrito', $cartCollection);
        }

        return redirect()->route('cart.index')->with('success_msg', 'Producto eliminado del carrito.');
    }

    public function actualizarCarrito()
    {
        $cantidad = Session::get('carrito', []);
        $totalQuantity = 0;
        foreach (session('carrito', []) as $producto) {

            $totalQuantity += $producto['cantidad'];
        }
        return response()->json(['totalQuantity' => $totalQuantity, 'carrito' => $cantidad]);
    }

    public function add(Request $request)
    {
        $id = $request->id;
        $nombre = $request->nombre;
        $precio = $request->precio;
        $cantidad = $request->cantidad;
        $imagen = $request->imagen;

        // Obtener el carrito actual desde la sesión
        $cartCollection = Session::get('carrito', []);

        // Verificar si el producto ya está en el carrito
        if (isset($cartCollection[$id])) {
            // Si el producto ya existe, actualiza la cantidad
            $cartCollection[$id]['cantidad'] += $cantidad;
        } else {
            // Si el producto no existe, agrégalo al carrito
            $cartCollection[$id] = [
                'id' => $id,
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => $cantidad,
                'imagen' => $imagen,
            ];
        }

        // Guardar el carrito actualizado en la sesión
        Session::put('carrito', $cartCollection);

        $totalQuantity = count($cartCollection);
        $carritoView = view('software.carrito.elicar')->render();

        return response()->json([
            'totalQuantity' => $totalQuantity,
            'carrito' => $cartCollection,
            'carritoView' => $carritoView,
            'mensaje' => 'Producto agregado al carrito correctamente'
        ]);
    }

    public function verC(Request $request)
    {
        $ver = Producto::find($request->id);
        $totalQuantity = Session::has('carrito') ? count(Session::get('carrito')) : 0;

        $categoriaProducto = $ver->categoria_producto;

        // Obtener productos relacionados usando la categoría del producto
        $relacionados = Producto::where('categoria_producto', $categoriaProducto)
            ->where('id', '!=', $ver->id) // Excluir el producto actual
            ->get();

        return view('software.carrito.detalles', compact('ver', 'relacionados', 'totalQuantity'));
    }
    public function clear()
    {
        Session::forget('carrito');

        return redirect()->route('shop')->with('success_msg', 'Carrito vaciado correctamente.');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $cantidad = $request->cantidad;

        // Obtener el carrito actual desde la sesión
        $cartCollection = Session::get('carrito', []);

        // Verificar si el producto existe en el carrito
        if (isset($cartCollection[$id])) {
            // Actualizar la cantidad del producto específico
            $cartCollection[$id]['cantidad'] = $cantidad;

            // Guardar el carrito actualizado en la sesión
            Session::put('carrito', $cartCollection);

            $totalQuantity = count($cartCollection);
            /*         $carritoView = view('software.carrito.elicar')->render();
 */
            /*  return response()->json([
            'totalQuantity' => $totalQuantity,
            'carrito' => $cartCollection,
            'carritoView' => $carritoView,
            'mensaje' => 'Cantidad actualizada correctamente'
        ]); */
            return redirect()->route('cart.index')->with('success_msg', 'Cantidad actualizada correctamente!');

            /* return back()->with(['mensaje' => 'Cantidad actualizada correctamente']); */
        }

        return response()->json([
            'error' => 'El producto no existe en el carrito'
        ], 400);
    }

    public function pago()
    {

        return view('pago');
    }
}
