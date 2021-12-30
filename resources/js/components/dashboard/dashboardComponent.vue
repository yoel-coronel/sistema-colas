<template>
    <main>
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row" v-if="totales">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3> 100 <sup style="font-size: 20px">%</sup></h3>
                            <p>Total Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_registros }}</i>
                        </div>
                      <!--  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_por_atender)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Por Atener</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_por_atender }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_atendidos)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Atendidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_atendidos }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_siendo_atendidos)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Atendiendo</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_siendo_atendidos }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_ausentes)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Ausentes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_ausentes }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_siendo_llamados)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Llamando</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_siendo_llamados }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ ((parseInt(totales.total_liberados)/parseInt(totales.total_registros))*100).toFixed(0) }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Liberados </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">{{ totales.total_liberados }}</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-white bg-orange">
                        <div class="inner">
                            <h3>{{ 0 }} <sup style="font-size: 20px">%</sup> </h3>
                            <p>Otros </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie">0</i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

        <canvas id="myChart" ></canvas>
    </main>
</template>

<script>

import {URLS} from "../../Config/ApiUrl";

export default {
    name: "dashboardComponent",
    data(){
      return{
          totales:{},
      }
    },
    methods:{
      listTotales(){
            axios.get(URLS.API_ADMIN1_GET,{
                params:{

                }
            }).then(res=>{
                this.totales = res.data;
                this.initGrafico();
            }).catch(err=>{
                console.log(err)
            })
      },
        initGrafico(){
            const ctx = document.getElementById('myChart').getContext('2d');
            let me = this;
            let data = [
                parseInt(this.totales.total_registros),
                parseInt(this.totales.total_por_atender),
                parseInt(this.totales.total_atendidos),
                parseInt(this.totales.total_siendo_atendidos),
                parseInt(this.totales.total_ausentes),
                parseInt(this.totales.total_siendo_llamados),
                parseInt(this.totales.total_liberados)];
            const myChart = new this.$chartjs(ctx, {
                type: 'line',
                data: {
                    labels: ['Total Tikets', 'Por Atener', 'Atendidos', 'Atendiendo', 'Ausentes', 'Llamando','Liberados'],
                    datasets: [{
                        label: '# ticktes',
                        data: data,

                        backgroundColor: [
                            'rgba(34, 20, 17, 0.2)',
                            'rgba(223, 217, 216, 0.2)',
                            'rgba(17, 88, 80, 0.2)',
                            'rgba(6, 123, 177, 0.2)',
                            'rgba(173, 0, 13, 0.2)',
                            'rgba(232, 252, 150, 0.2)',
                            'rgba(129, 119, 119, 0.2)'
                        ],
                        borderColor: [
                            'rgba(34, 20, 17, 1)',
                            'rgba(223, 217, 216, 1)',
                            'rgba(17, 88, 80, 1)',
                            'rgba(6, 123, 177, 1)',
                            'rgba(173, 0, 13, 1)',
                            'rgba(232, 252, 150, 1)',
                            'rgba(129, 119, 119, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    }
                }
               /* options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }*/
            });
        }
    },
    mounted() {
        this.listTotales();


    }
}
</script>

<style scoped>

</style>
