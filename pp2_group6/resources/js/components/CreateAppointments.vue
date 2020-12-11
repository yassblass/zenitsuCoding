<template>
        
    <div>
        <form action="" @submit="createAppointment(appointment)">
            <h2>Create an appointment</h2>
            <div>
                <input type="text" placeholder="firstName" v-model="appointment.firstName">
            </div>
            <div>
                <input type="text" placeholder="lastName" v-model="appointment.lastName">
            </div>

            <div class="input-div">
                <label class="input-label" v-for="user in users" :key="user.user_id"> {{user.firstName + ' ' + user.lastName}}
                    <input  :value="user.user_id"  
                            :key="user.user_id" 
                            v-model="appointment.user_id"
                            type="radio" class="input-radio"> 
                </label>
            </div>
            
            <div>
                <input type="date" placeholder="date" v-model="appointment.date">
            </div>

            <div>
                <input type="datetime-local" placeholder="startsAt" v-model="appointment.startsAt">
            </div>
            
            <div class="input-div">
                <label class="input-label" v-for="subject in subjects" :key="subject.subjectId"> {{subject.name + ' (' + subject.duration + 'min.)' }}
                    <input  :value="subject.name"  
                            :key="subject.subjectId" 
                            v-model="appointment.subject"
                            type="radio" class="input-radio"> 
                </label>
            </div>
        
            <div>
                <button :disabled="!isValid" @click.prevent="createAppointment(appointment)">Submit</button>
            </div>
        </form>

        <div>
                <button @click="GenerateRandomString">Send Token</button>
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
                        //subject: '',
                        //status: '',
                        //cancelToken: '',
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
                'users',
                'subjects'
            ])
        }
    }
</script>
<style>
.input-div {
    margin: 10px;
}

.input-div .input-radio{
    opacity: 0;
    position: fixed;
    width: 0;
}

.input-div .input-label  {
    display: inline-block;
    background-color: rgb(184, 0, 0);
    padding: 10px 20px;
    font-family: sans-serif, Arial;
    font-size: 16px;
    color: white;
    border: 2px solid rgb(95, 0, 0);
    border-radius: 4px; 
    margin-right: 10px;
} 

.input-div .input-label:hover {
  border-color: red;
  background-color: rgb(221, 136, 136)
}

.input-div .input-label:checked{
    background-color: rgb(20, 4, 255);
    color: rgb(0, 255, 21);
}
</style>