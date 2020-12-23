require('./bootstrap');
import routes from './routes'
import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueRouter from 'vue-router';
import store from './store/index.js'


Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.use(VueRouter);


Vue.component('alert', require('./components/secretary/Alert.vue').default);
Vue.component('navbar', require('./components/secretary/Navbar.vue').default);
Vue.component('footer', require('./components/secretary/Footer.vue').defautl);

//Student components
Vue.component('createAppointments', require('./components/student/CreateAppointments.vue').default);
Vue.component('cancelPage', require('./components/student/cancelPage.vue').default);
Vue.component('checkEmail', require('./components/student/checkEmail.vue').default);
Vue.component('showAvailabilities', require('./components/student/ShowAvailabilities.vue').default);
Vue.component('showSubjects', require('./components/student/ShowSubjects.vue').default);
Vue.component('modifyRequest', require('./components/student/ModifyRequest.vue').default);
Vue.component('verificationCode', require('./components/student/VerificationCode.vue').default);
Vue.component('captcha', require('./components/student/Captcha.vue').default);
Vue.component('requestSummary', require('./components/student/RequestSummary.vue').default);
Vue.component('showEndMessage', require('./components/student/ShowEndMessage.vue').default);




window.onload = function(e) {
    const app = new Vue({
        el: '#app',
        store,
        router:new VueRouter(routes)
    });
}
