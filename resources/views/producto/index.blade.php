<x-app>

    @section("titulo_app","Productos")
    @section('content')
       <div class="card">
         <div class="card-header border border-primary bg bg-primary">
            <h4 class="text-white">Crear producto</h4>
         </div>

         <div class="card-body">
             @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                     </ul>
                 </div>
             @endif

             @if ($mensaje = Session::get("success"))
                 <div class="alert alert-success">{{$mensaje}}</div>
             @endif
            <form action="{{route("producto.store")}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nombre_producto"><b>Nombre producto *</b></label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="descripcion"><b>Descripción</b></label>
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Describir..." rows="4"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="stock"><b>Stock *</b></label>
                            <input type="text" class="form-control" name="stock" id="stock">
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="precio"><b>Precio *</b></label>
                            <input type="text" class="form-control" name="precio" id="precio">
                        </div>
                    </div>
                </div>

                <div class="row my-2 justify-content-center">
                    <img src="" alt="" style="width: 80px;height: 80px;border-radius: 50%">
                </div>
                <div class="row my-2 justify-content-center">
                     <input type="file" name="imagen" id="imagen" style="display: none">
                     <button class="btn btn-info" id="open_explorer">Seleccionar imágen <i class="fas fa-upload"></i></button>
                </div>
                <br>
                <button class="btn btn-success">Guardar <i class="fas fa-save"></i></button>
            </form>
         </div>

         <div class="card-footer">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabla_productos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Acciones</th>
                            <th>Imágen</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Stock</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $indice => $producto)
                            <tr>
                                <td>{{$indice+1}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-auto">
                                            <a href="" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        </div>

                                        <div class="col-auto">
                                            <form action="" method="post">
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{ asset('imagenes-productos/'.$producto->imagen) }}" alt="" style="width: 80px;height: 80px;border-radius: 50%">
                                </td>
                                <td>{{$producto->nombre_producto}}</td>
                                <td>
                                    @if ($producto->descripcion != null)
                                    {{$producto->descripcion}}
                                     @else 
                                      <span class="text-danger">Sin descripción...</span>
                                    @endif
                                </td>
                                <td>{{$producto->stock}}</td>
                                <td>{{$producto->precio}}</td>
                            </tr>
                        @empty
                           <td colspan="7">
                            <span class="text-danger">No hay productos para mostrar....</span> 
                           </td> 
                        @endforelse
                    </tbody>
                </table>
            </div>
         </div>
       </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function(){

                $('#tabla_productos').DataTable({});

                $('#open_explorer').click(function(evento){
                    evento.preventDefault();
                    
                    $('#imagen').click();
                });
            });
        </script>
    @endsection
</x-app>