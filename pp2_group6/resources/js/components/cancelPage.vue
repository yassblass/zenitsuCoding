<template>
    <div>
        <h1> {{ check }}</h1>
        <p>ID: {{ id }} </p>
        <p>Name: {{ name}} </p>
        <p>Secretary: {{ secretary}} </p>
        <p>Token: {{ token }} </p>
    

    <pre> {{ output }} </pre>
    <button class="btn btn-block btn-primary" @click="cancelAppointment">Cancel Appointment </button>

    </div>
</template>

<script>
export default {
    props : [
        'check',
        'token',
        'id',
        'name',
        'secretary',
    ],
    data() {
        return{
            output : '',
        }
        
    },
    
    methods:  {
        cancelAppointment() {
            let currentObject = this;
            axios.delete('/appointment/token/appointments/' + this.$props.id)
            .then(function (response) {
                    currentObject.output = response.data;
                }).catch(function (error) {
                    //
                });
        }

    }
}
</script>