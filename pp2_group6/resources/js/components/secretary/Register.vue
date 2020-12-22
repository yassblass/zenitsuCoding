<template>
<div>
    <navbar></navbar>
        <h1>Register</h1>
    <div id="page">
        


        <input placeholder="first name" class="form-control" type="text" v-model="form.firstName">

        <input placeholder="last name" class="form-control" type="text" v-model="form.lastName">

        <p v-if="errors" style="color : red; font-size:15px; text-align: center;"> {{errors.email}}</p>


        <input placeholder="Email" class="form-control" type="email" v-model="form.email">

        <p v-if="errors" style="color : red; font-size:15px; text-align: center;"> {{errors.password}}</p>


        <input placeholder="Password" class="form-control" type="password" v-model="form.password">

        <input placeholder="Confirm Password" class="form-control" type="password" v-model="form.password_confirmation">

        <p v-if="saved" style="color : green; font-size:25px;"> {{saved}}</p>


        <button @click.prevent="saveForm" type="submit" class="btn btn-danger">register</button>
    </div>
    <div id="button-alert">
      <alert></alert>
    </div>
    <div id="button-back">
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
            // object with all inputs to create a new user
            form:{
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                admin: 0,
                forgot_password: 25,
                password_confirmation:''
            },
            errors:null,
            saved:null,
        }
    },
    methods:{
        // method that send the form to controller for creating a new user
        saveForm(){
            axios.post('/api/register', this.form).then(() => {

                console.log('saved');
                this.saved = 'saved';
                 this.$router.push({ name: "dashboard" });


            }).catch((error) => {
                this.errors = error.response.data.errors;

            })
        },
         backbutton() {
            this.$router.push({ name: "dashboard" });
        },
    }
    
}
</script>

<style scoped>
#page{
    position: relative;
    width: 280px; 
    height:400px; 
    top: 0;
     margin-left: auto;
  margin-right: auto;
}
h1{
    text-align: center;
    font-size:50px; 
    font-family:Georgia;
}
input{
    margin-top: 18px
}
button{
    margin-top:18px;
    margin-left:90px;
}
#button-back {
  text-align: center;
}
#button-alert {
  float: right;
}
</style>