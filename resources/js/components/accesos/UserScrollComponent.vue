<template>
    <main class="main">
        <div class="container-fluid">

            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- TO DO List -->
                    <div class="card">
                        <div class="card-header bg-success">
                            <li class="d-flex justify-content-between h5 py-0 my-0">
                                Lista de Usuarios
                                <button type="button" class="btn tbn-sm btn-success float-right"  @click="openModaluser"><i
                                    class="fas fa-plus"></i> Agregar Usuario</button>
                            </li>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th> Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ur in arrayUsers" :key="ur.id">
                                            <td v-text="ur.full_name"></td>
                                            <td v-text="ur.name"></td>
                                            <td v-text="ur.email"></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success" @click="openModaluser(ur)"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-danger" @click="destroyUser(ur)"><i class="fa fa-trash"></i></button>
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

                            <input type="hidden" id="modalOpenUser" data-toggle="modal"  data-target="#staticBackdrop1"/>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>

            </div>

        </div>
        <!--Inicio del modal agregar/actualizar-->
          <!-- Modal -->
        <div class="modal fade" id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 120%!important">
                <div class="modal-content" style="width: 120%!important">
                    <form class="needs-validation" novalidate @submit.prevent="submitUser()">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="staticBackdropLabel" v-text="title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="col-form-label">Nombre y Apellidos</label>
                                            <input type="text" v-model="usuario.full_name"  class="form-control" placeholder="Nombre y Apellidos" required>
                                            <div class="valid-feedback">
                                                Nombres y Apellidos completos
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Roles</label>
                                            <v-select :options="roles" v-model="usuario.roles" label="name" multiple taggable />
                                        </div>
                                    </div>
                                </div>
                            <div class="row">

                                <div class="col">
                                    <div class="form-group">
                                        <label class="col-form-label">Oficinas</label>
                                        <v-select :options="tickets" v-model="usuario.tickets" label="name" multiple taggable />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="col-form-label">Ventanilla</label>
                                        <v-select :options="desks" v-model="usuario.desk_id" label="name" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="col-form-label">Usuario</label>
                                        <input type="text" v-model="usuario.name"  class="form-control" placeholder=" Usuario" required>
                                        <div class="valid-feedback">
                                            Usuario de identifiación
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="col-form-label">Correo Electrónico</label>
                                        <input type="email" v-model="usuario.email"  class="form-control" placeholder="Correo electrónico" required>
                                        <div class="valid-feedback">
                                            Correo electrónoico
                                        </div>
                                    </div>
                                </div>

                            </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalclose" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="usuario.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'usersComponent',
    data (){
        return {
            title:'Modal',
            arrayUsers : [],
            page:1,
            tickets:[],
            roles:[],
            desks:[],
        }
    },
    computed:{


    },
    methods : {
        getTickets() {
            axios.get(URLS.API_TICKET_GET).then(res=>{
                this.tickets = res.data;
            }).catch(err=>{
                console.log(err);
            });
        },
        getRoles() {
            axios.get(URLS.API_ROLES_GET).then(res=>{
                this.roles = res.data;
            }).catch(err=>{
                console.log(err);
            });
        },
        getDesks() {
            axios.get(URLS.API_DESKS_GET).then(res=>{
                this.desks = res.data;
            }).catch(err=>{
                console.log(err);
            });
        },
        findUser(id){
            axios.get(URLS.API_INFORMATION_USER+id).then(response=>{
                this.usuario.desk_id = response.data.data.user.desk_id;
                this.usuario.email = response.data.data.user.email;
                this.usuario.full_name = response.data.data.user.full_name;
                this.usuario.id = response.data.data.user.id;
                this.usuario.name = response.data.data.user.name;
                this.usuario.tickets = response.data.data.tickets;
                this.usuario.roles = response.data.data.roles;
                this.usuario.desk = response.data.data.desk;
            }).catch(err=>{
                console.log(err);
            })
        },
        openModaluser(data = []){
            if(data.id){
                this.clearUser();
                this.findUser(data.id);
                this.title = "Actualizar usuario";
            }else{
                this.clearUser();
                this.title = "Crear nuevo usuario";
            }
            $("#modalOpenUser").click();
        },
        updateStated(data=[]){
            axios.put(URLS.API_USERS_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayUsers) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayUsers = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submitUser(){
            if(this.usuario.id){
                axios.put(URLS.API_USERS_PUT+this.usuario.id,this.usuario).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayUsers) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.arrayUsers = temp;
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalOpenUser").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_USERS_POST,this.usuario).then(res=>{
                    this.arrayUsers.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalOpenUser").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        infiniteHandler($state) {
            axios.get(URLS.API_USERS_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayUsers.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },
        destroyUser(data=[]){
            const swalWithBootstrapButtons =  this.$swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '¿Seguro de eliminar el usuario?',
                text: "¡No podrás revertir por sistema!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, aceptar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(URLS.API_USERS_DELETE+data.id).then(res=>{
                        this.arrayUsers = this.arrayUsers.filter(function(item) {
                            return item.id !== data.id
                        })
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'Sequir configurando usuarios.',
                            'success'
                        )
                    });

                } else if (
                    result.dismiss === this.$swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado!',
                        'El usuario no se eliminó :)',
                        'error'
                    )
                }
            })
        },

    },
    mounted() {
        this.getTickets();
        this.getRoles();
        this.getDesks();
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
