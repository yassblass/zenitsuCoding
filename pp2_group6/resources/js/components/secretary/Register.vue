<template>
<div>
    <navbar></navbar>

    <div class="register">
        <h1>Register</h1>
        <!--<span v-if="errors.name">{{errors.name[0]}}</span>-->
        
        <input placeholder="first name" type="text" v-model="form.firstName">

        <input placeholder="last name" type="text" v-model="form.lastName">

        <input placeholder="Email" type="email" v-model="form.email">

        <input placeholder="Password" type="password" v-model="form.password">

        <input placeholder="Confirm Password" type="password" v-model="form.password_confirmation">

        <button @click.prevent="saveForm" type="submit">register</button>
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
                password_confirmation:''
            },
            errors:[]
        }
    },
    methods:{
        // method that send the form to controller for creating a new user
        saveForm(){
            axios.post('/api/register', this.form).then(() => {

                console.log('saved');

            }).catch((error) => {
                this.errors = error.response.data.errors;

            })
        }
    }
    
}
</script>