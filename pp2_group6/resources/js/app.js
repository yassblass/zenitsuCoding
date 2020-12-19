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

import routes from './routes'
Vue.component('alert', require('./components/secretary/Alert.vue').default);
Vue.component('navbar', require('./components/secretary/Navbar.vue').default);

//Student components
Vue.component('createAppointments', require('./components/student/CreateAppointments.vue').default);
Vue.component('cancelPage', require('./components/student/cancelPage.vue').default);
Vue.component('updatePage', require('./components/student/updatePage.vue').default);
Vue.component('checkEmail', require('./components/student/checkEmail.vue').default);
Vue.component('showAvailabilities', require('./components/student/ShowAvailabilities.vue').default);
Vue.component('showSubjects', require('./components/student/ShowSubjects.vue').default);
Vue.component('modifyRequest', require('./components/student/ModifyRequest.vue').default);
Vue.component('verificationCode', require('./components/student/VerificationCode.vue').default);
Vue.component('captcha', require('./components/student/Captcha.vue').default);





window.onload = function(e) {
    const app = new Vue({
        el: '#app',
        store,
        router:new VueRouter(routes)
    });
}
