<template>
        <main>

            <div class="card mt-0 mb-1">
                <div class="card-header bg-success text-white">
                    <h5 class="font-weight-bold">Atención al Cliente</h5>
                </div>
                <div class="card-body pt-0">

                    <div class="row">
                        <div class="col-md-9">
                            <div class="card text-center">
                                <div class="card-body">
                                   <table>
                                       <tr>
                                           <th>OFICINA:</th>
                                           <td>  <select class="form-control form-control-lg custom-select font-weight-bold text-success" v-model="queue_list.ticket_id">
                                               <option v-for="ofi in authInformation.tickets" :value="ofi.id" :key="ofi.id" v-text="ofi.name +' - '+ofi.serial "></option>
                                           </select></td>
                                           <th>Módulo:</th>
                                           <td  class="h6"><span class="badge badge-warning">{{ queue_list.desk.serial }}</span></td>
                                           <th>Cliente:</th>
                                           <td  class="h6"><span class="badge badge-warning">{{ queue_list.guest_name }}</span></td>
                                           <th>Código:</th>
                                           <td class="h6"><span class="badge badge-warning">{{ queue_list.ticket.serial }} - {{ queue_list.sequence }}</span> </td>
                                           <th>Hora:</th>
                                           <td class="h6"><span class="badge badge-warning">{{ queue_list.read_at | horaMinuto }}</span></td>
                                       </tr>
                                   </table>
                                </div>
                            </div>
                            <h5 class="font-weight-bold">Información Personal</h5>
                            <hr>
                            <div class="row">
                                <div class="col-sm-8 text-right">Buscar:</div>
                                <div class="col-sm-4">
                                    <form class="form-inline my-2 my-lg-0" @submit.prevent="searchPersona">
                                        <input class="form-control mr-sm-2" type="search" v-model="search_value" @blur="searchPersona" placeholder="CIP o DNI" aria-label="Search">
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" :disabled="spinner">
                                            <div class="spinner-border spinner-border-sm" v-show="spinner" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="form-group" >
                                        <label :for="queue_list.customer.full_name">Nombres</label>
                                        <input :id="queue_list.customer.full_name" type="email" class="form-control" v-model="queue_list.customer.full_name"  placeholder="Nombres Completos">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label :for="queue_list.customer.full_surname">Apellidos</label>
                                        <input :id="queue_list.customer.full_surname" type="email" class="form-control" v-model="queue_list.customer.full_surname" placeholder="Apellidos Completos">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label :for="queue_list.customer.document_number">Nro. Documento</label>
                                        <input :id="queue_list.customer.document_number" type="text" maxlength="8" class="form-control" v-model="queue_list.customer.document_number" placeholder="00000000">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label :for="queue_list.customer.cip_number">N° CIP</label>
                                        <input :id="queue_list.customer.cip_number" type="email" class="form-control" v-model="queue_list.customer.cip_number"  placeholder="00000000">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4">
                                    <label :for="queue_list.description">Observaciones</label>
                                    <textarea :id="queue_list.description" v-model="queue_list.description"  class="form-control" rows="5"></textarea>
                                </div>
                                <div class="col-2">
                                    <label :for="queue_list.description">Tipo Consulta</label>
                                    <select v-model="queue_list.query_type_customer_id" class="custom-select">
                                        <option v-for="query in query_type_customers" :key="query.id" v-text="query.name" :value="query.id"></option>
                                    </select>
                                </div>
                                <div class="col-3 ">
                                    <div class="form-group">
                                        <label :for="queue_list.customer.telephone">N° Tel / Cel </label>
                                        <input :id="queue_list.customer.telephone" type="text" class="form-control" v-model="queue_list.customer.telephone" >
                                    </div>
                                </div>
                                <div class="col-3 mt-4">
                                    <button class="btn btn-outline-success btn-block btn-lg" :disabled="(!apinner_procesa && !queue_list.id)?true:false"
                                            @click="sumitInformation()" style="height: 50px!important;">
                                        <div class="spinner-border spinner-border-sm" v-show="apinner_procesa" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <i class="fas fa-1x fa-check"></i>
                                        Finalizar</button>
                                </div>

                            </div>


                            <div class="row my-2">
                                <div class="col">
                                    <button class="btn btn-outline-secondary btn-block btn-lg"
                                            :class="isActive(4)?'active':''"
                                            style="height: 50px!important;" >
                                        <i class="fas fa-1x fa-bolt"></i>Liberar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary btn-block btn-lg"
                                            :class="isActive(5)?'active':''"
                                            @click="clienteAusente()"
                                            style="height: 50px!important;">
                                        <i class="fas fa-1x fa-user-times"></i>
                                        No se Presentó</button>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-3">

                            <list-tickts-component @initCallTicket="initCallTicket(...arguments)"
                                                   :usrAuth="userauth"></list-tickts-component>
                        </div>
                    </div>
                </div>
            </div>


            <mis-tickts-component @infoCallTicket="initCallTicket(...arguments)"
                                  :usrAuth="userauth"></mis-tickts-component>

        </main>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";

