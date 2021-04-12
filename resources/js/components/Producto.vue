<template>
        <!-- Main content -->
      <!-- Default box -->
      <main class="main">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Productos</h3>
          <button @click="abrirModal('producto','registrar')" type="button" class="btn btn-secondary">
              <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="display" style="width:100%" id="tabla">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 30%">
                          Nombre
                      </th>
                      <th style="width: 30%">
                          Precio
                      </th>
                      <th style="width: 20%">
                          Estado
                      </th>
                      <th style="width: 19%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="producto in arrayProducto" :key="producto.id">
                      <td >
                          <a v-text="producto.id">

                          </a>
                      </td>
                      <td>
                          <a v-text="producto.nombre">
                          </a>
                          <br/>
                          <small v-text="producto.created_at">
                            Creado
                          </small>
                      </td>
                      <td v-text="producto.precio">
                         
                      </td>
                      <td class="project-state">
                          <div v-if="producto.condicion==1">
                              <span class="badge badge-success">Activar</span>
                          </div>
                          <div v-if="producto.condicion==0">
                              <span class="badge badge-danger">Desactivar</span>
                          </div>
                      </td>
                      <td class="project-actions text-right">
                          <!--<a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              Ver
                          </a>
                          -->
                          <a class="btn btn-info btn-sm" href="#" @click="abrirModal('producto','actualizar',producto)" >
                              <i class="fas fa-pencil-alt">
                              </i>
                              Editar
                          </a>
                          <template v-if="producto.condicion">
                            <a class="btn btn-danger btn-sm" href="#" @click="desactivarProducto(producto.id)">
                                <i class="fas fa-trash">
                                </i>
                                Desactivar
                            </a>
                            </template>
                            <template v-else>
                            <a class="btn btn-info btn-sm" href="#" @click="activarProducto(producto.id)" >
                                <i class="fas fa-check">
                                </i>
                                Activar
                            </a>
                            </template>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->


      </div>
      <!-- /.card -->


        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" :class="{'mostrar':modal}" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" v-text="tituloModal" ></h4>
                        <button @click="cerrarModal()" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input v-model="nombre" type="text" class="form-control" placeholder="Nombre de producto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Precio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="precio" class="form-control" placeholder="Precio Producto">
                                </div>
                            </div>
                            <div v-show="errorProducto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">


                                    </div>
                                </div>
                            
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                        <button  @click="registrarProducto()" v-if="tipoAccion==1" type="button" class="btn btn-primary" >Guardar</button>
                        <button @click="actualizarProducto()" v-if="tipoAccion==2" type="button" class="btn btn-primary" >Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

        </div>
        <!--Fin del modal-->
      </main>

      
</template>

<script>

    export default {
        data(){
            return{
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                categoria_id :0,
                nombre : '',
                precio : '',
                arrayProducto: [],
                errorProducto : 0,//Determinar si hay errorres
                errorMostrarMsjProducto :[]
            }
        },
        methods : {//Declarar todas las funciones
            listarProducto(){
                let me = this;
                
              axios.get('/producto')
                .then(response=> {
                    me.arrayProducto=response.data;
                    this.tabla();
                    console.log(me.arrayProducto);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            tabla (){
                this.$nextTick(()=>{
                 $('#tabla').DataTable();
                })
            },
            abrirModal(modelo,accion,data = []){
                switch(modelo){
                    case "producto":{
                     switch(accion){
                           case "registrar":{
                               this.modal=1;
                               this.tituloModal = 'Registrar Producto';
                               this.nombre = '';
                               this.precio = '';
                               this.tipoAccion =  1;
                               this.errorProducto =0;
                               break;
                           }
                            case "actualizar":{
                               this.modal=1;
                               this.tituloModal = 'Actualizar Producto';
                               this.producto_id = data['id'];
                               this.nombre = data['nombre'];
                               this.precio = data['precio'];
                               this.tipoAccion =  2;
                               this.errorProducto =0;
                               break;
                           }
                       }
                       break;
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal ='';
                this.nombre ='';
                this.precio ='';

            },
            registrarProducto(){
                if(this.validarProducto()){
                    return;
                }
                let me =this;
                axios.post('/producto/registrar', {
                'nombre' : this.nombre,
                'precio' : this.precio
                })
                .then(function (response) {
                    
                    me.cerrarModal();
                    me.listarProducto();
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });


            },
            actualizarProducto(){
                if(this.validarProducto()){
                    return;
                }
                let me =this;
                axios.put('/producto/actualizar', {
                'id' : this.producto_id,
                'nombre' : this.nombre,
                'precio' : this.precio
                })
                .then(function (response) {
                    
                    me.cerrarModal();
                    me.listarProducto();
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });


            },
            validarProducto(){
                this.errorProducto = 0;
                this.errorMostrarMsjProducto = [];

                if(!this.nombre) this.errorMostrarMsjProducto.push("El nombre no puede estar vacio");

                if(this.errorMostrarMsjProducto.length) this.errorProducto =1;
                return this.errorProducto;

            },
            desactivarProducto(id){
                                    Swal.fire({
                    title: 'Esta seguro que desea desactivar el producto?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Confirmar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                          let me =this;
                         axios.put('/producto/desactivar', {
                        'id' : id
                        })
                        .then(function (response) {
                            me.listarProducto();
                             Swal.fire(
                            'Desactivada!',
                            'El registro se ha desactivado',
                            'success'
                            );
                            
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                        
                    }
                    })
                  
               

            },
             activarProducto(id){
                     Swal.fire({
                    title: 'Esta seguro que desea activar el producto?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Confirmar'
                    }).then((result) => {
                    if (result.isConfirmed) {
                          let me =this;
                         axios.put('/producto/activar', {
                        'id' : id
                        })
                        .then(function (response) {
                            me.listarProducto();
                             Swal.fire(
                            'Activada!',
                            'El registro se ha activado',
                            'success'
                            );
                            
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });
                        
                    }
                    })
                  
               

            }
            

        },
        mounted() {
            this.listarProducto();
        },
    }
</script>
<style >
.modal_content{
    width:100%  !important;
    margin-top: 55px;
    position: absolute  !important;
}
.mostrar{
    display : list-item  !important;
    opacity: 1 !important ;
    position: absolute  !important;
    background-color: blue  !important;
}
.div-error{
  display: flex;/*distribuir div a la pantalla principal*/ 
  justify-content: center;/*distribuir div a la pantalla principal*/ 
}
.text-error{
    color:red  !important;
    font-weight: bold;


}
</style>