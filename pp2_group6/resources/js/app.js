require('./bootstrap');

//Declarations
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import store from './store/index.js'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

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
        store
    });
}