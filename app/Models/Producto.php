<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    protected $fillable = ["nombre_producto","descripcion","stock","precio","imagen"];

    const DELETED_AT = "eliminado_producto";

    protected $primaryKey = "id_producto";
}
