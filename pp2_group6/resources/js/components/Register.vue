<template>
    <div>
        <h1>Register</h1>
        <!--<span v-if="errors.name">{{errors.name[0]}}</span>-->
        
        <input placeholder="first name" type="text" v-model="form.firstName">

        <input placeholder="last name" type="text" v-model="form.lastName">

        <input placeholder="Email" type="email" v-model="form.email">

        <input placeholder="Password" type="password" v-model="form.password">

        <input placeholder="Confirm Password" type="password" v-model="form.password_confirmation">

        <button @click.prevent="saveForm" type="submit">register</button>
    </div>
</template>

<script>
export default {
    data(){
        return{
            form:{
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                password_confirmation:''
            },
            errors:[]
        }
    },
    methods:{
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