<template>
  <div>
    <b-navbar
      variant="danger"
      type="dark"
      style="margin-bottom: 10%; margin-bottom: 0px"
    >
      <b-navbar-brand href="#">
        <img
          src="/images/ehb_logo_white_horizontal.png"
          class="d-inline-block align-top"
          style="width: 100px; height: 25px"
        />
      </b-navbar-brand>
    </b-navbar>
    <b-jumbotron style="height: 100%">
      <h2>{{ check }}</h2>

      <template #lead>
        You can cancel the appointment below. If all the
        information is correct just exit the page.
      </template>
      <!-- Show appointment data -->
      <p>
        With: <strong>{{ secretaryName }}</strong>
      </p>
      <p>
        Took by : <strong>{{ studentName }}</strong>
      </p>
      <p>
        Date: <strong>{{ date }}</strong>
      </p>
      <p>
        Starts At: <strong>{{ startsAt }}</strong>
      </p>
      <p>
        Subject: <strong>{{ subject }}</strong>
      </p>
      <p>
        Status: <strong>{{ status }}</strong>
      </p>

      <!-- Show update page button -->
      <!-- Call to cancel appointment method button-->

      <!-- Show update page button -->
      <!-- Call to cancel appointment method button-->
      <b-button
        v-if="status != 'refused'"
        type="button"
        @click="cancelAppointment(appointmentId)"
      >
        Cancel Appointment
      </b-button>
    </b-jumbotron>
    <footer
      style="
        height: 50px;
        background-color: red;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
      "
    >
      <p style="padding-top: 13px; color: white">
        &copy; Copyright 2020 | PP2 - Group 6
      </p>
    </footer>
  </div>
</template>

<script>


export default {
  
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
          console.log("cancel response:", response.data);
          if (response.data === 1) {
            //If delete query returned true, alert the user & redirect to home page.
            alert("Appointment has beend canceled successfulyl!");
            window.location.href = "/";
          } else {
            //Appointment doesn't exist.
            console.log(
              "Error. Maybe the appoint you are trying to cancel doesn't exist anymore ?"
            );
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>