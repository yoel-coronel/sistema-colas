import Vue from 'vue';

import Toasted from 'vue-toasted';
Vue.use(Toasted);



Vue.component('ticket-component', require('../components/ticketComponent.vue').default);
Vue.component('ventana-component', require('../components/VentanaTicketComponent.vue').default);

Vue.component('atencion-component', require('../components/gestion/AtencionComponent.vue').default);
Vue.component('list-tickts-component', require('../components/gestion/ListTicketsComponent.vue').default);
Vue.component('mis-tickts-component', require('../components/gestion/MisAtencionesComponent.vue').default);


Vue.component('modulo-impresiones-component', require('../components/configuraciones/ModuloImpresion.vue').default);
Vue.component('oficinas-component', require('../components/configuraciones/Oficinas.vue').default);
Vue.component('posiciones-component', require('../components/configuraciones/Posiciones.vue').default);
Vue.component('tickets-component', require('../components/configuraciones/Ticketera.vue').default);
Vue.component('videos-component', require('../components/configuraciones/Videos.vue').default);
Vue.component('query-type-customer-component', require('../components/configuraciones/QueryTypeCustomers.vue').default);


Vue.component('fovicola-component', require('../components/foviColaComponent.vue').default);

Vue.component('role-scroll-component', require('../components/accesos/RoleScrollComponent.vue').default);
Vue.component('user-component', require('../components/accesos/UserScrollComponent.vue').default);

//Reportes
Vue.component('report-queue-list', require('../components/reportes/QueueListReportComponent.vue').default);
Vue.component('dashboard-component', require('../components/dashboard/dashboardComponent.vue').default);

