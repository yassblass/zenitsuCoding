<template>
  <div>
    <h4 class="text-center font-weight-bold">Appointments List</h4>
    <table class="table table-striped">
      <thead>
        <tr>

          <th scope="col">App_id</th>
          <th scope="col">Student_id</th>
          <th scope="col">Secretary_id</th>
          <th scope="col">Day</th>
          <th scope="col">startsAt</th>
          <th scope="col">subject</th>
          <th scope="col">status</th>

        </tr>
      </thead>
      <tbody>
        <tr
          v-for="appointment in appointments"
          :key="appointment.appointmentId"
        >
          <td>{{ appointment.appointmentId }}</td>
          <td>{{ appointment.student_id }}</td>
          <td>{{ appointment.user_id }}</td>
          <td>{{ appointment.date }}</td>
          <td>{{ appointment.startsAt }}</td>
          <td>{{ appointment.subject }}</td>
          <td>{{ appointment.status }}</td>
          <td>
            
            <button
              class="btn btn-danger"
              @click="deleteAppointment(appointment)"
            >
              <i style="color: grey" class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "Appointments",
  mounted() {
    this.$store.dispatch("fetchAppointments");
  },
  methods: {
    deleteAppointment(appointment) {
      this.$store.dispatch("deleteAppointment", appointment);
      window.location.reload();
    },
    deleteApp(appointment) {
      axios
        .delete("appointment/delete/" + appointment.appointmentId)
        .then((res) => {
          console.log(res.data);
        })
        .catch((error) => console.log(error));
    },
  },
  computed: {
    ...mapGetters(["appointments"]),
  },
};
</script>
