<template>
    <div class="container">

        <fovicola-component></fovicola-component>

        <main>
            <div class="album py-1 bg-light">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-1">
                        <div class="col mb-4"  v-for="d in data" :key="d.id" @click="openModalTeclado(d)">
                            <div class="card shadow-sm" :class="d.class_default" style="height: 200px!important;">
                                <div class="card-body btn btn-success">
                                    <img :src="d.path" width="50" class="text-white"/>
                                    <h1 class="card-text" v-text="d.name"></h1>
                                    <div class="d-flex justify-content-between text-center align-items-center">
                                        <small v-text="d.description"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <input type="hidden" id="closeTeclado" data-dismiss="modal" aria-label="Close"/>
        <input type="hidden" id="tecladoTotenOpen" data-toggle="modal"  data-target="#teclado"/>
        <!-- Modal -->
        <div class="modal fade" id="teclado" data-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog rounded">
                <div class="modal-content">
                    <form novalidate @submit.prevent="postTickets">
                       <!-- <div class="modal-header bg-success">
                            <h5 v-text="title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>-->
                        <div class="modal-body">
                            <input type="text" v-model="nro"
                                   class="form-control form-control-border form-control-lg font-weight-bold form-control border-bottom border-success text-center"
                                   id="generador_numero"
                                   disabled="true"
                                   style="font-size: 30px!important;"
                                   autofocus autocomplete="false"
                                   maxlength="8"
                                   minlength="6"
                                   placeholder="CIP o DNI"
                                   required
                                   onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <div class="container flex-fill">
                            <div class="row">
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="1" @click="generCode(1)">1</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="2" @click="generCode(2)">2</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="3" @click="generCode(3)">3</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="4" @click="generCode(4)">4</div>
                            </div>
                            <div class="row">
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="5" @click="generCode(5)">5</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="6" @click="generCode(6)">6</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="7" @click="generCode(7)">7</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="8" @click="generCode(8)">8</div>
                            </div>
                            <div class="row">
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="9" @click="generCode(9)">9</div>
                                <div class="col-3 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="0" @click="generCode(0)">0</div>
                                <div class="col-6 bg-light font-weight-bold text-center shadow rounded-circle mb-4 py-3 btn btn-lg" style="font-size: 30px!important;" id="x" @click="clianCode()">x</div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="modal-footer border-0 by-5 border-radios-0 my-0 flex-column-reverse btn-block btn-success h2">Genera tu Ticket</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!--Fin del modal-->

    </div>
</template>

<script>
    import {URLS} from "../Config/ApiUrl";
    export default {
        data(){
            return{
                data:[],
                dataSeleted:{},
                title:'',
                nro:'',
            }
        },

        methods:{
            generCode(n){
                if(this.nro.trim().length<=7){
                    this.nro +=n;
                    this.nro.trim();
                }

            },
            clianCode(){
                this.nro = "";
            },
            openModalTeclado(data=[]){
                this.dataSeleted = data;
                this.title=data.name;
                $("#tecladoTotenOpen").click();
            },
            getTickets() {
                axios.get(URLS.API_TICKET_GET).then(({data}) => {
                   this.data = data;
                }).catch(err=>{
                    this.getTickets();
                    console.log(err)
                });
            },
            postTickets(data=[]) {
                if(this.nro.length === 8 || this.nro.length === 6){
                    axios.post(URLS.API_PROCESA_POST,{
                        'data':this.dataSeleted,
                        'nro':this.nro
                    }).then(res => {
                        $("#teclado").click();
                        this.NotityEvent({'title':res.data.success,'description':null});
                    }).catch(err=>{
                        console.log(err)
                    });
                }
            },

        },
        mounted() {
            this.getTickets();
            let me = this;
            $('#teclado').on('show.bs.modal', function (event) {
                me.nro = "";
            });
        },

    }
</script>
