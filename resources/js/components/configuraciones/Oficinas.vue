<template>
    <main class="main">
        <div class="container-fluid">
            <!-- TO DO List -->
            <div class="card">
            <div class="card-header bg-success">
                <li class="d-flex justify-content-between h3">
                    Lista de oficinas
                    <span class="badge badge-success badge-pill">{{ arrayTickets.length }}</span>
                </li>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Serial</th>
                            <th>Nivel</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Class</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ur in arrayTickets" :key="ur.id">
                            <td v-text="ur.name"></td>
                            <td v-text="ur.serial"></td>
                            <td v-text="ur.level"></td>
                            <td v-text="ur.description"></td>
                            <td>
                                <img :src="ur.path" class="img-circle" width="50" />
                            </td>
                            <td v-text="ur.class_default"></td>
                            <td>
                                <button class="btn btn-sm btn-outline-success" @click="openModalTicket(ur)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger" @dblclick="destroyOficina(ur)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <infinite-loading @infinite="infiniteHandler">
                        <div slot="no-more">No hay mas resultados</div>
                        <div slot="no-results">No hay resultados</div>
                    </infinite-loading>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <button type="button" class="btn btn-success float-right"  @click="openModalTicket"><i
                    class="fas fa-plus"></i> Agregar Oficina</button>
                <input type="hidden" id="modalcloseoficina1" data-toggle="modal"  data-target="#staticOficio"/>
            </div>
        </div>
             <!-- /.card -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <!-- Modal -->
        <div class="modal fade" id="staticOficio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="needs-validation" novalidate @submit.prevent="submit">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="staticBackdropLabel" v-text="title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Serial</label>
                                        <input type="text" v-model="ticket.serial" class="form-control form-control-lg" placeholder="serial" required>
                                        <div class="valid-feedback">
                                            Ingrese serie
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre</label>
                                        <input type="text" v-model="ticket.name" class="form-control form-control-lg" placeholder="name" required>
                                        <div class="valid-feedback">
                                            Ingrese un nombre
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Descripción</label>
                                        <input type="text" v-model="ticket.description" class="form-control form-control-lg" placeholder="description">
                                        <div class="valid-feedback">
                                            Ingrese una descripción
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">level</label>
                                        <input type="number" v-model.number="ticket.level" class="form-control form-control-lg" placeholder="level" required>
                                        <div class="valid-feedback">
                                            Ingrese un leve
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">class</label>
                                        <input type="text" v-model.number="ticket.class_default" class="form-control form-control-lg" placeholder="class">
                                        <div class="valid-feedback">
                                            Ingrese un clase
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Imagen</label>
                                        <input type="file" name="image" @change="getImage" accept="image/*">
                                        <img :src="ticket.path" class="img-circle" width="150" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="ticket.id?'Actualizar':'Agregar'">Agregar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!--Fin del modal-->


    </main>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";
export default ({
    name:'Oficinas',
    data (){
        return {
            title:'Modal',
            arrayTickets : [],
            page:1,
            image:null,
        }
    },
    computed:{


    },
    methods : {
        getImage(e){
             this.image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.image);
            reader.onload = e => {
                this.ticket.path = e.target.result;
            }
        },
        openModalTicket(data = []){
            if(data){
                this.ticket = data;
                this.title = "Actualizar Oficina";
            }else{
                this.clearUser();
                this.title = "Crea nueva Oficina";
            }
            $("#modalcloseoficina1").click();
        },
        updateStated(data=[]){

            axios.put(URLS.API_TICKET_CRUD_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayTickets) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayTickets = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.ticket.id){
                axios.put(URLS.API_TICKET_CRUD_PUT+this.ticket.id,this.ticket).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayTickets) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalcloseoficina1").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_TICKET_CRUD_POST,this.ticket).then(res=>{
                    this.arrayTickets.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalcloseoficina1").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        destroyOficina(data=[]){
          axios.delete(URLS.API_TICKET_CRUD_DELETE+data.id).then(r=>{
              this.arrayTickets = this.arrayTickets.filter(item=>{
                  if(item.id!==data.id){
                      return item;
                  }

              });
          })
        },
        infiniteHandler($state) {
            axios.get(URLS.API_TICKET_CRUD_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayTickets.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },


    },
    mounted() {

    }
});
</script>
<style scoped>

</style>
