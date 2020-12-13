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
Vue.component('appointment', require('./components/secretary/Appointment.vue').default);
Vue.component('cancelappointment', require('./components/secretary/CancelAppointment.vue').default);
Vue.component('alert', require('./components/secretary/Alert.vue').default);

Vue.component('managerequest', require('./components/secretary/ManageRequest.vue').default);
Vue.component('setavailability', require('./components/secretary/setAvailability.vue').default);




// Instantiation
window.onload = function(e) {
    const app = new Vue({
        el: '#app'
    });
}
