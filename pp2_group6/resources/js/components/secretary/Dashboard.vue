<template>
<div v-if="user">
    
    <navbar></navbar> 
    
    <div class="container" style="width: 450px; height:400px; margin-top: 70px">
            
          
        <h1 style="text-align: center; font-size:50px; font-family:Georgia Pro">Welcome</h1>
        <img class="center" :src="src"  style="width: 100px; height:100px; border-radius:50%; ">
        <p>{{user.firstName+" "+user.lastName+ " "}}</p>
        <router-link to="/setAvailability"><button type="button" class="btn btn-danger" style="margin-top:10px; margin-left: 10px; width:185px; " >Set availability</button></router-link>
        <router-link to="/manageAvailability"><button type="button" class="btn btn-danger" style="margin-top:10px;  margin-left: 25px;width:185px;" >Manage availability</button></router-link>
        <router-link to="/manageRequest"><button type="button" class="btn btn-danger" style="margin-top:30px;  margin-left: 10px; width:185px;" >Manage request</button></router-link>
        <router-link to="/manageAppointment"><button type="button" class="btn btn-danger" style="margin-top:30px;  margin-left: 25px; width:185px;" >Manage appointments</button></router-link>

            
    </div>
</div>   
</template>

<script>
    export default {
        data(){
             return {
                user:null,
                src:"/uploads/avatars/",
            
            }
        },
        // when component is mountend get user who is logged in to show on page
        mounted() {
            axios.get('/api/user').then((res)=>{
                this.user = res.data;
                this.src= this.src+res.data.avatar;
               
            })
            
        },
        
    }
    

    
   
</script>

<style>
.container{
    position: relative;

}

.center{
    display: block;
    margin-left: auto;
    margin-right: auto;
}

p{
    text-align: center;
    font-family:Georgia;
    font-size:30px;
}


</style>
