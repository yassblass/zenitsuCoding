import Axios from 'axios';
import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import ManageRequest from './components/ManageRequest.vue';


export default{
    mode:'history',

    routes: [
        {
            path:"/dashboard",
            component:Dashboard,
            name:"dashboard",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    next();
                }).catch(()=>{
                    return next({name:"login"});
                })
            }
        },
        {
            path:"/setAvailability",
            component:Dashboard,
            name:"setAvailability",

        },
        {
            path:"/manageRequest",
            component:ManageRequest,
            name:"manageRequest",

        },
        {
            path:"/manageAppointment",
            component:Dashboard,
            name:"manageAppointment",

        },
        {
            path:"/login",
            component:Login,
            name:"login",

        },
        {
            path:"/register",
            component:Register,
            name:"register",

        },
    
    ]


}