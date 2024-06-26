<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

/**
 * Class ProveedorController
 * @package App\Http\Controllers
 */
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedors = Proveedor::paginate();

        return view('software.proveedor.index', compact('proveedors'))
            ->with('i', (request()->input('page', 1) - 1) * $proveedors->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedor = new Proveedor();
        return view('software.proveedor.crear', compact('proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Proveedor::$rules);

        $proveedor = Proveedor::create($request->all());

        return redirect()->route('proveedor')
            ->with('success', 'Proveedor creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        return view('software.proveedor.mostrar', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);

        return view('software.proveedor.editar', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Proveedor $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        request()->validate(Proveedor::$rules);

        $proveedor->update($request->all());

        return redirect()->route('proveedor')
            ->with('success', 'Proveedor actualizado correctamente.');
            // return back()->with('success', 'Proveedor actualizado correctamente.');
    }
    /* public function ActualizarProve(Request $request, Proveedor $proveedor)
    {
        request()->validate(Proveedor::$rules);

        $proveedor->update($request->all());

        return redirect()->route('proveedor')
            ->with('success', 'Proveedor actualizado correctamente.');
            // return back()->with('success', 'Proveedor actualizado correctamente.');
    }
 */
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::find($id)->delete();

        return redirect()->route('proveedor')
            ->with('success', 'Proveedor eliminado correctamente');
    }

    /*public function proveedor()
    {
        $proveedors = Proveedor::paginate();

        return view('proveedor.index', compact('proveedors'))
            ->with('i', (request()->input('page', 1) - 1) * $proveedors->perPage());
    }*/
    public function aggpro(Request $request){
        $guardar = new Proveedor();
        $guardar->nombre = $request->nombre;
        $guardar->direccion = $request->direccion;
        $guardar->numero = $request->numero;
        $guardar->correo = $request->correo;
        $guardar->save();
        return response()->json(['mensaje' => 'Proveedor agregado correctamente']);

        // return view('software.proveedor.proveformu');
    }
    public function obtenerDireccionProveedor(Request $request)
    {
        $proveedorId = $request->input('proveedor_id');
        $proveedor = Proveedor::find($proveedorId);

        return response()->json([
            'direccion' => $proveedor ? $proveedor->direccion : null,
            'nombre' => $proveedor->nombre,
            // 'direccion' => $proveedor->direccion,
            'numero' => $proveedor->numero,
            'correo' => $proveedor->correo,
        ]);
    }
    public function proveag($id){
        $proveedor = Proveedor::find($id);

        return response()->json([
            'nombre' => $proveedor->nombre,
            'direccion' => $proveedor->direccion,
            'numero' => $proveedor->celular,
            'correo' => $proveedor->correo,
        ]);
    }
}
