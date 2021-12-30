<template>
    <main class="main">
        <div class="container-fluid">

            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">

                    <!-- TO DO List -->
                    <div class="card">
                        <div class="card-header bg-success">
                            <li class="d-flex justify-content-between h3">
                                Lista de roles
                                <span class="badge badge-success badge-pill">{{ arrayRoles.length }}</span>
                            </li>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li v-for="role in arrayRoles" :key="role.id" :class="parseInt(role.is_active)==0?role.class_default:'done'">
                                    <!-- drag handle -->
                                    <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                              </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" v-model.number="role.is_active"  @change="updateStated(role)" :id="role.id" >
                                        <label :for="role.id"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text" v-text="role.name"></span>
                                    <!-- Emphasis label -->
                                    <small class="badge" :class="role.is_active === 0? 'badge-success':role.class_default"><i class="fas fa-check"></i> {{role.key_name}}</small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fas fa-edit" @click="openModalRole(role)"></i>
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </li>
                                <infinite-loading @infinite="infiniteHandler">
                                    <div slot="no-more">No hay mas resultados</div>
                                    <div slot="no-results">No hay resultados</div>
                                </infinite-loading>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-success float-right"  @click="openModalRole"><i
                                class="fas fa-plus"></i> Agregar Rol</button>
                            <input type="hidden" id="modalOpen" data-toggle="modal"  data-target="#staticBackdrop"/>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>

            </div>

        </div>
        <!--Inicio del modal agregar/actualizar-->
          <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                            <label class="col-form-label">Key</label>
                                            <input type="text" v-model="role.key_name" :disabled="role.id" class="form-control form-control-lg" placeholder="Identificador" required>
                                            <div class="valid-feedback">
                                                Ingrese una key de identificación
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Nombre</label>
                                            <input type="text" v-model="role.name" class="form-control form-control-lg" placeholder="Nombre" required>
                                            <div class="valid-feedback">
                                                Ingrese el nombre del rol
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">clase</label>
                                            <input type="text" v-model="role.class_default" class="form-control form-control-lg" placeholder="Clase estilo" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalclose" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="role.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'RolesComponent',
    data (){
        return {
            title:'Modal',
            arrayRoles : [],
            page:1,
        }
    },
    computed:{


    },
    methods : {
        openModalRole(data = []){
            if(data){
                this.role = data;
                this.title = "Actualizar rol";
            }else{
                this.clearModalRole();
                this.title = "Crea nuevo rol";
            }
            $("#modalOpen").click();
        },
        updateStated(data=[]){
            axios.put(URLS.API_ROLES_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayRoles) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayRoles = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.role.id){
                axios.put(URLS.API_ROLES_PUT+this.role.id,this.role).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayRoles) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalclose").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_ROLES_POST,this.role).then(res=>{
                    this.arrayRoles.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalclose").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        infiniteHandler($state) {
            axios.get(URLS.API_ROLES_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayRoles.push(...data.data);
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

.modal-content{
    margin-top: 50px !important;
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.div-error{
    display: flex;
    justify-content: center;
}
.text-error{
    color: red !important;
    font-weight: bold;
}
</style>
