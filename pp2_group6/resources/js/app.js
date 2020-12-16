'use strict'
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import VueRouter from 'vue-router';


require('./bootstrap');
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);


// New component
Vue.component('manage', require('./components/ManageRequest.vue').default);
Vue.component('calendar', require('./components/secretary/setAvailability.vue').default);


import routes from './routes'
Vue.component('appointment', require('./components/Appointment.vue').default);
Vue.component('cancelappointment', require('./components/Cancel.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);

Vue.component('navbar', require('./components/Navbar.vue').default);

// Instantiation
window.onload = function () {
    const app = new Vue({
        el: '#app',
        router:new VueRouter(routes)
        
    });

}
