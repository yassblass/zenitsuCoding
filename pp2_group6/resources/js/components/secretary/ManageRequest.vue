<template>
  <div id="template">
    <navbar></navbar>
    <h1>{{ title }}</h1>
    <br />
    <div id="table">
      <table class="table table-stripped table-bordered">
        <tbody>
          <div class="d-flex justify-content-center">
            <strong v-if="!appointments.length && componentMounted"
              >No Requests yet!
            </strong>
          </div>
          <tr
            v-for="appointment in appointments"
            :key="appointment.appointmentId"
          >
            <th>{{ appointment.date }} {{ appointment.startsAt }}</th>
            <th>{{ appointment.firstName }} {{ appointment.lastName }}</th>
            <th>{{ appointment.subject }}</th>
            <th>
              <b-button
                variant="primary"
                @click="buttonAcceptAppointment(appointment.appointmentId)"
                >Accept</b-button
              >
              <b-button
                variant="danger"
                @click="buttonRefuseAppointment(appointment.appointmentId)"
                >Refuse</b-button
              >
            </th>
          </tr>
        </tbody>
      </table>
    </div>
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
      title: "Manage Requests",
      appointments: {},
      appointmentAccepted: "",
      componentMounted: false,
    };
  },
  // use function called created to get the appointments in pending
  created() {
    axios
      .get("/api/appointmentListPending")
      .then((res) => {
        this.appointments = res.data;
      })
      .catch((error) => console.log(error));
  },
  mounted() {
    this.componentMounted = true;
  },
  methods: {
    backbutton() {
      this.$router.push({ name: "dashboard" });
    },
    // update the status to confirmed

    buttonAcceptAppointment(id) {
      axios
        .post("/api/acceptAppointment/" + id)
        .then(
          (response) => console.log(JSON.stringify(response.data) + " Done"),
          window.location.reload()
        )
        .catch((error) => console.log(error + " Failed"));
    },
    // update the status to refused

    buttonRefuseAppointment(id) {
      axios
        .post("/api/refuseAppointment/" + id)
        .then(
          (response) => console.log(JSON.stringify(response.data) + " Done"),
          window.location.reload()
        )
        .catch((error) => console.log(error + " Failed"));
    },
  },
};
</script>
<style scoped>
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
#button-back {
  margin-left: 60px;
  text-align: center;
}
#button-alert {
  float: right;
}
h1 {
  text-align: center;
  font-size: 50px;
  font-family: Georgia;
}
</style>