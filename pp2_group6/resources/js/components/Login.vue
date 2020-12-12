<template>
    <div>
        <h1>Login</h1>
        <input placeholder="Email" type="email" v-model="form.email">
        <input placeholder="Password" type="password" v-model="form.password">

        <button @click.prevent="loginUser" type="submit">Log in</button>

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