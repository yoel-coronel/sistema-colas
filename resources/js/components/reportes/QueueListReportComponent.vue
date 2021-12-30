<template>
    <main>
        <div class="row">
            <div class="col-md-6 text-right"></div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Fecha Inicial</label>
                            <input type="date" v-model="fecha1" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Fecha Inicial</label>
                            <input type="date" v-model="fecha2" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-outline-success mt-4" @click="getAllData"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <export-excel
                                class="btn btn-success mt-4"
                                :data="arrayQueueLists"
                                :fields="json_fields"
                                worksheet="Atenciones"
                                name="atenciones.xls">
                               <i class="fa fa-download"></i>
                            </export-excel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Oficina</th>
                        <th>Módulo</th>
                        <th>Colaborador</th>
                        <th>Cliente</th>
                        <th>Tipo Consulta</th>
                        <th>Descripción</th>
                        <th>Fecha creado</th>
                        <th>Hora creado</th>
                        <th>Hora llamado</th>
                        <th>Hora Incio</th>
                        <th>Hora Final</th>
                        <th>Tiempo de atención</th>
                        <th>Tiempo espera</th>
                        <th>Proceso</th>
                        <th>Fase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in arrayQueueLists" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.ticket_name }}</td>
                        <td>{{ item.desk_name }}</td>
                        <td>{{ item.user_full_name }}</td>
                        <td>{{ item.customer_full_name }}</td>
                        <td>{{ item.query_type_customer }}</td>
                        <td>{{ item.description }}</td>
                        <td>{{ item.created_date }}</td>
                        <td>{{ item.created_time }}</td>
                        <td>{{ item.read_at }}</td>
                        <td>{{ item.start_dated_at }}</td>
                        <td>{{ item.end_dated_at }}</td>
                        <td>{{ item.total_attention_time }}</td>
                        <td>{{ item.waiting_time_has_to_be_attended }}</td>
                        <td>
                            <span class="badge badge-info" v-for="(e,idx) in item.processing_events" :key="idx">
                                {{ e.name }}
                                <span class="badge badge-warning">{{ e.created_at }}</span>
                            </span>
                        </td>
                        <td> <span class="badge badge-success">{{ item.processing_name }}</span></td>
                    </tr>
                </tbody>
            </table>
            <infinite-loading @infinite="infiniteHandler">
                <div slot="no-more">No hay mas resultados</div>
                <div slot="no-results">No hay resultados</div>
            </infinite-loading>
        </div>
    </main>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";

export default {
    name: "QueueListReportComponent",
    data(){
        return{
            $fecha_ini:null,
            $fecha_fin:null,
            arrayQueueLists:[],
            fecha1: new Date(),
            fecha2:new Date(),
            page:1,
            json_fields:{
                'id':'id',
                'Oficina':'ticket_name',
                'Módulo':'desk_name',
                'Colaborador':'user_full_name',
                'Cliente':'customer_full_name',
                'CIP':'customer_cip',
                'DNI':'customer_dni',
                'CEL':'customer_tel',
                'Tipo Consulta':'query_type_customer',
                'Descripción':'description',
                'Fecha creado':'created_date',
                'Hora creado':'created_time',
                'Hora llamado':'read_at',
                'Hora Incio':'start_dated_at',
                'Hora Final':'end_dated_at',
                'Tiempo de atención':'total_attention_time',
                'Tiempo espera':'waiting_time_has_to_be_attended',
                'Fase':'processing_name',
                },
        }
    },
    created() {

    },
    methods:{
        getAllData(){
            axios.get(URLS.API_QUEUELIST_REPORT_GET,{params: {
                page: this.page, fecha1:this.fecha1, fecha2:this.fecha2,search_val:1,
            },
            }).then(data=>{
                this.arrayQueueLists = data.data.data;
            }).catch(err=>{
                console.log(err)
            })
        },
        infiniteHandler($state) {
            axios.get(URLS.API_QUEUELIST_REPORT_GET, {
                params: {
                    page: this.page,
                    fecha1:this.fecha1,
                    fecha2:this.fecha2,
                    search_val:0,
                },
            }).then(({ data }) => {
                if (data.data.length) {
                    this.page += 1;
                    this.arrayQueueLists.push(...data.data);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },
    },
    mounted() {
       // this.getAllData();
    }
}
</script>

<style scoped>

</style>
