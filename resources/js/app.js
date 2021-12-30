require('./bootstrap');
import Vue from "vue";

window.Vue = require('vue').default;

import Notifications from 'vue-notification';
Vue.use(Notifications)

// ES6 Modules or TypeScript
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
Vue.prototype.$swal = Swal;

import vSelect from 'vue-select'
Vue.component('v-select', vSelect);

import InfiniteLoading from 'vue-infinite-loading';
Vue.use(InfiniteLoading);

import Chart from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';

Vue.prototype.$chartjs = Chart;

/*const chart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: {
        onClick: (e) => {
            const canvasPosition = getRelativePosition(e, chart);

            // Substitute the appropriate scale IDs
            const dataX = chart.scales.x.getValueForPixel(canvasPosition.x);
            const dataY = chart.scales.y.getValueForPixel(canvasPosition.y);
        }
    }
});*/

import excel from 'vue-excel-export'
Vue.use(excel)

// Default SortableJS
import Sortable from 'sortablejs';
Vue.prototype.$sortable = Sortable

import moment from 'moment'
Vue.prototype.moment = moment

import './core/coreApp';
import store from './core/store';

Vue.component('InfiniteLoading', require('vue-infinite-loading'));

Vue.filter('FechaCompleta', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY')
    }
});
Vue.filter('horaMinuto', function(value) {
    if (value) {
        return moment(String(value)).format('hh:mm')
    }
});


//import {mapState, mapMutations} from 'vuex';
Vue.mixin({
    data(){
      return {
          role:{},
          modulo:{},
          usuario:{},
          queue_list:{},
          desk:{},
          ticket:{},
          ticketera:{},
          queryTypeCustomer:{},
          carousel_data:{},
      }
    },
    created() {
       this.clearModalRole();
       this.clearQueueList();
       this.clearUser();
       this.clearTicket();
       this.clearTicketeras();
       this.cleartQueryTypeCustomer();
       this.clearCarousel();
    },
    methods: {
        clearCarousel(){
          this.carousel_data = {
              'id':null,
              'name':null,
              'tiempo':null,
              'path':null,
              'type_player':null,
              'class_default':null,
              'is_active':true
          };
        },
        cleartQueryTypeCustomer(){
            this.queryTypeCustomer = {
                'id':null,
                'name':null,
                'is_active':true
            }
        },
        clearTicketeras() {
            this.ticketera = {
                'id': null,
                'modulo_id': null,
                'name_host': null,
                'password_host': 1,
                'name_user_host': null,
                'name_ticket': null,
                'ip_ticket': null,
                'level': 1,
            }
        },
        clearTicket(){
            this.ticket = {
                'id':null,
                'name':null,
                'level':1,
                'description':null,
                'serial':null,
                'class_default':null,
                'is_active':true,
                'path':'',
            }

        },
        clearDesk(){
            this.desk = {
                'id':null,
                'name':null,
                'serial':null,
                'is_active':true
            }
        },
        clearModulo(){
            this.modulo = {
              'id':null,
              'name':null,
              'is_active':true
            };
        },
        clearUser(){
            this.usuario = {
                'id':null,
                'name':null,
                'email':null,
                'full_name':null,
                'is_active':true,
                'is_admin':false,
                'desk_id':null,
                'tickets':[],
                'roles':[],
            };
        },
        clearQueueList(){
            this.queue_list = {
                'id': null,
                'ticket_id': null,
                'user_id': null,
                'desk_id': null,
                'query_type_customer_id':1,
                'description': null,
                'guest_name': null,
                'guest_code': null,
                'address_ip': null,
                'sequence': null,
                'processing': null,
                'start_dated': null,
                'end_dated': null,
                'read_at': null,
                'user': {
                    'id': null,
                    'name': null,
                    'full_name': null,
                    'desk_id': null,
                },
                'ticket': {
                    'id': null,
                    'name': null,
                    'level': null,
                    'description': null,
                    'path': null,
                    'serial': null,
                    'class_default': null
                },
                'desk': {
                    'id': null,
                    'name': null,
                    'serial': null,
                    'is_active': null,
                },
                'customer': {
                    'id': null,
                    'full_surname': null,
                    'full_name': null,
                    'guest_fachada':null,
                    'telephone':null,
                    'iden_pers_per': null,
                    'document_number': null,
                    'cip_number': null,
                    'is_active': null,
                },
                'processing_events': [],
                'query_type_customer':{
                    'id':null,
                    'name':null,
                }
                };
         },
        clearModalRole(){
            this.role = {
                'id':null,
                'name':null,
                'kay_name':null,
                'is_active':true,
                'class_default':'success',
            };
        },
        NotityEvent(data=[],type='success'){
            this.$notify({
                group: 'notification',
                title: data.title,
                text: data.description,
                type:type,
                duration:3000,
                speed: 1000
            });
        },

    }
});

const app = new Vue({
    el: '#app',
    store,
    data() {
        return {

        }
    },
    methods:{

    },
    mounted() {

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

    }

});
