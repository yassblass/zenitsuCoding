'use strict'
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import moment from 'moment';

import VueRouter from 'vue-router';


require('./bootstrap');
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueRouter);


Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
// Declaration
window.Vue = require('vue');

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});

// New component
Vue.component('manage', require('./components/ManageRequest.vue').default);
Vue.component('calendar', require('./components/setAvailability.vue').default);

Vue.use(VueRouter);

import routes from './routes'
Vue.component('appointment', require('./components/Appointment.vue').default);
Vue.component('cancelappointment', require('./components/Cancel.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);



// Instantiation
window.onload = function () {
    const app = new Vue({
        el: '#app',
        router:new VueRouter(routes)
        
    });

}


