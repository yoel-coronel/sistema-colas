export const URLS = {
     URL_BASE: document.querySelector('meta[name="urlBase"]').getAttribute('content'),
     APP_NAME:document.querySelector('meta[name="nameApp"]').getAttribute('content'),
     TIMER_PROGREE_BAR_CALL:document.querySelector('meta[name="timerProgressBarCall"]').getAttribute('content'),
     SPEAK_ENABLE:document.querySelector('meta[name="speak_enable"]').getAttribute('content'),
     SPEAK_TIME_RELOAD:document.querySelector('meta[name="speak_time_reload"]').getAttribute('content'),
     API_TICKET_GET:'/api/tickets',
     API_TICKET_POST:'/api/tickets',
     API_TICKET_GET_ID:'/api/tickets/', //PARAMETRO ID
     API_TICKET_PUT_ID:'/api/tickets/', //PARAMETRO ID
     API_TICKET_DELETE_ID:'/api/tickets/', //PARAMETRO ID
     API_PROCESA_GET:'/api/procesa',
     API_PROCESA_POST:'/api/procesa',
     API_PROCESA_LLAMADA_PUT:'/llamar-cliente/',//PARAMETRO DEL   ID  QUEUELIST
     API_PROCESA_START_PUT:'/start-cliente/',//PARAMETRO DEL ID  QUEUELIST
     API_PROCESA_ATENCION_ALL_PUT:'/procesa-atencion-all/',////ID  QUEUELIST
     API_PROCESA_CLIENTE_AUSENTE_PUT:'/cliente-ausente-cliente/',//ID  QUEUELIST
     API_TICKETS_GET:'/lista-tickets-por-atender/',//parametro user_id
     API_PROCESA_MIS_ATENCIONES_GET:'/lista-mis-atenciones/',//parametro user_id
     API_PROCESA_FIND_QUEUELIST:'/find-queue-list/',////parametro id queueList
     API_INFORMATION_USER:'/informacion-user/', //PARAMETRO ID
     API_SEARCH_ORACLE_PERSONA:'/buscar-persona/',//ENVIA EL CIP O NRO DOC.
     API_DESKS_GET:'/desk-all',

    API_ROLES_GET_PAGE:'/roles',
    API_ROLES_PUT:'/roles/',//PARAMETRO ID
    API_ROLES_POST:'/roles',
    API_ROLES_DELETE:'/roles/',//PARAMETRO ID
    API_ROLES_GET:'/roles-all',

    API_MODULO_GET_PAGE:'/modulos',
    API_MODULO_PUT:'/modulos/',//PARAMETRO ID
    API_MODULO_POST:'/modulos',
    API_MODULO_DELETE:'/modulos/',//PARAMETRO ID
    API_MODULO_GET:'/modulos-all',

    API_QUERYTYPECUSTOMERS_GET_PAGE:'/query_type_customers',
    API_QUERYTYPECUSTOMERS_PUT:'/query_type_customers/',//PARAMETRO ID
    API_QUERYTYPECUSTOMERS_POST:'/query_type_customers',
    API_QUERYTYPECUSTOMERS_DELETE:'/query_type_customers/',//PARAMETRO ID
    API_QUERYTYPECUSTOMERS_GET:'/query_type_customers_all',

    API_DESK_GET_PAGE:'/desks',
    API_DESK_PUT:'/desks/',//PARAMETRO ID
    API_DESK_POST:'/desks',
    API_DESK_DELETE:'/desks/',//PARAMETRO ID
    API_DESK_GET:'/desks-all',

    API_TICKET_CRUD_GET_PAGE:'/tickets',
    API_TICKET_CRUD_PUT:'/tickets/',//PARAMETRO ID
    API_TICKET_CRUD_POST:'/tickets',
    API_TICKET_CRUD_DELETE:'/tickets/',//PARAMETRO ID

    API_TICKETERA_CRUD_GET_PAGE:'/ticketeras',
    API_TICKETERA_CRUD_PUT:'/ticketeras/',//PARAMETRO ID
    API_TICKETERA_CRUD_POST:'/ticketeras',
    API_TICKETERA_CRUD_DELETE:'/ticketeras/',//PARAMETRO ID


    API_USERS_GET_PAGE:'/users',
    API_USERS_PUT:'/users/',//PARAMETRO ID
    API_USERS_POST:'/users',
    API_USERS_DELETE:'/users/',//PARAMETRO ID

    API_CAROUSEL_GET:"/api/carousels",

    API_CAROUSEL_GET_PAGE:'/carousels',
    API_CAROUSEL_PUT:'/carousels/',//PARAMETRO ID
    API_CAROUSEL_POST:'/carousels',
    API_CAROUSEL_DELETE:'/carousels/',//PARAMETRO ID

    //REPORTES
    API_QUEUELIST_REPORT_GET:'/report-queue-list',

    //DASHBOARD
    API_ADMIN1_GET:'/admin1',

}

