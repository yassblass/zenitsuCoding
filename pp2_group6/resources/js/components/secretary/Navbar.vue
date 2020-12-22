<template>
    <div>

       <div class="collapse" id="navbarToggleExternalContent">
                <div class="bg-dark p-4">
                    <div class="flex">
                        <router-link v-if="user.user_id <= 0" class="mr-4" to="/secretary/login"><span style="color:white">Login</span></router-link>
                        <router-link v-if="user.admin == true" to="/secretary/register">
                        <button class="btn btn-light" style="margin-left: 20px">Register</button>
                        </router-link>  
                        <router-link  to="/secretary/avatar">
                        <button class="btn btn-light" style="margin-left: 20px">Avatar</button>
                        </router-link> 
                        <button @click.prevent="logout" class="btn btn-light" style="margin-left: 20px">Logout</button>
                    </div>
                </div>
        </div>

        <nav class="navbar navbar-dark bg-dark ">
            <div class="container-fluid">
                <button v-if="user.user_id > 0" class="navbar-toggler" id="navButton" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>  
                </button>

                <img  src="/images/logo_ehb.jpg" style="width: 50px; height:50px; ">
            </div>             
        </nav>

    </div>
</template>

<script>
export default {
    data(){
        return{
            user:'',
            
        }
    },
    methods:{
        // method to logout and then redirect to login
        logout(){
            axios.post('/api/logout').then(()=>{
                this.$router.push({name:"login"});
                });
            }
        },
    // when component is mountend get user who is logged in to show on page
    mounted() {
        axios.get('/api/user').then((res)=>{
            this.user = res.data;
        })
            
    },
        
        
    
}
</script>

<style scoped>
img{

    margin-left:auto;
    margin-right:auto;
}
</style>
