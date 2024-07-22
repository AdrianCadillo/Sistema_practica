<x-app>

    @section("titulo_app","Productos")
    @section('content')
       <div class="card">
         <div class="card-header border border-primary bg bg-primary">
            <h4 class="text-white">{{isset($producto) ? 'Editar producto':'Crear producto'}}</h4>
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
            <form action="{{!isset($producto)?route("producto.store"):route("producto.modificar",$producto)}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($producto)
                    @method("PUT")
                @endisset
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="categoria_id"><b>Categoría</b></label>
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                @forelse ($categorias as $category)
                                    <option value="{{$category->id_categoria}}" @isset($producto) @selected($producto->categoria_id === $category->id_categoria) @endisset>{{$category->nombre_categoria}}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre_producto"><b>Nombre producto *</b></label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto"
                            value="{{isset($producto) ? $producto->nombre_producto:''}}">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="descripcion"><b>Descripción</b></label>
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Describir..." rows="4">{{isset($producto) ? $producto->descripcion:''}}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="stock"><b>Stock *</b></label>
                            <input type="text" class="form-control" name="stock" id="stock"  
                            value="{{isset($producto) ? $producto->stock:''}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="form-group">
                            <label for="precio"><b>Precio *</b></label>
                            <input type="text" class="form-control" name="precio" id="precio" 
                            value="{{isset($producto) ? $producto->precio:''}}">
                        </div>
                    </div>
                </div>

                <div class="row my-2 justify-content-center">
                     @isset($producto)
                        @php
                            $FotoEditar = $producto->imagen != null ? "/imagenes-productos/".$producto->imagen:"/dist/img/avatar4.png";
                        @endphp
                     @endisset
                    <img src="{{isset($producto)?$FotoEditar:'/dist/img/avatar4.png'}}" alt="" style="width: 80px;height: 80px;border-radius: 50%">
                </div>
                <div class="row my-2 justify-content-center">
                     <input type="file" name="imagen" id="imagen" style="display: none">
                     <button class="btn btn-info" id="open_explorer">Seleccionar imágen <i class="fas fa-upload"></i></button>
                </div>
                <br>
                <div class="row">
                    <div class="col-auto">
                        <button class="btn btn-success">Guardar <i class="fas fa-save"></i></button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" id="show_papelera">Papelera <i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            </form>
         </div>

         <div class="card-footer">
            <form action="{{route("producto.index")}}" method="get">
                <div class="row mb-2">
                    <div class="col-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" name="producto" placeholder="Buscar...."
                            value="{{request()->producto}}">
                            <button class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabla_productos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Acciones</th>
                            <th>Categoría</th>
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
                                            <a href="{{route("producto.editar",$producto)}}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        </div>

                                        <div class="col-auto">
                                            <form action="" method="post">

                                                <button class="btn btn-danger btn-sm" onclick="event.preventDefault();ConfirmarEliminado('{{$producto->id_producto}}','{{$producto->nombre_producto}}')"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($producto->categoria_id != null)
                                     {{$producto->nombre_categoria}}
                                     @else
                                      <span class="text-danger">Sin categoría asignado..</span>
                                    @endif
                                </td>
                                <td>
                                     @php
                                      $Foto = $producto->imagen != null ? "/imagenes-productos/".$producto->imagen:"/dist/img/avatar4.png";
                                     @endphp
                                    <img src="{{ asset($Foto) }}" alt="" style="width: 80px;height: 80px;border-radius: 50%">
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

       {{--MODAL PARA MOSTRAR LOS PRODUCTOS QUE ESTAN EN LA PAPELERA----}}
       <div class="modal" tabindex="-1" id="modal_show_papelera">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Productos en la papelera</h5>
              
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                   <table class="table table-bordered nowrap" style="width: 100%" id="prod_papelera">
                     <thead>
                      <tr>
                        <th>Acciones</th>
                        <th>Categoría</th>
                        <th>Producto</th>
                        <th>Imagén</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                      </tr>
                     </thead>
                   </table>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_cat">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endsection

    @section('js')
        <script>
            var TablaProductosPapelera;
            $(document).ready(function(){

                mostrarProductosPepelera();

                activarProducto(TablaProductosPapelera,'#prod_papelera tbody');

                $('#tabla_productos').DataTable({});

                $('#open_explorer').click(function(evento){
                    evento.preventDefault();
                    
                    $('#imagen').click();
                });

                $('#show_papelera').click(function(ev){
                    ev.preventDefault();
                    $('#modal_show_papelera').modal("show")
                });
            });

            function ConfirmarEliminado(id,producto_delete){

                let formDelete = new FormData();
                    formDelete.append("_token","{{csrf_token()}}");


                Swal.fire({
                title: "Estas seguro de eliminar al producto "+producto_delete+"?",
                text: "Al presionar que si, el producto se eliminará por completo!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                if (result.isConfirmed) {
                  axios({
                    url:"producto/"+id+"/delete",
                    method:"put",
                    data:formDelete
                  }).then(function(respuesta){
                      Swal.fire({
                        title:"Mensaje del sistema!",
                        text:"Producto a la papelera!",
                        icon:"success"
                      }).then(function(){
                         location.href = '/productos';
                      });
                  });
                }
                });
            }

            /// método para mostrar los productos que están en la papelera
            function mostrarProductosPepelera()
            {
                TablaProductosPapelera = $('#prod_papelera').DataTable({
                    ajax:{
                        url:"/productos-en-la-papelera",
                        method:"GET",
                        dataSrc :"productos",
                    },
                    columns:[
                        {"data":null,render:function(){
                        return `
                            <div class='row'>
                                <div class='col-auto'>
                                    <button class='btn btn-success btn-sm' id='activar'><i class='fas fa-check'></i></button>
                                </div>
                                <div class='col-auto'>
                                    <button class='btn btn-danger btn-sm' id='borrar'><b>X</b></button>
                                </div>
                            </div>
                            `;
                        }},
                        {"data":"nombre_categoria"},
                        {"data":"nombre_producto"},
                        {"data":"imagen",render:function(img){
                            let rutaImage='';

                            if(img != null){
                                rutaImage = "/imagenes-productos/"+img;
                            }else{
                                rutaImage = "/dist/img/avatar.png";  
                            }

                            return `<img src=`+rutaImage+` style="width: 40px;height: 40px;border-radius: 50%">`;
                        }},
                        {"data":"descripcion",render:function(desc){
                            return desc != null ? desc:'<span class="text-danger">sin descriçión...</span>'
                        }},
                        {"data":"precio"},
                        {"data":"stock",render:function(stock){
                            if((stock)<=5){
                                return '<span class="badge bg-danger">'+stock+'</span>';
                            }

                            return stock;
                        }}
                    ]
                })
            }

            /// metodo para activar el producto
            function activarProducto(Tabla,Tbody){
                $(Tbody).on('click','#activar',function(){
                    /// obtener la fila seleccionada
                    let FilaSeleccionada = $(this).parents("tr");

                    if(FilaSeleccionada.hasClass("child")){
                        FilaSeleccionada = FilaSeleccionada.prev();
                    }

                    let Datos = Tabla.row(FilaSeleccionada).data();

                    ProcesoActiveProducto(Datos.id_producto);
                });
            }

            function ProcesoActiveProducto(id){
                $.ajax({
                    url:"/producto/"+id+"/active",
                    method:"PUT",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    dataType:"json",
                    success:function(response){
                        if(response.response === "activado"){
                            Swal.fire({
                                title:"Mensaje del sistema!",
                                text:"Producto activado",
                                icon:"success"
                            }).then(function(){
                                location.href= "/productos";
                            });
                        }
                    }
                });
            }
        </script>
    @endsection
</x-app>