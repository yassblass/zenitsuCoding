<template>
<div>
    <navbar></navbar> 
    <div class="container">
        <h1 style="font-size: 40px;">Forgot password</h1>

        <input type="email" class="form-control" placeholder="Email" v-model="email">

       

        <button @click.prevent="check" type="submit" class="btn btn-danger" style="margin-left:80px;">send Email</button>

    </div>
    <div id="dbutton">
      <b-button
        @click="backbutton"
        class="button button-close"
        squared
        variant="outline-danger"
        >Back</b-button
      >
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
           backbutton() {
            this.$router.push({ name: "dashboard" });
            },
        
    }
    
}
</script>
<style>
#dbutton {
  margin-left: 660px;
}


</style>