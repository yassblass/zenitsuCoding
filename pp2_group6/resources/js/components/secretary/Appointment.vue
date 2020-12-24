<template>
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
      
  
      <br /> <br />
      
      <div v-if="cancelIsClicked">
        <textarea name="reason" placeholder="Describe the reason why you cancel the appointment" id="reason" cols="125" rows="3" value="description" v-model="description">
          Reason why you cancel
        </textarea>
      </div>
      <div v-if="cancelIsClicked">
        <b-button id="confirm" type="button" @click="cancelAppointmentSubmit()">
          Confirm cancel
        </b-button> <br />
    </div>

        
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
            <b-button variant="danger" @click="showTextArea(appointment.appointmentId)">Cancel</b-button>
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
      componentMounted: false,
    };
  },
  mounted() {
    axios.get("/api/user").then((res) => {
      this.user = res.data;
    });
    //console.log("Component mounted.");
    this.componentMounted = true;
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

<style scoped>
</style>



