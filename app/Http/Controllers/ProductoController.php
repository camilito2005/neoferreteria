<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Producto;
use App\Models\daf;
use App\Models\Proveedor;
use App\Models\Category;
use App\Models\Usuarios_empleado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use Illuminate\Support\Str;
//use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::paginate();
        $dine = Producto::all();

        return view('software.producto.verproductos', compact('productos', 'dine'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        return view('software.producto.agregar', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $guardar = new Producto();
        $guardar->nombre = $request->nombre;
        $guardar->descripcion = $request->descripcion;
        $guardar->precio = $request->precio;
        $guardar->stock = $request->stock;
        /*if($request->hasFile("imagen")){
            $guaimage = $request->file("imagen")->store('');
            $ruta = Storage::url("$guaimage");

        }*/
        $imagenpro = $request->file('imagen')->store('public/img');
        $guardar->imagen = str_replace('public/', '', $imagenpro);

        $guardar->save();
        return redirect()->route('verproductos')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        return view('software.producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);

        return view('software.producto.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        /* request()->validate(Producto::$rules);

        // $producto->imagen = $request->imagen;
        // $imagenpro = $request->file('imagen')->store('public/img');
        // $producto->imagen =str_replace('public/', '', $imagenpro);
        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.'); */
            var_dump($request->all());
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $b = $producto->precio;
        $di = auth()->user()->identificador;

        DB::table('dafs')
            ->where('iden_dd', $di)
            ->update(['daf' => DB::raw("daf - $b")]);
        $producto->delete();
        return redirect()->route('verproductos')
            ->with('success', 'Producto eliminado correctamente.');
    }


    public function guardar(Request $request)
    {
        /*         var_dump($request);
 */       /*  $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]); */

        $guardar = new Producto();
        $guardar->nombre = $request->nombre;
        $guardar->marca = $request->marca;
        $guardar->identificador = auth()->user()->identificador;
        $guardar->referencia = $request->referencia;
        $guardar->descripcion = $request->descripcion;
        $guardar->categoria_producto = $request->categoria;
        $guardar->precio = $request->precio;
        $guardar->stock = $request->stock;
        $guardar->dafTP = $request->stock * $request->precio;

        /*  $imagen = $request->file('imagen');
        $extension = $imagen->getClientOriginalExtension();
        $nombreImagen = time() . '_' . uniqid() . '.' . $extension;

        $imagen->move(public_path('imgpro'), $nombreImagen); */
        $nombreImagen1 = 'prueba';
        $guardar->imagen = $nombreImagen1;
        $guardar->save();
        $di = $request->daf;
        $dn = $request->stock * $request->precio;
        DB::table('dafs')
            ->where('iden_dd', $di)
            ->update(['dafTotal' => DB::raw("dafTotal + $dn")]);
        /* DB::table('dafs')
            ->where('iden_dd', $di)
            ->update(['daf' => DB::raw("daf + $dn")]); */


        return response()->json(['mensaje' => 'Producto agregado correctamente']);
    }
    public function guardarServidor(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $guardar = new Producto();
        $guardar->nombre = $request->nombre;
        $guardar->marca = $request->marca;
        $guardar->descripcion = $request->descripcion;
        $guardar->categoria_producto = $request->categoria;
        $guardar->precio = $request->precio;
        $guardar->stock = $request->stock;

        $imagen = $request->file('imagen');
        $extension = $imagen->getClientOriginalExtension();
        $nombreImagen = time() . '_' . uniqid() . '.' . $extension;

        $imagen->move('imgpro', $nombreImagen);

        $guardar->imagen = $nombreImagen;
        $guardar->save();

        $cate = new Category();
        $cate->categoria_producto = $request->categoria;
        $cate->save();

        return response()->json(['mensaje' => 'Producto agregado correctamente']);
    }
    public function guardar1(Request $request)
    {
        // var_dump($request);

        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $guardar = new Producto();
        $guardar->nombre = $request->nombre;
        $guardar->marca = $request->marca;
        $guardar->descripcion = $request->descripcion;
        $guardar->categoria_producto = $request->categoria;
        $guardar->precio = $request->precio;
        $guardar->stock = $request->stock;
        /*if($request->hasFile("imagen")){
            $guaimage = $request->file("imagen")->store('');
            $ruta = Storage::url("$guaimage");

        }*/
        $imagenpro = $request->file('imagen')->store('public/img');
        $guardar->imagen = str_replace('public/', '', $imagenpro);

        $guardar->save();
        $cate = new Category();
        $cate->categoria_producto = $request->marca;
        $cate->save();
        return response()->json(['mensaje' => 'Producto agregado correctamente']);
        // return redirect()->route('agregar')->with('success', 'Producto creado correctamente.');
    }

    public function guardarC(Request $request)
    {
        // var_dump($request);

        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $guardar = new Producto();
        $guardar->nombre = $request->nombre;
        $guardar->marca = $request->marca;
        $guardar->descripcion = $request->descripcion;
        $guardar->categoria_producto = $request->categoria;
        $guardar->precio = $request->precio;
        $guardar->stock = $request->stock;
        /*if($request->hasFile("imagen")){
            $guaimage = $request->file("imagen")->store('');
            $ruta = Storage::url("$guaimage");

        }*/
        $imagen = $request->file('imagen');
        $extension = $imagen->getClientOriginalExtension();
        $nombreImagen = time() . '_' . uniqid() . '.' . $extension;

        // Mueve la imagen a la carpeta public/imgpro
        $imagen->move(public_path('imgpro'), $nombreImagen);

        $guardar->imagen = $nombreImagen;
        $guardar->save();
        $cate = new Category();
        $cate->categoria_producto = $request->marca;
        $cate->save();
        // return response()->json(['mensaje' => 'Producto agregado correctamente']);
        return redirect()->route('agregar')->with('success', 'Producto creado correctamente.');
    }

    public function verproductos()
    {
        $productos = Producto::paginate();
        $dine = Producto::all();

        return view('software.producto.verproductos', compact('productos', 'dine'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }
    public function agregarprovedor()
    {
        $proveedores = Proveedor::all();
        return view('software.proveedor.proveformu', compact('proveedores'));
    }
    public function paginaprincipal()
    {
        return view('software.inicio.paginaprincipal'/*, compact('productos')*/);
    }
    public function catalogo()
    {
        $productos = Producto::paginate();

        return view('software.inicio.catalogo', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }
    public function catalogopro()
    {
        $productos = Producto::paginate();

        return view('catalogos.catalogo', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }
    public function graficasventas()
    {
        $productos = Producto::paginate();

        return view('software.graficas.graficas', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }
    public function pdf1()
    {
        $productos = Producto::all();
        $cartCollection = Session::get('carrito', []);
        $pdf = PDF::loadView('software/pdf/pdflisto', compact('productos', 'cartCollection'));
        return $pdf->download('facturaprueba.pdf');
        // return view('software/pdf/pdflisto', compact('productos', 'cartCollection'));
    }

    public function pdf()
    {
        set_time_limit(300);
        $cartCollection = Session::get('carrito', []);

        if (empty($cartCollection)) {
            return redirect()->route('shop')->with('error', 'El carrito está vacío. No se puede generar el PDF.');
        }

        $totalVentas = 0;
        foreach ($cartCollection as $item) {
            $totalVentas += $item['precio'] * $item['cantidad'];
        }

        $pdf = PDF::loadView('software.pdf.pdflisto');

        $nombreArchivo = 'facturaprueba.pdf';

        //return view('software/pdf/pdflisto');
        // Descargar el archivo
        return $pdf->download('facturaprueba.pdf');
    }



    public function graficasproduc()
    {
        $dagra = Producto::all();
        $top10 = Producto::orderBy('stock', 'desc')
            ->take(12)
            ->get();
        $topventa = Factura::orderBy('totalventa', 'desc')
            ->take(12)
            ->get();
        /* $dataCategories = [];
        $dataReggane = [];

        foreach ($dagra as $datos) {
            $dataCategories[] = $datos['nombre'];
            $dataReggane[] = $datos['stock'];
        } */
        $dataReggane = [];
        foreach ($top10 as $datos) {
            $dataReggane[] = $datos['stock'];
        }
        $datosh = [];
        foreach ($dagra as $datos) {
            $datosh[] = ['name' => $datos['nombre'], 'y' => $datos['stock']];
        }

        foreach ($top10 as $datos) {
            $dataTop10[] = $datos['stock'];
        }
        $topVenta = [];
        foreach ($topventa as $datos) {
            $topVenta[] = $datos['totalventa'];
        }
        return view('software.graficas.graficas', [
            /* "dataCategories" => json_encode($dataCategories), */
            "dataReggane" => json_encode($dataReggane),
            "data" => json_encode($datosh),
            "top10" => json_encode($dataTop10),
            "topVenta" => json_encode($topVenta)
        ]);
    }

    public function graficasproducto22()
    {
        $dagra = Producto::all();

        $datosh = [];
        foreach ($dagra as $datos) {
            $datosh[] = ['name' => $datos['nombre'], 'y' => $datos['stock']];
        }

        return view('software.graficas.graficaslineales', ["data1" => json_encode($datosh)]);
    }
    public function buscar(Request $request)
    {
        $buscar = $request->input('busqueda');
        $busqueda = Producto::where('nombre', 'LIKE', "%$buscar%")->get();
        if ($request->ajax()) {
            return view('ajax.buscar', compact('busqueda'));
        }
        return view('ajax.buscar', compact('busqueda'));
    }

    public function buscarP(Request $request)
    {
        $columns = ['nombre', 'marca', 'precio', 'stock'];
        $campo = $request->input('campo-buscar');

        $productosb = Producto::where(function ($query) use ($columns, $campo) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%$campo%");
            }
        })->get();

        return view('ajax.buscar-p', compact('productosb'));
        //return response()->json($productosb);
    }

    public function facturacion_vista()
    {
        $productos = Producto::all();
        $categorias = Category::all();
        $proveedores = Proveedor::all();
        $lon = 10;
        $token = Str::random($lon);
        return view('software.facturas.facturacion', compact('productos', 'token', 'categorias', 'proveedores'));
    }
    public function factura1(Request $request)
    {
        $producto = $request->input('productoVentaId');
        foreach ($producto as $productos)

            return response()->json(['mensaje' => 'Venta registrada con éxito', 'productos' => $productos]);
    }

    /* public function factura(Request $request)
    {

        $factura = new Factura();
        $factura->referencia = $request->referenciaCod;
        $factura->empleadoAtendio = $request->EA; // E de empleado, y A de Atendio
        $factura->fechaVenta = $request->fecha;
        $factura->totalventa = $request->total;
        $factura->idDetalles = $request->referenciaCod;
        $factura->save();


        $productos = json_decode($request->productos, true);

        foreach ($productos as $producto) {
            $detalle = new DetalleFactura();
            $detalle->factura_id = $factura->id;
            $detalle->producto_id = $producto['id'];
            $detalle->cantidad = $producto['cantidad'];
            $detalle->precio = $producto['precio'];
            $detalle->save();
        }

        return response()->json(['mensaje' => 'Venta registrada con éxito', 'productos' => $productos]);

    } */
    public function factura(Request $request)
    {
        config(['app.timezone' => 'America/Bogota']);
        $fhc = Carbon::now();

        $factura = new Factura();
        $factura->referencia = $request->referenciaCod;
        $factura->empleadoAtendio = $request->EA;
        $factura->fechaVenta = $fhc;
        $factura->totalventa = $request->total;
        $factura->idDetalles = $request->referenciaCod;
        $factura->save();
        $di = auth()->user()->identificador;
        DB::table('dafs')
            ->where('iden_dd', $di)
            ->update(['dafVenta' => DB::raw("dafVenta + $request->total")]);
        DB::table('dafs')
            ->where('iden_dd', $di)
            ->update(['daf' => DB::raw("daf + $request->total")]);
        if ($request->filled('productos')) {
            $productos = json_decode($request->input('productos'), true);

            if (is_array($productos)) {
                foreach ($productos as $producto) {
                    $detalle = new DetalleFactura();
                    $detalle->idReferencia = $factura->id;
                    $detalle->idProducto = $producto['id'];
                    $detalle->nombreProducto = $request->EA;
                    $detalle->cantidad = $producto['cantidad'];
                    $detalle->precioU = $producto['precio'];
                    $detalle->total = $producto['cantidad'] * $producto['precio'];
                    $detalle->save();
                    $nuevaC = $producto['cantidad'];
                    DB::table('productos')
                        ->where('id', $producto['id'])
                        ->update(['stock' => DB::raw("stock - $nuevaC")]);
                }


                return response()->json(['mensaje' => 'Venta registrada con éxito', 'productos' => $productos]);
            } else {
                return response()->json(['error' => 'La variable productos no es un array después de decodificar'], 400);
            }
        } else {
            return response()->json(['error' => 'La variable productos no está presente o está vacía'], 400);
        }
    }



    public function obtenerP(Request $request)
    {
        $productoId = $request->input('producto_id');
        $producto = Producto::find($productoId);

        return response()->json([
            // 'direccion' => $producto ? $producto->direccion : null,
            'nombre' => $producto->nombre,
            'stock' => $producto->stock,
            'precio' => $producto->precio,
        ]);
    }
}