export default {
    name: "AtencionComponent",
    props:['userauth'],
    data () {
        return {
            authInformation:[],
            query_type_customers:[],
            search_value:null,
            spinner:false,
            apinner_procesa:false,
        }
    },
    created() {
    },
    computed:{

    },

    methods:{
        getQueryTypeCustomers(){
          axios.get(URLS.API_QUERYTYPECUSTOMERS_GET).then(res=>{
              this.query_type_customers = res.data;
          });
        },
        isActive($item){
            let isOk=false;
            for (const element of this.queue_list.processing_events) {
                if(element.processing === $item){
                    isOk = true;
                    break;
                }
            }
            return isOk;
        },
        sumitInformation(){
            if(this.queue_list.customer.full_name && this.queue_list.customer.full_name && this.queue_list.query_type_customer_id){
                this.apinner_procesa = true;
                axios.put(URLS.API_PROCESA_ATENCION_ALL_PUT+this.queue_list.id,this.queue_list).then(res=>{
                    this.NotityEvent({'title':res.data.success,'description':res.data.success});
                    this.apinner_procesa=false;
                    this.clearQueueList();
                    this.search_value = null;
                }).catch(err=>{
                    console.log(err);
                    this.apinner_procesa=false;
                });
            }

        },
        searchPersona(){
            if(!this.search_value)return;
            if(this.search_value.length === 8){
                this.spinner =true;
                axios.get(URLS.API_SEARCH_ORACLE_PERSONA+this.search_value).then(res=>{
                    let resp = res.data;
                    if (resp){
                        this.queue_list.customer.iden_pers_per = resp.iden_pers_per;
                        this.queue_list.customer.full_surname = resp.apel_pate_per?resp.apel_pate_per:'' +' '+ resp.apel_mate_per?resp.apel_mate_per:'' ;
                        this.queue_list.customer.full_name = resp.nomb_pers_per;
                        this.queue_list.customer.document_number = resp.nume_iden_per;
                        this.queue_list.customer.cip_number = resp.codi_ccip_soc;
                    }
                    this.spinner = false;
                }).catch(err=>{
                    console.log(err);
                    this.spinner = false;
                })
            }

        },
        startQueueList(){
            if (this.queue_list.id && this.queue_list.processing !== 3 && this.queue_list.processing !== 5){
                axios.put(URLS.API_PROCESA_START_PUT+this.queue_list.id,this.queue_list).then(res=>{
                    this.initCallTicket(res.data);
                }).catch(err=>{});
            }
        },
        clienteAusente(){
            if (this.queue_list.id && this.queue_list.processing !== 5 && this.queue_list.processing !== 3){
                axios.put(URLS.API_PROCESA_CLIENTE_AUSENTE_PUT+this.queue_list.id,this.queue_list).then(res=>{
                    this.initCallTicket(res.data);
                }).catch(err=>{});
            }
        },
        timeCall(){
            let timerInterval
            this.$swal.fire({
                title: 'Llamando al cliente!',
                icon: 'info',
                html: 'Tiempo de espera al cliente  <b></b> segundos.',
                timer: URLS.TIMER_PROGREE_BAR_CALL,
                timerProgressBar: true,
                didOpen: () => {
                    this.$swal.showLoading()
                    const b = this.$swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = (this.$swal.getTimerLeft()/1000).toFixed(0);
                    }, 1000)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                this.confirmCall();

            })
        },
        confirmCall(){
            const swalWithBootstrapButtons =  this.$swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '¿Se presentó el cliente?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Continuar su atención!',
                cancelButtonText: 'No, Cliente ausente!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.startQueueList();
                } else if (
                    result.dismiss === this.$swal.DismissReason.cancel
                ) {
                    this.clienteAusente();
                }
            })
        },
        initCallTicket(ev){
            this.clearQueueList();
            if(ev.customer){
                this.queue_list.customer = ev.customer;
            }
            if (ev.user){
                this.queue_list.user = ev.user;
            }
            if (ev.ticket){
                this.queue_list.ticket = ev.ticket;
            }
            if(ev.desk){
                this.queue_list.desk = ev.desk
            }
            if (ev.processing_events){
                this.queue_list.processing_events = ev.processing_events;
            }
            if (ev.query_type_customer){
                this.queue_list.query_type_customer = ev.query_type_customer;
            }
            this.queue_list.id=ev.id;
            this.queue_list.ticket_id=ev.ticket_id;
            this.queue_list.user_id=ev.user_id;
            this.queue_list.desk_id=ev.desk_id;
            this.queue_list.query_type_customer_id=ev.query_type_customer_id;
            this.queue_list.description=ev.description;
            this.queue_list.guest_name=ev.guest_name;
            this.queue_list.guest_code=ev.guest_code;
            this.queue_list.address_ip=ev.address_ip;
            this.queue_list.sequence=ev.sequence;
            this.queue_list.processing=ev.processing;
            this.queue_list.start_dated=ev.start_dated;
            this.queue_list.end_dated=ev.end_dated;
            this.queue_list.read_at=ev.read_at;
            if(ev.processing_events.length === 2 ){
                this.timeCall();
            }


        },
        getInformacionUser(){
            axios.get(URLS.API_INFORMATION_USER+this.userauth.id).then(response=>{
                this.authInformation = response.data.data;

            }).catch(err=>{
                console.log(err);
            })
        }
    },
    mounted() {
        this.getInformacionUser();
        this.getQueryTypeCustomers();
    }

}
</script>

<style scoped>

</style>
