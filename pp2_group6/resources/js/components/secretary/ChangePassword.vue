<template>
<div>
    <navbar></navbar> 
    <div class="container">
        <h1 style="font-size: 40px;">Change Your Password</h1>

        <p v-if="bool == true" style="color : green; font-size:15px;"> Password changed</p>

        <p v-if="bool == false" style="color : red; font-size:15px;"> password not correct</p>

        <input type="password" class="form-control" placeholder="Password" v-model="password">
        <input type="password" class="form-control" style="margin-bottom:15px;" placeholder="Confirm password" v-model="confirm_password">

       

        <button @click.prevent="check" type="submit" class="btn btn-danger" style="margin-left:50px;">change Password</button>

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
            bool:null,
            
            

        }
    },
    methods:{

        // functie that change the password
        change(){

            if(this.password == this.confirm_password){

                this.bool=true;
            
                axios.post('/api/changePassword', {

                password: this.password,
                forgot_password : this.forgot_password,
                id : this.id,

                });

                this.$router.push({name:"login"});

            }else{
                console.log("password not equal");
                this.bool = false;
            }
          
        },

        //functie that check if the id is real (www.xxx/forgot/id)
        check(){
            axios.get('/api/allUsers').then((res)=>{

                for(let a in res.data){

                

                    if(res.data[a].forgot_password == this.forgot_password){
                
                        console.log("user found");
                        this.id = res.data[a].user_id;

     
                        this.change();

                  


                    }
                
                }



            }).catch(()=>{
                console.log("functie check error");
            })
        },
        
    }

        
    
    
}
</script>
<style scoped>
.container{
    position: relative;
    width: 280px; 
    height:400px; 
    margin-top: 50px;
}
h1{
    text-align: center; 
    font-size:50px; 
    font-family:Georgia
}

input{
    margin-top: 18px;
}

button{
    margin-top:18px;
    margin-left:90px;
}


</style>