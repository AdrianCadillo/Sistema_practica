<x-app>
    @section('titulo_app','Categorías')
    @section('content')
        <div class="card border border-primary">
             <div class="card-header bg bg-primary">
                <h4>Categorías existentes</h4>
             </div>
             <div class="card-body">
                <button class="btn btn-primary mb-2" id="add_cat">Agregar uno nuevo <i class="fas fa-plus"></i></button>
                <button class="btn btn-success mb-2" id="show_papelera">Papelera <i class="fas fa-trash-alt"></i></button>
                <table class="table table-bordered table-striped">
                 <thead>
                   <tr>
                    <th>#</th>
                    <th class="d-none">ID</th>
                    <th>Categoría</th>
                    <th>Acciones</th> 
                   </tr>    
                 </thead>  
                 
                 <tbody id="lista_categorias">
                    
                 </tbody>
                </table>  
             </div>
         
        </div>
        {{-- modal para agregar nuevas categorias----}}
        <div class="modal" tabindex="-1" id="modal_add_categoria">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Crear Categoría</h5>
                  
                </div>
                <div class="modal-body">
                   <form action="" method="post" id="form_categoria">
                     @csrf
                      <div class="form-group">
                        <label for="nombre_categoria">Nombre categoría * </label>
                        <input type="text" name="nombre_categoria" id="nombre_categoria"
                        class="form-control" placeholder="Nombre categoría...">
                        <span class="text-danger" id="response_nombre_categoria"></span>
                      </div>
                   </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_cat">Close</button>
                  <button type="button" class="btn btn-primary" id="save_categoria">Guardar</button>
                </div>
              </div>
            </div>
          </div>

          {{-- MODAL PARA MOSTRAR LAS CATEGORIAS EN LA PAPELERA----}}
          <div class="modal" tabindex="-1" id="modal_show_papelera">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Categorías en la papelera</h5>
                  
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                       <table class="table table-bordered nowrap" style="width: 100%" id="cat_papelera">
                         <thead>
                          <tr>
                            <th>CATEGORÍA</th>
                            <th>ACCIONES</th>
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
        <script type="module">
          var TablaCategoriasPapelera;
            $(document).ready(function(){
              
              /// mostrando las categorías
              showCategorias();showCategoriasPapelera();

              ActivarCategoria(TablaCategoriasPapelera,'#cat_papelera tbody')

              $('#add_cat').click(function(){
                 $('#modal_add_categoria').modal("show")
              });  
              $('#close_cat').click(function(){
                $('#modal_add_categoria').modal("hide")
              });

              /// guardar la categoria

              $('#save_categoria').click(function(){

                //  $.ajax({
                //     url:"/categoria/store",
                //     method:"POST",
                //     data:$('#form_categoria').serialize(),
                //     dataType:"json",
                //     success:function(response)
                //     {
                //         if(response.errors != undefined){
                //             if(response.errors.nombre_categoria != undefined){
                //                 $('#response_nombre_categoria').text(response.errors.nombre_categoria)
                //             }else{
                //                 $('#response_nombre_categoria').text("")
                //             }
                //         }else{
                //             Swal.fire({
                //             title: "Success?",
                //             text: "Categoría registrado",
                //             icon: "success"
                //             });                
                //         }
                        
                //     }
                //  });

                 let FormCategoria = new FormData(document.getElementById("form_categoria"));
                //  FormCategoria.append('nombre_categoria',$('#nombre_categoria').val());
                //  FormCategoria.append('_token',"{{csrf_token()}}");
               axios({
                method: 'post',
                url: '/categoria/store',
                data:FormCategoria
                }).then(function(respuesta){
                   console.log(respuesta.data)
                });
                });

              $('#show_papelera').click(function(){
                $('#modal_show_papelera').modal("show")
                showCategoriasPapelera();
              });


              $('#lista_categorias').on('click','#eliminado',function(){

                
                /// obtenemos la fila seleccionada
                let fila = $(this).closest("tr");

                let IdCategoria = fila.find('td').eq(1).text();

               Swal.fire({
                title: "Estas seguro?",
                text: "Al presionar que si, la categoría se irá a la papelera!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url:"categoria/"+IdCategoria+"/delete",
                    method:"POST",
                    data:{_token:"{{csrf_token()}}"},
                    dataType:"json",
                    success:function(response)
                    {
                         Swal.fire({
                            title:"Success!",
                            text:"Categoria eliminado",
                            icon:"success"
                         });

                         showCategorias();
                    } 
                });
                }
                });
                
              });
            });


            /**MOSTRAR LAS CATEGORIAS*/
            function showCategorias()
            {
                let tr = '',item = 1;
                $.ajax({
                    url:"/categorias-existentes",
                    method:"GET",
                    dataType:"json",
                    success:function(respuesta)
                    {
                       respuesta.categorias.forEach(categoria => {
                         tr+=`
                          <tr>
                           <td>`+item+`</td> 
                           <td class='d-none'>`+categoria.id_categoria+`</td>
                           <td>`+categoria.nombre_categoria+`</td> 
                           <td>
                            <div class='row'>
                             <div class='col-xl-2 col-lg-2 col-md-3 col-12'>
                                <button class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></button> 
                             </div> 
                             <div class='col-xl-2 col-lg-2 col-md-3 col-12'>
                                <button class='btn btn-danger btn-sm' id='eliminado'><i class='fas fa-trash-alt'></i></button> 
                             </div>   
                            </div> 
                           </td>  
                          </tr>
                         `;
                         item++;
                       }); 

                       $('#lista_categorias').html(tr);
                    }
                });
            }

          /// mostrar las categorias en papelera
          function showCategoriasPapelera(){
            TablaCategoriasPapelera = $('#cat_papelera').DataTable({
              retrieve:true,
              ajax:{
                url:"/categorias-en-la-papelera",
                method:"GET",
                dataSrc:"categorias",
              },
              columns:[
                {"data":"nombre_categoria"},
                {"data":null,render:function(){
                  return `
                    <div class='row'>
                     <div class='col-auto'>
                      <button class='btn btn-success btn-sm' id='activar'><i class='fas fa-check'></i></button> 
                     </div>
                      <div class='col-auto'>
                       <button class='btn btn-danger btn-sm'><b>X</b></button>   
                      </div>  
                    </div>
                  `;
                }}
              ]
            }).ajax.reload();
          }

          /// método para activar la categoria
          function ActivarCategoria(Tabla,Tbody){
            $(Tbody).on('click','#activar',function(){
              
               /// recuperar la fila seleccionada
               let fila = $(this).parents('tr');

               ///
               if(fila.hasClass('child')){
                 fila = fila.prev();
               }

               let Data = Tabla.row(fila).data();

               let IdCategoria = Data.id_categoria;

               $.ajax({
                url:"/categoria/"+IdCategoria+"/activar",
                method:"PUT",
                data:{
                  _token:"{{csrf_token()}}"
                },
                dataType:"json",
                success:function(respuesta){
                  if(respuesta.response === "activado"){
                    Swal.fire({
                      title:"Mensaje del sistema!",
                      text:"Categoría activado correctamente!",
                      icon:"success"
                    }).then(function(){
                      showCategoriasPapelera();
                      showCategorias();
                    });
                  }
                }
               })
               
            });
          }
        </script>
    @endsection
</x-app>