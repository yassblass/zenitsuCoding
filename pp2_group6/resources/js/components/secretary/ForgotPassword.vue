<template>
<div>
    <navbar></navbar> 
    <div class="container">
        <h1>Forgot password</h1>

        <input type="email" class="form-control" placeholder="Email" v-model="email">

       

        <button @click.prevent="check" type="submit" class="btn btn-danger">send Email</button>

    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            email:'',
            forgot:'',
            firstName:'',
            
            

        }
    },
    methods:{
        sendEmail(){
            axios.post('/api/forgot',  {

                    email: this.email,
                    forgot: this.forgot,
                    firstName: this.firstName,

                }).then(()=>{
    

            }).catch(()=>{
                console.log("functie email error");
            })
        },

        check(){
            axios.get('/api/allUsers').then((res)=>{

                for(let a in res.data){

                

                    if(res.data[a].email == this.email){
                    

                        this.forgot = res.data[a].forgot_password;
                        this.firstName = res.data[a].firstName;

                        

                        
                        this.sendEmail(this.forgot);
                    }
                
                }

                this.$router.push({name:"login"});


            }).catch(()=>{
                console.log("functie check error");
            })
        },
        
    }
    
}
</script>