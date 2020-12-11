import Dashboard from './components/Dashboard.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

export default{
    mode:'history',

    routes: [
        {
            path:"/Dashboard",
            component:Dashboard
        },
        {
            path:"/setAvailability",
            component:Dashboard
        },
        {
            path:"/manageRequest",
            component:Dashboard
        },
        {
            path:"/manageAppointment",
            component:Dashboard
        },
        {
            path:"/login",
            component:Login
        },
        {
            path:"/register",
            component:Register
        },
    
    ]


}