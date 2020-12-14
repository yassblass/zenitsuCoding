require('./bootstrap');

//Declarations
import Vue from 'vue';
import Vuex from 'vuex'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueRouter from 'vue-router';
import store from "./store/index.js"

//
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueRouter);
Vue.use(Vuex)


//Student components
Vue.component('appointments', require('./components/student/Appointments.vue').default);
Vue.component('createAppointments', require('./components/student/CreateAppointments.vue').default);
Vue.component('cancelPage', require('./components/student/cancelPage.vue').default);
Vue.component('updatePage', require('./components/student/updatePage.vue').default);

//Secretary components
Vue.component('appointment', require('./components/secretary/Appointment.vue').default);
Vue.component('cancelappointment', require('./components/secretary/CancelAppointment.vue').default);
Vue.component('alert', require('./components/secretary/Alert.vue').default);

Vue.component('managerequest', require('./components/secretary/ManageRequest.vue').default);
Vue.component('setavailability', require('./components/secretary/setAvailability.vue').default);


window.onload = function(e) {
    const app = new Vue({
        el: '#app',
        store
    });
}

