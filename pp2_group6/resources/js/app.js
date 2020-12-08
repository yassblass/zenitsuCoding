'use strict'





require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from './components/Dashboard.vue';


//Vue.component('dashboard', require('./components/Dashboard.vue').default);

const routes = [
    {
        path:"/jaa",
        component:Dashboard
    }

];

const router = new VueRouter({routes});

window.onload = function () {
    const app = new Vue({
        el: '#app',
        router:router,
        
    });
}


