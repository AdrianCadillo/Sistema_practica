<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaController::class)->middleware("auth")->group(function(){
   Route::get("/categorias","index")->name("categoria.index");
   Route::post("/categoria/store","store")->name("categoria.store");
   Route::get("/categorias-existentes","showCategorias");
   Route::post("/categoria/{id}/delete","eliminarCategoria")->name("categoria.eliminado");
});