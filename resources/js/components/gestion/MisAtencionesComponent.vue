<template>
    <div class="card">
        <h5 class="card-header">
            <li class="d-flex justify-content-between align-items-center">
              Atendiendo los siguientes tickets
                <span class="badge badge-danger badge-pill">{{ tickets.length }}</span>
            </li>
        </h5>
        <div class="card-body">

            <div class="list-group list-group-horizontal-md text-center" style="width: 100%!important;overflow-x: scroll!important;">
                <div
                    v-for="(item,index) in tickets"
                    :key="index">
                    <div v-if="parseInt(item.processing)===2" @click="infoCallTicket(item)">
                        <div class="list-group-item text-dark font-weight-bold border bg-primary border-success mx-1  my-2 h6">
                            <span  class="text-white"v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                            <span class="text-white" v-text="item.ticket.serial+'-'+item.sequence"></span>
                        </div>
                    </div>
                    <div @click="infoCallTicket(item)" v-else-if="parseInt(item.processing)===3">
                        <div class="list-group-item font-weight-bold border bg-info  border-info mx-1  my-2 h6">
                            <span class="text-dark" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                            <span class="text-dark" v-text="item.ticket.serial+'-'+item.sequence"></span>
                        </div>
                    </div>
                    <div @click="infoCallTicket(item)" v-else-if="parseInt(item.processing)===4">
                        <div class="list-group-item font-weight-bold border bg-danger  border-info mx-1  my-2 h6">
                            <span class="text-white"v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                            <span class="text-white" v-text="item.ticket.serial+'-'+item.sequence"></span>
                        </div>
                    </div>
                    <div @click="infoCallTicket(item)" v-else-if="parseInt(item.processing)===5">
                        <div class="list-group-item font-weight-bold bg-secondary border bg-danger  border-info mx-1  my-2 h6">
                            <span class="text-white" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                            <span class="text-white" v-text="item.ticket.serial+'-'+item.sequence"></span>
                        </div>
                    </div>
                    <div @click="infoCallTicket(item)" v-else-if="parseInt(item.processing)===6">
                        <div class="list-group-item font-weight-bold bg-success border bg-danger  border-info mx-1  my-2 h6">
                            <span class="text-dark" v-text="item.guest_name?item.guest_name:'Invitado'"></span><br>
                            <span class="text-dark" v-text="item.ticket.serial+'-'+item.sequence"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";

export default {
    name: "MisAtencionesComponent",
    props: ['usrAuth'],
    data() {
        return {
            tickets: [],
        }
    },
    created() {
        Echo.channel('channel-notification')
            .listen('.ticketEvent', (e) => {
                this.getMisTicketsMyDesk();
            });

    },
    methods: {
        infoCallTicket(data = []) {
           this.$emit('infoCallTicket', data);
        },
        getMisTicketsMyDesk() {
            axios.get(URLS.API_PROCESA_MIS_ATENCIONES_GET + this.usrAuth.id).then(response => {
                this.tickets = response.data.mis_atenciones;
            }).catch(err => {
                console.log(err);
            })
        },
    },
    mounted() {
        this.getMisTicketsMyDesk();
    }
}
</script>

<style scoped>

</style>
