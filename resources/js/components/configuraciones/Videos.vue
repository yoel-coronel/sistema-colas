<template>
    <main class="main">
        <div class="container-fluid">
            <!-- TO DO List -->
            <div class="card">
                <div class="card-header bg-success">
                    <li class="d-flex justify-content-between h3">
                        Lista de Archivos
                        <span class="badge badge-success badge-pill">{{ arraycarousel_data.length }}</span>
                    </li>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Tiempo duración</th
                                <th>type Player</th>
                                <th>File</th>
                                <th>Class</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ur in arraycarousel_data" :key="ur.id">
                                <td v-text="ur.name"></td>
                                <td v-text="ur.tiempo"></td>
                                <td v-text="ur.type_player"></td>
                                <td>
                                    <img :src="ur.path" class="img-circle" width="50" />
                                </td>
                                <td v-text="ur.class_default"></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success" @click="openModalcarousel_data(ur)"><i class="fas fa-edit"></i></button>
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
                    <button type="button" class="btn btn-success float-right"  @click="openModalcarousel_data"><i
                        class="fas fa-plus"></i> Agregar Oficina</button>
                    <input type="hidden" id="modalclosecarousel_data" data-toggle="modal"  data-target="#staticOficio"/>
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
                                        <label class="col-form-label">Nombre</label>
                                        <input type="text" v-model="carousel_data.name" class="form-control form-control-lg" placeholder="Nombre" required>
                                        <div class="valid-feedback">
                                            Nombre del archivo
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Tiempo Referencial</label>
                                        <input type="text" v-model="carousel_data.tiempo" class="form-control form-control-lg" placeholder="Tiempo" required>
                                        <div class="valid-feedback">
                                            Tiempo referencial
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo Player</label>
                                       <select class="custom-select" v-model="carousel_data.type_player">
                                           <option value="imgen/png">Imagen</option>
                                           <option value="video/mp4">Video</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">class</label>
                                        <input type="text" v-model.number="carousel_data.class_default" class="form-control form-control-lg" placeholder="class">
                                        <div class="valid-feedback">
                                            Ingrese un clase
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Archivo</label>
                                        <input type="file" name="image" @change="getImage" accept="image/*">
                                        <img :src="carousel_data.path" class="img-circle" width="150" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" v-text="carousel_data.id?'Actualizar':'Agregar'">Agregar</button>
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
    name:'Videos',
    data (){
        return {
            title:'Modal',
            arraycarousel_data : [],
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
                this.carousel_data.path = e.target.result;
            }
        },
        openModalcarousel_data(data = []){
            if(data){
                this.carousel_data = data;
                this.title = "Actualizar Archivo";
            }else{
                this.clearCarousel();
                this.title = "Crea nuevo Archivo";
            }
            $("#modalclosecarousel_data").click();
        },
        updateStated(data=[]){

            axios.put(URLS.API_CAROUSEL_PUT+data.id,data).then(res=>{
                var temp = [];
                for (let info  of this.arraycarousel_data) {
                    if(info.id === res.data.data.id){
                        temp.push(res.data.data);
                    }else{
                        temp.push(info);
                    }
                }
                this.arraycarousel_data = temp;
                this.NotityEvent({'title':'Success','description':res.data.message},'success')
            }).catch(err=>{
                if(err.response){
                    this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                }

            });
        },
        submit(){
            if(this.carousel_data.id){
                axios.put(URLS.API_CAROUSEL_PUT+this.carousel_data.id,this.carousel_data).then(res=>{
                    var temp = [];
                    for (let info  of this.arraycarousel_data) {
                        if(info.id === res.data.data.id){
                            temp.push(res.data.data);
                        }else{
                            temp.push(info);
                        }
                    }
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalclosecarousel_data").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });

            }else{
                axios.post(URLS.API_CAROUSEL_POST,this.carousel_data).then(res=>{
                    this.arraycarousel_data.push(res.data.data);
                    this.NotityEvent({'title':'Success','description':res.data.message},'success')
                    $("#modalclosecarousel_data").click();
                }).catch(err=>{
                    if(err.response){
                        this.NotityEvent({'title':'Error','description':err.response.data.error},'warn')
                    }
                    console.log(err);

                });
            }
        },
        destroyOficina(data=[]){
            axios.delete(URLS.API_CAROUSEL_DELETE+data.id).then(r=>{
                this.arraycarousel_data = this.arraycarousel_data.filter(item=>{
                    if(item.id!==data.id){
                        return item;
                    }

                });
            })
        },
        infiniteHandler($state) {
            axios.get(URLS.API_CAROUSEL_GET_PAGE, {
                params: {
                    page: this.page,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arraycarousel_data.push(...data.data);
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
