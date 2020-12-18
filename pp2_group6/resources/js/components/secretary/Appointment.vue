<template>
  <div id="template">
    <navbar></navbar>
    <div id="titel">
      <h1>
        {{ title }}
        <b-button pill id="iCall" variant="primary">Add/Import iCal</b-button>
      </h1>
    </div>
    <div id="table">
      <div v-if="cancelIsClicked">
        <textarea name="reason" placeholder="Describe the reason why you cancel the appointment" id="reason" cols="125" rows="3" value="description" v-model="description">
          Reason why you cancel
        </textarea>
      </div>
      <div v-if="cancelIsClicked">
        <b-button id="confirm" type="button" @click="cancelAppointmentSubmit()">
          Confirm cancel
        </b-button>
      </div>

      <table class="table table-stripped table-bordered">
        <tr
          v-for="appointment in appointments"
          :key="appointment.appointmentId"
        >
          <th>{{ appointment.date }} {{ appointment.startsAt }}</th>
          <th>{{ appointment.firstName }} {{ appointment.lastName }}</th>
          <th>{{ appointment.subject }}</th>
          <b-button
            variant="danger"
            @click="showTextArea(appointment.appointmentId)"
            >Cancel</b-button
          >
        </tr>
        <!--<pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->
      </table>
    </div>
    <br />

    <div id="button-alert">
      <alert></alert>
    </div>
    <div id="button-back">
      <b-button
        @click="backbutton"
        class="button button-close"
        squared
        variant="outline-danger"
        >Back</b-button
      >
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "Manage Appointments",
      appointments: "",
      description: "",
      output: "",
      id: "",
      cancelIsClicked: false,
      currentAppointmentId: "",
    };
  },
  mounted() {
    axios.get("/api/user").then((res) => {
      this.user = res.data;
    });
    console.log("Component mounted.");
  },
  created() {
    axios
      .get("/api/appointmentListConfirmed")
      .then((response) => (this.appointments = response.data))
      .catch((error) => console.log(error));
  },
  methods: {
    showTextArea(newAppointmentId) {
      this.currentAppointmentId = newAppointmentId;
      this.cancelIsClicked = true;
    },
    backbutton() {
      this.$router.push({ name: "dashboard" });
    },
    cancelAppointmentSubmit() {
      let currentObj = this;
      let id = this.currentAppointmentId;
      axios
        .post("/api/cancelAppointment/" + id, {
          description: this.description,
        })
        .then(function (response) {
          currentObj.output = response.data;
          
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      this.cancelIsClicked = false;
      window.location.reload();
    },
  },
};
</script>

<style>
#confirm{
  float: right;
}
#template {
  background-color: #bababa;
}
#table {
  height: 80%;
  width: 75%;
  background-color: white;
  border: 2px solid black;
  border-radius: 12px;
  margin-left: auto;
  margin-right: auto;
  overflow: auto;
  height: 400px;
}
#buttons {
  margin: 0;
}
#button-back {
  text-align: center;
}
#button-alert {
  float: right;
}
</style>



