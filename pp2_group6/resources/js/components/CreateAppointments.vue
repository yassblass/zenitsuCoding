<template>
  <div>
    <form action="" @submit="makeRequest(appointment)">
      <h4 class="text-center font-weight-bold">Create an Appointment Request</h4>
      <div class="form-group">
        <input
          type="text"
          placeholder="student_id"
          v-model="appointment.student_id"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <input
          type="text"
          placeholder="user_id"
          v-model="appointment.user_id"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <input
          type="text"
          placeholder="date"
          v-model="appointment.date"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <input
          type="text"
          placeholder="startsAt"
          v-model="appointment.startsAt"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <input
          type="text"
          placeholder="subject"
          v-model="appointment.subject"
          class="form-control"
        />
      </div>

      <div class="form-group">
        <button
          :disabled="!isValid"
          class="btn btn-block btn-primary"
          @click.prevent="makeRequest(appointment)"
        >
          Make Appointment
        </button>
      </div>
      
    </form>

    <br/>
    <hr>
    <br/>

    <h4 class="text-center font-weight-bold">Confirm an Appointment</h4>
    <div class="form-group">
        <input
          type="text"
          placeholder="Appointment ID"
          v-model="appointmentId"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <button
          class="btn btn-block btn-primary"
          @click.prevent="confirmAppointment(appointmentId)"
        >
          Confirm Appointment
        </button>
      </div>


    <br/>
    <hr>
    <br/>

    <h4 class="text-center font-weight-bold">Show an Appointment</h4>
    <div class="form-group">
        <input
          type="text"
          placeholder="Token"
          v-model="token"
          class="form-control"
        />
      </div>
      <div class="form-group">
        <button
          class="btn btn-block btn-primary"
          @click="showAppointment(token)"
        >
          Show Appointment
        </button>
      </div>


    <div>
      <pre> {{ output }} </pre>
    </div>
  </div>
</template>
<script>
export default {
  name: "CreateAppointment",
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
      output: "",
      appointmentId: "",
      token : "",
    };
  },
  methods: {
    createAppointment(appointment) {
      this.$store.dispatch("createAppointment", appointment);
    },
    makeRequest(appointment) {
      //Declare needed Variables
      var crypto = require("crypto");
      let currentObj = this;
      //Generate unique token
      var token = crypto.randomBytes(15).toString("hex");

      //Axios call [POST]
      axios
        .post("appointment/accept/", {
          appointment: currentObj.appointment,
          token: token,
        })
        .then(function (response) {
          currentObj.output = response.data;
        })
        .catch(function (error) {
          currentObj.output = error;
        });
        window.location.reload();
    },

    updateAppointment(appointment) {
      //Declare needed Variables
      let currentObj = this;

      //Axios call [POST]
      axios
        .post("appointment/update/", {
          appointment: currentObj.appointment,
        })
        .then(function (response) {
          currentObj.output = response.data;
        })
        .catch(function (error) {
          currentObj.output = error;
        });
        window.location.reload();
    },
    confirmAppointment(appointmentId) {
      //Declare needed Variables
      let currentObj = this;

      //Axios call [POST]
      axios
        .get("appointment/confirm/" + appointmentId)
        .then(function (response) {
          //This.output gets filled with the response data.
          currentObj.output = response.data;
        })
        .catch(function (error) {
          //This output gets filled with error message.
          currentObj.output = error;
        });
        window.location.reload();
    },

    showAppointment(token) {
      //Declare needed Variables
      let currentObj = this;

      window.location.href = "appointment/token/" + token;
    },
  },
  computed: {
    isValid() {
      return (
        this.appointment.firstName !== "" && this.appointment.lastName !== ""
      );
    },
  },
};
</script>