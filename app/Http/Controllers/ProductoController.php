<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //Método index
    public function index(Request $request)
    {
        if(!isset($request->producto)){
            /**MOSTRAMOS LOS PRODUCTOS */
        $productos = Producto::leftjoin("categorias as cat","productos.categoria_id","=","cat.id_categoria")
        ->get();
        }else{
            /**MOSTRAMOS LOS PRODUCTOS */
        $productos = Producto::leftjoin("categorias as cat","productos.categoria_id","=","cat.id_categoria")
        ->where("productos.nombre_producto",$request->producto)
        ->orwhere("cat.nombre_categoria",$request->producto)
        ->get();
        }
        /**
         * Mostramos las categorías
         */
        $categorias = Categoria::all();
        return view("producto.index",["productos"=>$productos,"categorias"=>$categorias]);
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

    /**
     * Vamos a editar los productos
     */
    public function editar(Producto $producto)
    {
        /**MOSTRAMOS LOS PRODUCTOS */
        $productos = Producto::leftjoin("categorias as cat","productos.categoria_id","=","cat.id_categoria")
        ->get();
        /**
         * Mostramos las categorías
         */
        $categorias = Categoria::all();

        /**
         * Enviamos el producto que deseamos modificar
         */

        return view("producto.index",compact("productos","categorias","producto"));
    }

    /**
     * Método para modificar los productos
     */

    public function modificar(Producto $producto,ProductoFormRequest $request){
      
        $producto->update($request->all());

      
        /// verificamos si estamos seleccionando un archivo

        if($request->hasFile("imagen")){

            if($producto->imagen != null){

                $pathStorage = storage_path("/app/public/productos/".$producto->imagen);
                unlink($pathStorage);
            }
            /// guardamos la imagen(subimos la imagen)

            $NameImagen = $request->file("imagen")->store("productos");

            
            /// productos/Nameimgen.jpg

            $NameImagen = explode("/",$NameImagen)[1];

            $producto->imagen = $NameImagen;

            $producto->save();
        }

        return redirect()->route("producto.index")
               ->with("success","Producto modificado correctamente!");
    }

    /**Método para forzar eliminado */
    public function eliminar(Producto $producto){
       
        $producto->delete();

        return response()->json(["response" =>"eliminado"]);
    }

    /// mostramos los productos eliminados temporalmente
    public function showProductosPepelera(){

        $productos = Producto::onlyTrashed()
        ->leftjoin("categorias as cat","productos.categoria_id","=","cat.id_categoria")
        ->get();

        return response()->json(["productos"=>$productos]);
    }

    /**
     * Restaurar el productos eliminado temporalmente
     */
    public function activar($id){

        $producto = Producto::onlyTrashed()->find($id);

        $producto->restore();

        return response()->json(["response"=>"activado"]);
    }
} 
