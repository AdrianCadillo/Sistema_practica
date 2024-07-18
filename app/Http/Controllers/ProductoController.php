<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //Método index
    public function index()
    {
        /**MOSTRAMOS LOS PRODUCTOS */
        $productos = Producto::all();
        return view("producto.index",["productos"=>$productos]);
    }

    /**
     * Método para registrar
     */

    public function store(ProductoFormRequest $request)
    {

        $producto = Producto::create($request->all());

        /// verificamos si estamos seleccionando un archivo

        if($request->hasFile("imagen")){
            /// guardamos la imagen(subimos la imagen)

            $NameImagen = $request->file("imagen")->store("productos");
            /// productos/Nameimgen.jpg

            $NameImagen = explode("/",$NameImagen)[1];

            $producto->imagen = $NameImagen;

            $producto->save();
        }

        return redirect()->route("producto.index")
               ->with("success","Prodcuto registrado");
    }
}
