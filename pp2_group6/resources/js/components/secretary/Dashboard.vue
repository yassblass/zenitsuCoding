<template>
<div v-if="user">
    <navbar></navbar> 
    
    <!-- <div class="container" style="width: 450px; height:400px; margin-top: 70px"> -->
    <b-container style="text-align:center; margin-top:50px">

        

        <h1 style="text-align: center; font-size:50px; font-family:Georgia Pro">My Dashboard</h1> <br />
        <img :src="src"  style="width: 100px; height:100px; border-radius:50%; ">
        <h3>{{user.firstName+" "+user.lastName+ " "}}</h3>

        <br />

        <router-link to="/secretary/setAvailability"><button type="button" class="btn btn-danger" style="margin-top:10px;width:185px;" >Set availability</button></router-link> <br />
        <router-link to="/secretary/manageAvailability"><button type="button" class="btn btn-danger" style="margin-top:10px;width:185px;" >Manage availability</button></router-link> <br />
        <router-link to="/secretary/manageRequest"><button type="button" class="btn btn-danger" style="margin-top:10px;width:185px;">Manage request</button></router-link> <br /> 
        <router-link to="/secretary/manageAppointment"><button type="button" class="btn btn-danger" style="margin-top:10px;width:185px;" >Manage appointments</button></router-link> <br />
    <!-- </div> -->
        <br />
    </b-container>

    <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
    <div>
      <alert></alert>
    </div>

    </b-container>

    <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
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

<style scoped>

</style>
