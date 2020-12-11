<template>
        
    <div>
        <form action="" @submit="createAppointment(appointment)">
            <h4 class="text-center font-weight-bold">Create an appointment</h4>
            <div class="form-group">
                <input type="text" placeholder="firstName" v-model="appointment.firstName" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="lastName" v-model="appointment.lastName" class="form-control">
            </div>

            <div class="form-group">
                <label v-for="user in users" :key="user.user_id"> {{user.firstName + ' ' + user.lastName}}
                    <input  :value="user.user_id"  
                            :key="user.user_id" 
                            v-model="appointment.user_id"
                            type="radio" 
                            class="form-control"> 
                </label>
            </div>
            
            <div class="form-group">
                <input type="date" placeholder="date" v-model="appointment.date" class="form-control">
            </div>
            <div class="form-group">
                <input type="datetime-local" placeholder="startsAt" v-model="appointment.startsAt" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="subject" v-model="appointment.subject" class="form-control">
            </div>
        
            <div class="form-group">
                <button :disabled="!isValid" class="btn btn-block btn-primary" @click.prevent="createAppointment(appointment)">Submit</button>
            </div>
        </form>

        <div>
                <button  class="btn btn-block btn-primary" @click="GenerateRandomString">Send Token</button>
                <pre> {{ output }} </pre>
        </div>

    </div>
</template>
<script>
import { mapGetters } from "vuex";
    export default {
        name: "CreateAppointment",
            data() {
                return {
                    appointment: {
                        //student_id: '',
                        //user_id: '',
                        date: '',
                        startsAt: '',
                        subject: '',
                        //status: '',
                        //cancelToken: '',
                    },
                    user: {
                        firstName: "",
                        lastName:""
                    },
                    output: '',
                }
            },
        methods: {
            createAppointment(appointment) {
                this.$store.dispatch('createAppointment', appointment)
                window.location.reload();
            },
            GenerateRandomString() {
                var crypto = require('crypto');
                let currentObj = this;
                var token = crypto.randomBytes(15).toString('hex');

                axios.get('appointment/accept/' + token)
                .then(function (response) {
                    currentObj.output = response.data;
                }).catch(function (error) {
                    currentObj.output = error;
                });
            }
        },
        computed: {
            isValid() {
                return this.appointment.firstName !== '' && this.appointment.lastName !== ''
            },
            ...mapGetters([
                'users'
            ])
        }
    }
</script>