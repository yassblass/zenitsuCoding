import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueRouter from 'vue-router';

require('./bootstrap');
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueRouter);


// Declaration
window.Vue = require('vue');

// New component
Vue.component('appointment', require('./components/Appointment.vue').default);
Vue.component('cancelappointment', require('./components/Cancel.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);



// Instantiation
window.onload = function(e) {
    const app = new Vue({
        el: '#app'
    });
}
