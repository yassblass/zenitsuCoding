<template>
    <div class="container" style="width: 450px; height:400px; margin-top: 70px">
            
           
        <h1 style="text-align: center; font-size:50px; font-family:Georgia Pro">Welcome</h1>
        <img class="center" src="https://st3.depositphotos.com/4111759/13425/v/380/depositphotos_134255626-stock-illustration-avatar-male-profile-gray-person.jpg"  style="width: 100px; height:100px; border-radius:50%; ">
        <p>{{nom +" "+ prenom}}</p>
        <router-link to="/setAvailability"><button type="button" class="btn btn-danger" style="margin-top:10px; margin-left: 10px; width:185px; " >Set availability</button></router-link>
        <router-link to="/manageAppointment"><button type="button" class="btn btn-danger" style="margin-top:10px;  margin-left: 25px;width:185px;" >Manage appointments</button></router-link>
        <router-link to="/manageRequest"><button type="button" class="btn btn-danger" style="margin-top:30px;  margin-left: 120px; width:185px;" >Manage request</button></router-link>

          
        
            
    </div>
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data: function() {
         return {
             //--> get from db
          nom: 'Karen',
          prenom: 'Sec'
        }
    }
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
