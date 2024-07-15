<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    //Método index
    public function index()
    {
        /// mostrar las categorias
        $categorias = Categoria::all();

        return view("categoria.index",compact("categorias"));
    }

    /// Método store para guardar registros
    public function store(Request $request)
    {

        $validacion = Validator::make($request->all(),[
            "nombre_categoria" => ["required","unique:categorias"]
        ],
        [
            "nombre_categoria.required" => "Complete el campo nombre categoría",
            "nombre_categoria.unique" => "Ya existe la categoría que deseas registrar!"
        ]);
      
        if($request->ajax()){
            if($validacion->fails()){
                return response()->json(["errors"=>$validacion->errors()]);
            }

            $categoria = Categoria::create([
                "nombre_categoria" => $request->nombre_categoria
            ]);
    
            return response()->json(["response" => "guardado"]);
        }
    }


    /**
     * Método para mostrar las categorías
     */
    public function showCategorias()
    {
       /// mostrar las categorias
       $categorias = Categoria::all();
       
       return response()->json(["categorias" => $categorias]);
    }


    //// eliminamos los registros

    public function eliminarCategoria($id)
    {
       $categoria = Categoria::find($id);

       $categoria->delete();

       return response()->json(["response" => "eliminado"]);
    }
}
