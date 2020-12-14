<template>
    <div class="container">
        <h1>Login</h1>

        <input type="email" class="form-control" placeholder="Email" v-model="form.email">
        
        <!--<input placeholder="Email" type="email" v-model="form.email">-->

        
        <input type="password" class="form-control" placeholder="Password" v-model="form.password">
       <!-- <input placeholder="Password" type="password" v-model="form.password">-->

        <button @click.prevent="loginUser" type="submit" class="btn btn-danger">Log in</button>

    </div>
</template>

<script>
export default {
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            errors:[]

        }
    },
    methods:{
        loginUser(){
            axios.post('/api/login', this.form).then(()=>{
                this.$router.push({name:"dashboard"});
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        }
    }
    
}
</script>

<style>
.container{
    position: relative;
    width: 280px; 
    height:400px; 
    margin-top: 100px
}

h1{
    text-align: center; 
    font-size:50px; 
    font-family:Georgia
}

input{
    margin-top: 18px
}


</style>