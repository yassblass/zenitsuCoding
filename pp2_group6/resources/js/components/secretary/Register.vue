<template>
<div class="text-center">
    <navbar></navbar>

    <b-container style="text-align:left; position: absolute; top: 0; left:0; margin-top: 80px; margin-left: 25px;">
      <div>
        <b-button @click="backbutton" class="button button-close" variant="danger">Back</b-button>
      </div>
    </b-container> 
    <br /> <br />
        <h1>Register</h1> <br /><br />
    <div style="width: 200px;" class="mx-auto">
        <input placeholder="First name" class="form-control" type="text" v-model="form.firstName">
           <br /> 
        <input placeholder="Last name" class="form-control" type="text" v-model="form.lastName">

        <p v-if="errors" style="color : red; font-size:15px; text-align: center;"> {{errors.email}}</p>
<br />
        <input placeholder="Email" class="form-control" type="email" v-model="form.email">

        <p v-if="errors" style="color : red; font-size:15px; text-align: center;"> {{errors.password}}</p>

<br />
        <input placeholder="Password" class="form-control" type="password" v-model="form.password">
<br />
        <input placeholder="Confirm Password" class="form-control" type="password" v-model="form.password_confirmation">
<br />
        <p v-if="saved" style="color : green; font-size:25px;"> {{saved}}</p>

<br />
        <button @click.prevent="saveForm" type="submit" class="btn btn-danger">Register</button>
    </div>
    <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
            <div>
                <alert></alert>
            </div>
        </b-container>

        <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
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

</style>