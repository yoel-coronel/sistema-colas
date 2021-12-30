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
                                Lista de posiciones
                                <span class="badge badge-success badge-pill">{{ arrayDesks.length }}</span>
                            </li>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li v-for="desk in arrayDesks" :key="desk.id" :class="parseInt(desk.is_active)==0?'':'done'">
                                    <!-- drag handle -->
                                    <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                              </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" v-model.number="desk.is_active"  @change="updateStated(desk)" :id="desk.id" >
                                        <label :for="desk.id"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text" v-text="desk.name"></span>
                                    <!-- Emphasis label -->
                                    <small class="badge" :class="desk.is_active === 0? 'badge-success':''"><i class="fas fa-check"></i> {{desk.serial}}</small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fas fa-edit" @click="openModaldesk(desk)"></i>
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
                            <button type="button" class="btn btn-success float-right"  @click="openModaldesk"><i
                                class="fas fa-plus"></i> Agregar Posición</button>
                            <input type="hidden" id="modalOpen" data-toggle="modal"  data-target="#staticBackdrop1"/>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>

            </div>

        </div>
        <!--Inicio del modal agregar/actualizar-->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <input type="text" v-model="desk.serial" class="form-control form-control-lg" placeholder="Identificador" required>
                                        <div class="valid-feedback">
                                            Ingrese una key de Serial
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre</label>
                                        <input type="text" v-model="desk.name" class="form-control form-control-lg" placeholder="Nombre" required>
                                        <div class="valid-feedback">
                                            Ingrese el nombre del posición
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalclose" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="desk.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'Posiciones',
    data (){
        return {
            title:'Modal',
            arrayDesks : [],
            page:1,
        }
    },
    computed:{


    },
    methods : {
        openModaldesk(data = []){
            if(data){
                this.desk = data;
                this.title = "Actualizar rol";
            }else{
                this.clearDesk();
                this.title = "Crea nuevo rol";
            }
            $("#modalOpen").click();
        },
        updateStated(data=[]){
            axios.put(URLS.API_DESK_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayDesks) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayDesks = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.desk.id){
                axios.put(URLS.API_DESK_PUT+this.desk.id,this.desk).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayDesks) {
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
                axios.post(URLS.API_DESK_POST,this.desk).then(res=>{
                    this.arrayDesks.push(res.data.data);
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
            axios.get(URLS.API_DESK_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayDesks.push(...data.data);
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
