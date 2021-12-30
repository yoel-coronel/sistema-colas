<template>
    <div class="card">
        <h5 class="card-header card-light border-bottom-0">
            <li class="d-flex justify-content-between align-items-center">
                Tickets por atender
                <span class="badge badge-danger badge-pill">{{ tickets.length }}</span>
            </li>
        </h5>
        <div class="card-body py-0 px-0">
            <!--style="width: 100%!important;overflow-x: scroll!important;"-->
            <ul  class="list-group" id="siendo-atendidos" >
                <li class="list-group-item d-flex justify-content-between align-items-center btn parpadea bg-warning"
                    v-for="(listo,idx) in tickets_primeros" :key="idx" title="LLamar Cliente"
                    @click="startCallTicket(listo)"
                    v-if="tickets_primeros.length>0">
                    <div class="font-weight-bold">
                        <i class="fas fa-2x fa-phone-volume mr-2"></i> <span v-text="listo.guest_name?listo.guest_name:'Invitado'"></span>
                    </div>
                    <span class="badge badge-danger" v-text="listo.ticket.serial+'-'+listo.sequence"></span>
                    <span class="badge badge-dark"><i class="fa fa-clock mr-2"></i>{{ listo.created_at| horaMinuto }}</span>
                </li>
            </ul>
            <hr>
            <div class="list-group border-0 overflow-auto" id="items"  style="height: 47vh!important;">
                <li class="list-group-item d-flex justify-content-between align-items-center btn" :class="item.ticket.class_default"
                    v-for="(item,index) in tickets"
                    :key="index"
                    title="Doble Click para atender"
                    v-if="tickets.length>0"
                    @dblclick="startCallTicket(item)">
                    <div class="font-weight-bold">
                        <i class="fas fa-grip-lines mr-1 px-0"></i> <small v-text="item.guest_name?item.guest_name:'Invitado'"></small>
                    </div>
                    <span class="badge badge-danger" v-text="item.ticket.serial+'-'+item.sequence"></span>
                    <span class="badge badge-dark"><i class="fa fa-clock mr-2"></i>{{ item.created_at| horaMinuto }}</span>
                </li>
            </div>


        </div>
    </div>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";
import Draggable from 'vuedraggable'

export default {
    name: "ListTicketsComponent",
    props: ['usrAuth'],
    components: {
        Draggable,
    },
    data() {
        return {
            tickets: [],
            tickets_primeros:[],
        }
    },
    computed:{

    },
    created() {
        Echo.channel('channel-notification')
            .listen('.ticketEvent', (e) => {
                this.getAllTicketsMyDesk();
            });

    },
    methods: {
        limpiarColas(data=[]){

            this.tickets_primeros = this.tickets_primeros.filter(elemen=>{
               if(elemen.id!==data.id){
                   return elemen;
               }
            });

            this.tickets = this.tickets.filter(item=>{
                if(item.id!== data.id){
                    return item;
                }
            })
            this.selectecFirst(this.tickets);
        },
        startCallTicket(data = []) {
                axios.put(URLS.API_PROCESA_LLAMADA_PUT+data.id,data).then(res=>{
                    this.$emit('initCallTicket', res.data);
                    this.limpiarColas(res.data);
                }).catch(err=>{});
        },
        selectecFirst(data = []){
            this.tickets_primeros = [];
            if(data.length>0){
                if (data.length === 1){
                    this.tickets_primeros = data;
                    this.tickets = [];
                }else{
                    this.tickets_primeros.push(data[0]);
                    this.tickets = this.tickets.filter(item=>{
                        return item !== this.tickets_primeros[0];
                    })
                }
            }
        },
        getAllTicketsMyDesk() {
            axios.get(URLS.API_TICKETS_GET + this.usrAuth.id).then(response => {
                this.tickets = response.data.guests;
                this.selectecFirst(this.tickets);
            }).catch(err => {
                console.log(err);
            })
        },
    },
    mounted() {
        this.getAllTicketsMyDesk();


        var el = document.getElementById('items');
        var siendo_atendido = document.getElementById('siendo-atendidos');
        var sortable = this.$sortable.create(el,{
            group:{
                name:'queue-list',
                pull:true,
                put:false
            },
            animation: 150,
            easing: "cubic-bezier(0.5, 0, 0.75, 0)",
            handle:'.fas',
            ghostClass: "active",
        });
        var siendo_atendido = document.getElementById('siendo-atendidos');
        var siendo_atendidoCo = this.$sortable.create(siendo_atendido,{
            group:{
                name:'queue-list',
                pull:false,
                put:true
            },
            animation: 150,
            easing: "cubic-bezier(0.5, 0, 0.75, 0)",
            handle:'.fas',
            ghostClass: "active",
            //chosenClass:"active",

        });

    }
}

</script>

<style scoped>
.fas{
    cursor: move;
}

</style>
