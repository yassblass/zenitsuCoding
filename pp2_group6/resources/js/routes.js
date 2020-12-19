import Axios from 'axios';
import Dashboard from './components/secretary/Dashboard.vue';
import Login from './components/secretary/Login.vue';
import Register from './components/secretary/Register.vue';
import ManageRequest from './components/secretary/ManageRequest.vue';
import Appointment from './components/secretary/Appointment.vue';
import setAvailability from './components/secretary/setAvailability.vue';
import manageAvailability from './components/secretary/ManageAvailability.vue';
import forgot from './components/secretary/ForgotPassword.vue';
import changePassword from './components/secretary/ChangePassword.vue';
import avatar from './components/secretary/Avatar.vue';



export default{
    mode:'history',
    // routes with all paths of the website and depending the path you looking for it will show to right vue component
    routes: [
        {
    
            path:"/secretary/dashboard",
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
            path:"/secretary/setAvailability",
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
            path:"/secretary/manageRequest",
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
            path:"/secretary/manageAppointment",
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
            path:"/secretary/login",
            component:Login,
            name:"login",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then((res)=>{

                    if(res.data == true){
                    next(false);
                    return next({name:"dashboard"});
                        
                    }else{
                        next();
                    }
                }).catch(()=>{
                    next()
                });
            }
        },
        {
            path:"/secretary/register",
            component:Register,
            name:"register",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/user').then((res)=>{
                
                    if(res.data.user_id < 1){
                        next(false);
                    return next({name:"login"});
                        
                    }
                    if(res.data.admin >= 1){
                        next();
                    }else{
                        next(false);
                        return next({name:"dashboard"});
    
                    }
                }).catch(()=>{

                    return next({name:"dashboard"});
                })
            }
            
        },
        {
    
            path:"/secretary/manageAvailability",
            component:manageAvailability,
            name:"manageAvailability",
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
    
            path:"/secretary/forgot/",
            component:forgot,
            name:"forgotPassword",
           
        },
        {
    
            path:"/secretary/forgot/:id",
            component:changePassword,
            name:"changePassword",
           
        },
        {
    
            path:"/secretary/avatar",
            component:avatar,
            name:"avatar",
            beforeEnter: (to, form, next) =>{
                Axios.get('/api/authenticated').then(()=>{
                    next();
                }).catch(()=>{
                    return next({name:"login"});
                })
            }
           
        },
       
    

    ]

}
