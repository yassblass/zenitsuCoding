<template>
        <div>
            <h4 class="text-center font-weight-bold">Appointments</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">App_id</th>
                    <th scope="col">Student_id</th>
                    <th scope="col">User_id</th>
                    <th scope="col">Day</th>
                    <th scope="col">startsAt</th>
                    <th scope="col">subject</th>
                    <th scope="col">status</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="appointment in appointments" :key="appointment.appointmentId">
                    <td>{{appointment.appointmentId}}</td>
                    <td>{{appointment.student_id}}</td>
                    <td>{{appointment.user_id}}</td>
                    <td>{{appointment.date}}</td>
                    <td>{{appointment.startsAt}}</td>
                    <td>{{appointment.subject}}</td>
                    <td>{{appointment.status}}</td>
                    <td>
                        <button class="btn btn-danger" @click="deleteAppointment(appointment)"><i style="color:grey" class="fa fa-trash"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>

            <h4 class="text-center font-weight-bold">Users</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">user_id</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.user_id">
                    <td>{{user.user_id}}</td>
                    <td>{{user.firstName}}</td>
                    <td>{{user.lastName}}</td>
                    <td>{{user.email}}</td>
                </tr>
                </tbody>
            </table>


            <h4 class="text-center font-weight-bold">Subjects</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">subjectId</th>
                    <th scope="col">Name</th>
                    <th scope="col">Duration(in minutes)</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="subject in subjects" :key="subject.subjectId">
                    <td>{{subject.subjectId}}</td>
                    <td>{{subject.name}}</td>
                    <td>{{subject.duration}}</td>
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
            this.$store.dispatch('fetchUsers')
            this.$store.dispatch('fetchSubjects')
        },
        methods: {
            deleteAppointment(appointment) {
                this.$store.dispatch('deleteAppointment', appointment)
                 window.location.reload();
            }
        },
        computed: {
            ...mapGetters([
                'appointments',
                'users',
                'subjects'
            ])
        }
    }
</script>
