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
                                Lista de tipo de consultas de clientes
                                <span class="badge badge-success badge-pill">{{ arrayQueryTypeCustomers.length }}</span>
                            </li>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li v-for="queryTypeCustomer in arrayQueryTypeCustomers" :key="queryTypeCustomer.id" :class="parseInt(queryTypeCustomer.is_active)==0?'':'done'">
                                    <!-- drag handle -->
                                    <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                              </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" v-model.number="queryTypeCustomer.is_active"  @change="updateStated(queryTypeCustomer)" :id="queryTypeCustomer.id" >
                                        <label :for="queryTypeCustomer.id"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text" v-text="queryTypeCustomer.name"></span>
                                    <!-- Emphasis label -->
                                    <small class="badge" :class="queryTypeCustomer.is_active === 0? 'badge-success':''"><i class="fas fa-check"></i> </small>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fas fa-edit" @click="openModalqueryTypeCustomer(queryTypeCustomer)"></i>
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
                            <button type="button" class="btn btn-success float-right"  @click="openModalqueryTypeCustomer"><i
                                class="fas fa-plus"></i> Agregar Tipo de Consulta</button>
                            <input type="hidden" id="modalOpenQueryTypeCustomer" data-toggle="modal"  data-target="#staticBackdrop13"/>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>

            </div>

        </div>
        <!--Inicio del modal agregar/actualizar-->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop13" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <label class="col-form-label">Descripción</label>
                                        <input type="text" v-model="queryTypeCustomer.name" class="form-control form-control-lg" placeholder="Descripción" required>
                                        <div class="valid-feedback">
                                            Ingrese la descripción del tipo de consulta
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalCloseQueryTypeCustomer" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="queryTypeCustomer.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'QueryTypeCustomers',
    data (){
        return {
            title:'Modal',
            arrayQueryTypeCustomers : [],
            page:1,
        }
    },
    computed:{


    },
    methods : {
        openModalqueryTypeCustomer(data = []){
            if(data){
                this.queryTypeCustomer = data;
                this.title = "Actualizar tipo consulta";
            }else{
                this.clearqueryTypeCustomer();
                this.title = "Crea nuevo tipo consulta";
            }
            $("#modalOpenQueryTypeCustomer").click();
        },
        updateStated(data=[]){
            axios.put(URLS.API_QUERYTYPECUSTOMERS_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayQueryTypeCustomers) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayQueryTypeCustomers = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.queryTypeCustomer.id){
                axios.put(URLS.API_QUERYTYPECUSTOMERS_PUT+this.queryTypeCustomer.id,this.queryTypeCustomer).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayQueryTypeCustomers) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalCloseQueryTypeCustomer").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_QUERYTYPECUSTOMERS_POST,this.queryTypeCustomer).then(res=>{
                    this.arrayQueryTypeCustomers.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalCloseQueryTypeCustomer").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        infiniteHandler($state) {
            axios.get(URLS.API_QUERYTYPECUSTOMERS_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayQueryTypeCustomers.push(...data.data);
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
