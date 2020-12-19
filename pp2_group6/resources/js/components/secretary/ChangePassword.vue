<template>
<div>
    <navbar></navbar> 
    <div class="container">
        <h1>Change Your Password</h1>

        <input type="password" class="form-control" placeholder="Password" v-model="password">
        <input type="password" class="form-control" placeholder="Confirm password" v-model="confirm_password">

       

        <button @click.prevent="check" type="submit" class="btn btn-danger">change Password</button>

    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            forgot_password: this.$route.params.id,
            password:'',
            confirm_password:'',
            id:'',
            
            

        }
    },
    methods:{
        change(){

            if(this.password == this.confirm_password){
            
            axios.post('/api/changePassword', {

                password: this.password,
                forgot_password : this.forgot_password,
                id : this.id,

            });

            }else{
                console.log("password not equal");
            }
          
        },

        
        check(){
            axios.get('/api/allUsers').then((res)=>{

                for(let a in res.data){

                

                    if(res.data[a].forgot_password == this.forgot_password){
                
                        console.log("user found");
                        this.id = res.data[a].user_id;

     
                        this.change();

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