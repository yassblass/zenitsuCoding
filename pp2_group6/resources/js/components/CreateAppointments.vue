<template>
    <div>
        <h2>Create an appointment</h2>
        <b-form @submit="createAppointment(appointment)">
            <b-form-group label="Insert your first name">
                <b-form-input type="text" placeholder="First name" v-model="appointment.firstName"></b-form-input>
            </b-form-group>

            <b-form-group label="Insert your last name">
                <b-form-input type="text" placeholder="Last name" v-model="appointment.lastName"></b-form-input>
            </b-form-group>

            <b-form-group label="Choose between available secretary">
                <b-form-radio-group
                    v-model="appointment.user_id"
                    buttons
                    button-variant="danger">

                    <template v-for="user in users">
                    <b-form-radio :value="user.user_id" :key="user.user_id">
                        {{ user.firstName + ' ' + user.lastName }}
                    </b-form-radio>
                    </template>
                </b-form-radio-group>
            </b-form-group>

            <b-form-group label="Choose a date">
                <b-form-input type="date" placeholder="Date" v-model="appointment.date"></b-form-input>
            </b-form-group>

            <b-form-group label="Choose a date and time">
                <b-form-input type="datetime-local" placeholder="Time" v-model="appointment.startsAt"></b-form-input>
            </b-form-group>

            <b-form-group label="Choose a subject">
                <b-form-radio-group
                    v-model="appointment.subject"
                    buttons
                    button-variant="danger">

                    <template v-for="subject in subjects">
                    <b-form-radio :value="subject.name" :key="subject.subjectId">
                        {{ subject.name }}
                    </b-form-radio>
                    </template>
                </b-form-radio-group>
            </b-form-group>

            <b-button @click.prevent="createAppointment(appointment)">Make appointment</b-button>
        </b-form>
    </div> 
</template>
<script>
import { mapGetters } from "vuex";
    export default {
        name: "CreateAppointment",
            data() {
                return {
                    appointment: {
                        date: '',
                        startsAt: ''
                    },
                    user: {
                        firstName: "",
                        lastName:""
                    },
                    subject: {
                        name: "",
                        duration: ""
                    },
                    output: '',
                }
            },
        methods: {
            createAppointment(appointment) {
                this.$store.dispatch('createAppointment', appointment)
                //window.location.reload();
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
                'users',
                'subjects'
            ])
        }
    }
</script>
