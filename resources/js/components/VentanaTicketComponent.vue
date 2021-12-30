<template>
    <main class="mt-0 mx-0" style="margin-top: -21px!important;">
        <!--<fovicola-component></fovicola-component> -->
        <div class="row mx-0">
            <div class="col-12">
                <corusel-component></corusel-component>
            </div>
            <div class="col-12 fixed-bottom">
                <div class="list-group list-group-horizontal-md text-center parpadea border-0 border-0 py-0" style="width: 100%!important;overflow-x: scroll!important;">
                    <div
                        v-for="(item,index) in temporal"
                        :key="index" style="width: 350px!important;">
                        <div>
                            <div class="list-group-item text-success bg-gradient-orange border bg-primary border-success mx-1  my-2 h1">
                                <span class="font-weight-bold h1" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                                <span class="font-weight-bold h1" v-text="item.ticket.serial+'-'+item.sequence"></span>
                                <span class="text-white font-weight-bold h1 pb-0" v-show="item.desk"><b>==></b> {{ item.desk.serial }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group list-group-horizontal-md text-center border-0 border-radius-0 py-0" style="width: 100%!important;overflow-x: scroll!important;">
                    <div
                        v-for="(item,index) in guest_clientes_list"
                        :key="index" style="width: 250px!important;">
                        <div v-if="parseInt(item.processing)===1">
                            <div class="list-group-item bg-light text-success  font-weight-bold border bg-primary border-success mx-1  my-2 h4">
                                <span  v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                                <span  v-text="item.ticket.serial+'-'+item.sequence"></span>
                            </div>
                        </div>
                        <div v-if="parseInt(item.processing)===2">
                            <div class="list-group-item bg-warning parpadea border bg-primary border-success mx-1  my-0 my-0 h4">
                                <span  class="text-dark font-weight-bold" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                                <span class="text-dark font-weight-bold h5" v-text="item.ticket.serial+'-'+item.sequence"></span>
                                <span class="text-dark border-top h5 pb-0 font-weight-bold" v-show="item.desk"> ==> {{ item.desk.serial }}</span>
                            </div>
                        </div>
                        <div v-else-if="parseInt(item.processing)===3">
                            <div class="list-group-item border bg-info  border-info my-0 my-0 h4">
                                <span class="text-dark font-weight-bold" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                                <span class="text-dark font-weight-bold h5" v-text="item.ticket.serial+'-'+item.sequence"></span>
                                <span class="text-dark border-top h5 pb-0 font-weight-bold" v-show="item.desk"> ==> {{ item.desk.serial }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <audio src="" hidden class=speech></audio>
    </main>
</template>

<script>
import {URLS} from "../Config/ApiUrl";
import CorouselComponent from "./gestion/CorouselComponent.vue";

export default {
    name: "VentanaTicketComponent",
    components: {
        'corusel-component':CorouselComponent,
    },
    data(){
      return {
          guest_clientes_list:[],
          call_clientes_list:[],
          temporal:[],
          listo:true,
          alerta:false,
      }
    },
    computed:{

    },
    created() {
        Echo.channel('channel-notification')
            .listen('.ticketEvent', (e) => {
                this.getAllTickets();
                if(e.ticket.processing === 2){
                    this.CallSpeak(e.ticket);
                }
            }).listen('CallQueueListEvent', (e)=>{
                this.temporal.push(e.queueList);
        });

    },
    methods:{
        CallSpeak(data=[]){
            if(URLS.SPEAK_ENABLE){
                let text = data.guest_name+"...módulo....."+data.desk.serial;
                responsiveVoice.speak(text,"Spanish Latin American Male")
            }

        },
        getAllTickets(){
            axios.get(URLS.API_PROCESA_GET).then(data=>{
                this.guest_clientes_list = data.data.guests;
                this.temporal = [];
                this.guest_clientes_list.forEach(item=>{
                    if(item.processing === 2){
                        this.temporal.push(item);
                    }
                })
            }).catch(err=>{

            })
        },
        LlamarAlternadamente(){
            this.temporal.forEach(item=>{
                this.CallSpeak(item);
            })
        }

    },
    mounted() {
        this.getAllTickets();
        let me = this;
        setInterval(function() {
            me.LlamarAlternadamente();
        }, URLS.SPEAK_TIME_RELOAD);
    }
}

</script>

<style scoped>

</style>
