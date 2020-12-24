<template>
<div>
  <div class="text-center">
    <navbar></navbar>
    <br />
    <br />
    <h1>{{ title }}</h1>

    <b-container style="text-align:left; position: absolute; top: 0; left:0; margin-top: 80px; margin-left: 25px;">
      <div>
        <b-button @click="backbutton" class="button button-close" variant="danger">Back</b-button>
      </div>
    </b-container> 

    <b-container> 
      <div>
        <table class="table">
          <thead>
            <th scope="col">Date and time</th>
            <th scope="col">Name</th>
            <th scope="col">Subject</th>
          </thead>
          <tr v-for="appointment in appointments" :key="appointment.appointmentId">
            <th>{{ appointment.date }} {{ appointment.startsAt }}</th>
            <th>{{ appointment.firstName }} {{ appointment.lastName }}</th>
            <th>{{ appointment.subject }}</th>
            <b-button style="margin-right: 5px;" variant="primary" @click="buttonAcceptAppointment(appointment.appointmentId)">Accept</b-button>
              <b-button variant="danger" @click="buttonRefuseAppointment(appointment.appointmentId)">Refuse</b-button>
          </tr> 
      
          <!-- <pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->
        </table>
      </div>
    </b-container>



    
   

    <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
        <div>
            <alert></alert>
        </div>
    </b-container>

    <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
    </div>
  </div>





  <!-- <div id="template">
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
  </div> -->
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

</style>