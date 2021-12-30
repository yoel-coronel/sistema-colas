<template>
    <main class="main">
        <div class="container-fluid">
            <!-- TO DO List -->
            <div class="card">
                <div class="card-header bg-success">
                    <li class="d-flex justify-content-between h3">
                        Lista de ticketeras
                        <span class="badge badge-success badge-pill">{{ arrayticketeraeras.length }}</span>
                    </li>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>Name Host</th>
                                <th>Password Host</th>
                                <th>Name User</th>
                                <th>Name Ticketera</th>
                                <th>Connect IP</th>
                                <th>Level</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ur in arrayticketeraeras" :key="ur.id">
                                <td v-text="ur.name_host"></td>
                                <td v-text="ur.password_host"></td>
                                <td v-text="ur.name_user_host"></td>
                                <td v-text="ur.name_ticket"></td>
                                <td v-text="ur.ip_ticket"></td>
                                <td v-text="ur.level"></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success" @click="openModalticketera(ur)"><i class="fas fa-edit"></i></button>
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
                    <button type="button" class="btn btn-success float-right"  @click="openModalticketera"><i
                        class="fas fa-plus"></i> Agregar Oficina</button>
                    <input type="hidden" id="modalcloseoficina11" data-toggle="modal"  data-target="#staticOficio"/>
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
                                        <label class="col-form-label">Módulo</label>
                                      <select class="custom-select" v-model="ticketera.modulo_id">
                                          <option v-for="modulo in modulos" :key="modulo.id" v-text="modulo.name" :value="modulo.id"></option>
                                      </select>
                                        <div class="valid-feedback">
                                            Seleccione un módulo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name Host</label>
                                        <input type="text" v-model="ticketera.name_host" class="form-control form-control-lg" placeholder="Name Host">
                                        <div class="valid-feedback">
                                           Ingrese el name host.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Password</label>
                                        <input type="text" v-model="ticketera.password_host" class="form-control form-control-lg" placeholder="Password Host">
                                        <div class="valid-feedback">
                                           Ingrese el password host.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name User </label>
                                        <input type="number" v-model.number="ticketera.name_user_host" class="form-control form-control-lg" placeholder="Name User">
                                        <div class="valid-feedback">
                                            Ingrese el name user host
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">level</label>
                                        <select class="custom-select" v-model="ticketera.level">
                                            <option value="1" selected>Connect IP</option>
                                            <option value="2" >Connect Local</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name Ticketera</label>
                                        <input type="text" v-model.number="ticketera.name_ticket" class="form-control form-control-lg" placeholder="Name Ticketera">
                                        <div class="valid-feedback">
                                            Ingrese un clase
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">IP Ticketera</label>
                                        <input type="text" v-model.number="ticketera.ip_ticket" class="form-control form-control-lg" placeholder="IP Ticketera">
                                        <div class="valid-feedback">
                                            Ingrese la IP ticketera
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="ticketera.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'ticketeraeras',
    data (){
        return {
            title:'Modal',
            arrayticketeraeras : [],
            modulos:[],
            page:1,
        }
    },
    computed:{


    },
    methods : {
        getModulos(){
          axios.get(URLS.API_MODULO_GET).then(res=>{
              this.modulos = res.data;
          });
        },
        openModalticketera(data = []){
            if(data){
                this.ticketera = data;
                this.title = "Actualizar Ticketera";
            }else{
                this.clearUser();
                this.title = "Crea nueva Ticketera";
            }
            $("#modalcloseoficina11").click();
        },
        submit(){
            if(this.ticketera.id){
                axios.put(URLS.API_TICKETERA_CRUD_PUT+this.ticketera.id,this.ticketera).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayticketeraeras) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalcloseoficina11").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_TICKETERA_CRUD_POST,this.ticketera).then(res=>{
                    this.arrayticketeraeras.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalcloseoficina11").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        destroyOficina(data=[]){
            axios.delete(URLS.APITICKETERA_CRUD_DELETE+data.id).then(r=>{
                this.arrayticketeraeras = this.arrayticketeraeras.filter(item=>{
                    if(item.id!==data.id){
                        return item;
                    }

                });
            })
        },
        infiniteHandler($state) {
            axios.get(URLS.API_TICKETERA_CRUD_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayticketeraeras.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },


    },
    mounted() {
            this.getModulos();
    }
});
</script>
<style scoped>

</style>
