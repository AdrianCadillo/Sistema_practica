<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaController::class)->middleware("auth")->group(function(){
   Route::get("/categorias","index")->name("categoria.index");
   Route::post("/categoria/store","store")->name("categoria.store");
   Route::get("/categorias-existentes","showCategorias");
   Route::post("/categoria/{id}/delete","eliminarCategoria")->name("categoria.eliminado");
   Route::get("/categorias-en-la-papelera","showCategoriasPapelera");
   Route::put("/categoria/{id}/activar","Activar");
});

/// ruta para productos
Route::controller(ProductoController::class)->middleware("auth")->group(function(){
 Route::get("/productos","index")->name("producto.index");
 Route::post("/producto/store","store")->name("producto.store");
 Route::get("/producto/{producto}/editar","editar")->name("producto.editar");
 Route::put("/producto/{producto}/update","modificar")->name("producto.modificar");
 Route::put("/producto/{producto}/delete","eliminar")->name("producto.eliminar");
 Route::get("/productos-en-la-papelera","showProductosPepelera");
 Route::put("/producto/{id}/active","activar")->name("producto.activar");
});