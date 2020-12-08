<template>
        <form action="" @submit="createAppointment(appointment)">
            <h4 class="text-center font-weight-bold">Create an appointment</h4>
            <div class="form-group">
                <input type="text" placeholder="First name" v-model="appointment.firstName" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Last name" v-model="appointment.lastName" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Secretary" v-model="appointment.secretary" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Day" v-model="appointment.day" class="form-control">
            </div>

            <input type="hidden" name="_token" :value="csrf">

            <div class="form-group">
                <button :disabled="!isValid" class="btn btn-block btn-primary" @click.prevent="createAppointment(appointment)">Submit</button>
            </div>
        </form>
</template>
<script>
    export default {
        name: "CreateAppointment",
            data() {
                return {
                    csrf: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    appointment: {
                        firstName: '',
                        lastName: '',
                        secretary: '',
                        day: '',
                    }
                }
            },
        methods: {
            createAppointment(appointment) {
                this.$store.dispatch('createAppointment', appointment)
            }
        },
        computed: {
            isValid() {
                return this.appointment.firstName !== '' && this.appointment.lastName !== ''
            }
        }
    }
</script>