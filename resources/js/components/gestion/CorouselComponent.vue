<template>

    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item" v-for="carousel in carousels" :class="carousel.class_default" style="height: 97vh">
                <img :src="carousel.path" class="d-block w-100 img-fluid" alt="alt">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>
</template>

<script>
import {URLS} from "../../Config/ApiUrl";

export default {
    name: "CorouselComponent",
    data(){
        return{
            carousels:[],
        }
    },
    methods:{
        getAllCarousels(){
            axios.get(URLS.API_CAROUSEL_GET).then(data=>{
                this.carousels = data.data;
            }).catch(err=>{

            })
        },
    },
    mounted() {
      /*  $('.carousel').carousel(
            {
                interval: 20000
            }
        );*/

        this.getAllCarousels();
    }
}
</script>

<style scoped>

</style>
