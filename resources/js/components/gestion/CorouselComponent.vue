<template>

    <div id="carousel" class="carousel slide" data-ride="carousel" >

        <div class="carousel-inner" >

            <div class="carousel-item" v-for="carousel in carousels" :class="carousel.class_default" style="height: 97vh" v-if="carousel.type_player!=='video/mp4'">
                <img :src="urlBase+'/carousels/load/'+carousel.id" class="d-block w-100 img-fluid" alt="alt">
            </div>

            <div class="carousel-item" :class="carousel.class_default" v-else>
                <video class="img-responsive center-block" style="width:100%;height: 90vh;" :id="'video_'+carousel.id">
                    <source :src="urlBase+'/carousels/load/'+carousel.id" type="video/mp4">
                </video>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" href="#carousel" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" href="#carousel" data-slide="next">
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
            urlBase:null,
        }
    },
    methods:{

        getAllCarousels(){
            axios.get(URLS.API_CAROUSEL_GET).then(data=>{
                this.carousels = data.data;
                console.log("base url: "+URLS.URL_BASE)
                this.urlBase = URLS.URL_BASE;
            }).catch(err=>{

            })
        },
        initTiempo(time){
            $('.carousel').carousel({interval: time } );
        }
    },
    mounted() {

        this.getAllCarousels();
        let me = this;
        $('.carousel').on('slid.bs.carousel', function (e) {
            let elemento = $('#carousel .carousel-item.active video').first();
            if (elemento.prop("tagName") === "VIDEO") {
                elemento.get(0).play();
                $('#carousel').carousel('pause');
                var v = document.getElementById(elemento.attr("id"));
                v.addEventListener("timeupdate",function(ev){
                    var tTotal = document.getElementById(elemento.attr("id")).duration;
                    var val = parseFloat(tTotal) - parseFloat(v.currentTime);
                    if (val === 0){
                        $('#carousel').carousel('next')
                    }
                },true);

            }
        });

        $('.carousel').bind('slide.bs.carousel', function (e) {
            let elemento = $('#carousel .carousel-item.active video').first();
            if (elemento.prop("tagName") === "VIDEO") {
                elemento.get(0).pause();
                me.initTiempo(20000)
            }
        });


    }
}




</script>

