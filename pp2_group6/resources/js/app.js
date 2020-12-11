import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import moment from 'moment';
require('./bootstrap');


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

// Instantiation
window.onload = function(e) {
    const app = new Vue({
        el: '#app'
    });
}