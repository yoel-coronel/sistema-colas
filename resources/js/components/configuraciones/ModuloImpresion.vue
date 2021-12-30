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
                                Lista de modulos
                                <span class="badge badge-success badge-pill">{{ arrayModulos.length }}</span>
                            </li>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                <li v-for="modulo in arrayModulos" :key="modulo.id" :class="parseInt(modulo.is_active)==0?'':'done'">
                                    <!-- drag handle -->
                                    <span class="handle">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <i class="fas fa-ellipsis-v"></i>
                                              </span>
                                    <!-- checkbox -->
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" v-model.number="modulo.is_active"  @change="updateStated(modulo)" :id="modulo.id" >
                                        <label :for="modulo.id"></label>
                                    </div>
                                    <!-- todo text -->
                                    <span class="text" v-text="modulo.name"></span>
                                    <!-- General tools such as edit or delete-->
                                    <div class="tools">
                                        <i class="fas fa-edit" @click="openModalmodulo(modulo)"></i>
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
                            <button type="button" class="btn btn-success float-right"  @click="openModalmodulo"><i
                                class="fas fa-plus"></i> Agregar módulo</button>
                            <input type="hidden" id="modalOpenModulo" data-toggle="modal"  data-target="#modaltarget"/>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>

            </div>

        </div>
        <!--Inicio del modal agregar/actualizar-->
        <!-- Modal -->
        <div class="modal fade" id="modaltarget" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <label class="col-form-label">Nombre</label>
                                        <input type="text" v-model="modulo.name" class="form-control form-control-lg" placeholder="Nombre" required>
                                        <div class="valid-feedback">
                                            Ingrese el nombre del módulo
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modalclose" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="modulo.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'ModuloImpresion',
    data (){
        return {
            title:'Modal',
            arrayModulos : [],
            page:1,
        }
    },
    computed:{


    },
    methods : {
        openModalmodulo(data = []){
            if(data){
                this.modulo = data;
                this.title = "Actualizar módulo";
            }else{
                this.clearModulo();
                this.title = "Crea nuevo módulo";
            }
            $("#modalOpenModulo").click();
        },
        updateStated(data=[]){
            axios.put(URLS.API_MODULO_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arrayModulos) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arrayModulos = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.modulo.id){
                axios.put(URLS.API_MODULO_PUT+this.modulo.id,this.modulo).then(res=>{
                    var temp = [];
                    for (let info  of this.arrayModulos) {
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
                axios.post(URLS.API_MODULO_POST,this.modulo).then(res=>{
                    this.arrayModulos.push(res.data.data);
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
            axios.get(URLS.API_MODULO_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayModulos.push(...data.data);
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
