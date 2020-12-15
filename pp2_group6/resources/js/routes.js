import Axios from 'axios';
import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import ManageRequest from './components/ManageRequest.vue';
import Appointment from './components/Appointment.vue';
import setAvailability from './components/setAvailability.vue';
import CreateAppointments from './components/CreateAppointments.vue';


export default{
    mode:'history',
    // routes with all paths of the website and depending the path you looking for it will show to right vue component
    routes: [
        {
    
            path:"/",
            component:Dashboard,
            name:"dashboard",
            //checking if you are logged in and if not it redirect you to the login page
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
            component:setAvailability,
            name:"setAvailability",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    next();
                }).catch(()=>{
                    return next({name:"login"});
                })
            }

        },
        {
            path:"/manageRequest",
            component:ManageRequest,
            name:"manageRequest",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    next();
                }).catch(()=>{
                    return next({name:"login"});
                })
            }

        },
        {
            path:"/manageAppointment",
            component:Appointment,
            name:"manageAppointment",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    next();
                }).catch(()=>{
                    return next({name:"login"});
                })
            }
        },
        {
            path:"/login",
            component:Login,
            name:"login",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    
                }).catch(()=>{
                    next();
                })
            }

        },
        {
            path:"/register",
            component:Register,
            name:"register",
        },
        {
            path:"/createAppointment",
            component:CreateAppointments,
            name:"createAppointment",
        },
    
    ]


}