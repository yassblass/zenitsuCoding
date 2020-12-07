import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
require('./bootstrap');
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


// Declaration
window.Vue = require('vue');

// New component
Vue.component('appointment', require('./components/Appointment.vue').default);


// Instantiation
window.onload = function(e) {
    const app = new Vue({
        el: '#app'
    });
}
