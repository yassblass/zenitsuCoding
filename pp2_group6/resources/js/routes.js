import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

export default{
    mode:'history',

    routes: [
        {
            path:"/dashboard",
            component:Dashboard,
            name:"dashboard",
        },
        {
            path:"/setAvailability",
            component:Dashboard,
            name:"setAvailability",

        },
        {
            path:"/manageRequest",
            component:Dashboard,
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