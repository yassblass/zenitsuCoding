<template>
  <div>
    <div>
      <!-- Message: Says if appointment is found -->
      <h1>{{ check }}</h1>

      <!-- Show appointment data -->
      <p>With: {{ secretaryName }}</p>
      <p>Took by : {{ studentName }}</p>
      <p>Date: {{ date }}</p>
      <p>Starts At: {{ startsAt }}</p>
      <p>Subject: {{ subject }}</p>
      <p>Status: {{ status }}</p>

      <!-- Show update page button -->
      <button
        type="button"
        class="btn btn-block btn-primary"
        @click="showUpdateComponent()"
      >
        Update Appointment Request
      </button>
      <!-- Call to cancel appointment method button-->
      <button
        type="button"
        class="btn btn-block btn-primary"
        @click="cancelAppointment(appointmentId)"
      >
        Cancel Appointment
      </button>
    </div>
  </div>
</template>

<script>
import updatePage from "./updatePage.vue";

export default {
  components: { updatePage },
  props: [
    "appointmentId",
    "check",
    "studentName",
    "secretaryName",
    "date",
    "startsAt",
    "subject",
    "status",
  ],
  data() {
    return {
      appointment: {
        appointmentId: "",
        student_id: "",
        user_id: "",
        date: "",
        startsAt: "",
        subject: "",
      },
    };
  },
  methods: {
    cancelAppointment(appointmentId) {
      //Declaring needed variables
      let thisResponse = "";
      let currentObject = this;

      //Axios call to delete an appointment from DB.
      axios
        .delete("/appointment/cancel/" + appointmentId)
        .then(function (response) {
          //Set local response variable equal to axios response.
        console.log("cancel response:" , response.data)
        if ((response.data ===  1)) {
        //If delete query returned true, alert the user & redirect to home page.
        alert("Appointment has beend canceled successfulyl!");
        window.location.href = "/";
      } else {
        //Appointment doesn't exist.
        console.log("Error. Maybe the appoint you are trying to cancel doesn't exist anymore ?");
      }
        })
        .catch(function (error) {
          console.log(error);
        });
      
    },
  },
};
</script>