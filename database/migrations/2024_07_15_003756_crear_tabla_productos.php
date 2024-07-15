<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->uuid("id_producto")->primary();
            $table->string("nombre_producto",70);
            $table->text("descripcion")->nullable();
            $table->smallInteger("stock");
            $table->decimal("precio",9,2);
            $table->string("imagen",200)->nullable();

            $table->softDeletes("eliminado_producto");

            $table->foreignUuid("categoria_id")->nullable()
            ->constrained("categorias","id_categoria")
            ->onDelete("set null");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
