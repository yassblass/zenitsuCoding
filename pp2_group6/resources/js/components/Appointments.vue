<template>
        <div>
            <h4 class="text-center font-weight-bold">Appointments</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Secretary</th>
                    <th scope="col">Day</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="appointment in appointments" :key=appointment.id>
                    <td>{{appointment.firstName}}</td>
                    <td>{{appointment.lastName}}</td>
                    <td>{{appointment.secretary}}</td>
                    <td>{{appointment.day}}</td>
                    <td>
                        <button class="btn btn-danger" @click="deleteAppointment(appointment)"><i style="color:grey" class="fa fa-trash"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Appointments",
        mounted() {
            this.$store.dispatch('fetchAppointments')
        },
        methods: {
            deleteAppointment(appointment) {
                this.$store.dispatch('deleteAppointment', appointment)
            }
        },
        computed: {
            ...mapGetters([
                'appointments'
            ])
        }
    }
</script>
