require('./bootstrap');
window.moment = require('moment');
window.swal = require('sweetalert2') // added here
window.Vue = require('vue').default;

import 'datatables.net-bs4/js/dataTables.bootstrap4.min.js';
import 'bootstrap-select/dist/js/bootstrap-select.js';

import VueRouter from 'vue-router'
import router from './router';
import Vuex from 'vuex'
import store from './store'
//Importamos los roles del usuario que obviamente vamos a usar en varias  vistas 
import Rol from './mixins/Rol';
Vue.mixin(Rol);
//Efecto loading para carga 
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);
//FIN efectos loading para carga


Vue.use(VueRouter)
Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    router,
    store
});
