<template>
    <section class="py-1 text-center">
        <div class="row py-lg-1">
            <div class="col-lg-10 col-md-8 mx-auto">
                <div class="image">
                    <img src="img/icon.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <h5 class="display-4 fw-light text-bold">{{ name }} </h5>
            </div>
        </div>
    </section>
</template>

<script>
import {URLS} from "../Config/ApiUrl";
export default {
    name: "foviColaComponent",
    data(){
        return {
            name:URLS.APP_NAME
        }
    }
}
</script>

<style scoped>

</style>
