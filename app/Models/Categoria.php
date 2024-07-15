<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    protected $fillable = ["nombre_categoria"];
    protected $primaryKey = "id_categoria";

    const DELETED_AT = "eliminado";


    use HasFactory,HasUuids,SoftDeletes;
}
