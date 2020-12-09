import Dashboard from './components/Dashboard.vue';

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
    
    ]


}