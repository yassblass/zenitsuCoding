require('./bootstrap');


// Declaration
window.Vue = require('vue');

// New component
Vue.component('face', require('./components/Face.vue').default);

// Instantiation
window.onload = function(e) {
    const app = new Vue({
        el: '#app'
    });
}