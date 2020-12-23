<template>
<div>
    <navbar :onLoginPage= true ></navbar> 
    <div class="container">
        <h1>Login</h1>

        <p v-if="errors" style="color : red; font-size:15px; text-align: center;"> password or email not correct</p>
        <input type="email" class="form-control" placeholder="Email" v-model="form.email">

        
        <input type="password" class="form-control" style="margin-bottom:10px; " placeholder="Password" v-model="form.password">
       

        <button @click.prevent="loginUser" type="submit" class="btn btn-danger" style="margin-bottom:20px; " >Log in</button>

        <router-link to="/secretary/forgot/" id="fpwd">Forgot password?</router-link>
        <button @click="logout"> LOG OUT</button>
    </div>

    <footer></footer>
    
</div>
</template>

<script>
export default {
    data(){
        return{
            //object with email and password to send to controller for checking
            form:{
                email:'',
                password:''
            },
            errors:null,
            userIsLoggedIn: false,
            check : '',

        }
    },
    mounted () {
        
    },
    methods:{
        //method send object to controller and if ok send to dashboard
        loginUser(){
            axios.post('/api/login', this.form).then(res =>{
                    //console.log('login res:', res)
                    this.$router.push({name:"dashboard"});
                
                
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        logout() {
      axios.post("/api/logout").then(() => {
        this.check = "LOGGED OUT";
      });
    },
    }
    
}
</script>

<style scoped>
.container{
    position: relative;
    width: 280px; 
    height:400px; 
    margin-top: 100px;
}

h1{
    text-align: center; 
    font-size:50px; 
    font-family:Georgia
}

input{
    margin-top: 18px
}

button{
    margin-top:18px;
    margin-left:90px;
}

#fpwd{
    margin-left:65px;
    color: red;
}
</style>