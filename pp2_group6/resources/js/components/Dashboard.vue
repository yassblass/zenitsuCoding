<template>
   <div class="container" style="border: solid black 2px; width: 400px; height:400px; margin-top: 70px">
            
            <h1>Welcome</h1>
            <img src="https://st3.depositphotos.com/4111759/13425/v/380/depositphotos_134255626-stock-illustration-avatar-male-profile-gray-person.jpg" style="width: 150px; height:150px; border-radius:50%; ">
           
            <router-link to="/jaa"><button type="button" class="btn btn-danger" style="margin-top:10px; " >Set availability</button></router-link>
     
           <a href=""> <button type="button" class="btn btn-danger" style="margin-top:10px" >Manage appointments</button></a>
           <a href=""> <button type="button" class="btn btn-danger" style="margin-top:10px" >Manage request</button></a>

          
        
            
        </div>
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }


    
   
</script>
