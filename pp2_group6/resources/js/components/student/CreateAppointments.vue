<template>
  <div>
    <h2>Create an appointment</h2>
    <b-form @submit="createAppointment(appointment)">
      <check-email
        v-if="!nameChecked"
        :is="currentComponent"
        v-on:nameChecked="showDateForm"
      ></check-email>

      <!-- <pre> {{ check }} </pre>
            <pre> {{ request }} </pre> -->

      <show-availabilities
        v-if="nameChecked && !dateChecked"
        :availabilities="availabilities"
        v-on:availabilityChosen="availabilitySet"
      ></show-availabilities>

      <!-- <pre> {{ request }} </pre> -->

      <!-- <pre>{{ selectedSecretary }} </pre>
            <pre>{{ availabilities }} </pre> -->

      <show-subjects
        v-if="dateChecked"
        v-on:subjectChosen="subjectSet"
      ></show-subjects>

      <modify-request :request="request" ></modify-request>

      <b-button v-if="dateChecked" @click.prevent="createAppointment(request)"
        >Make appointment</b-button
      >
    </b-form>

    <br />
    <hr />
    <br />

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

    <br />
    <hr />
    <br />

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
      <button class="btn btn-block btn-primary" @click="showAppointment(token)">
        Show Appointment
      </button>

      <div>
        <!--<pre> {{ output }} </pre> -->
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import checkEmail from "./checkEmail.vue";
import ShowSubjects from "./ShowSubjects.vue";
export default {
  components: { checkEmail, ShowSubjects },
  name: "CreateAppointment",
  props: ["firstName", "lastName"],
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
      request: {
        student_id: "",
        firstName: "",
        lastName: "",
        user_id: "",
        date: "",
        startsAt: "",
        subject: "",
      },
      output: "",
      currentComponent: "check-email",
      selectedSecretary: "",
      availabilities: {},
      chosenTime: "",
      appointmentId: "",
      token: "",
      nameChecked: false,
      dateChecked: false,
    };
  },
  methods: {
    createAppointment(request) {
      let currentObj = this;
      this.$store.dispatch("createAppointment", request);
    },
    availabilitySet(availabilityRequest) {
      this.request.date = availabilityRequest.date;
      this.request.user_id = availabilityRequest.user_id;
      this.request.startsAt = availabilityRequest.startsAt;
      this.dateChecked = true;
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
    showDateForm: function (value) {
      if (value[0] === 1) {
        //Maybe implement a check alert on name validation befor making an appointment request.
        //this.check = "NAME HAS BEEN VALIDATED";

        console.log(value[1].firstName);
        this.request.firstName = value[1].firstName;
        this.request.lastName = value[1].lastName;
        this.nameChecked = true;

        //Jump to next component
        //this.currentComponent = "show-availabilities"
      }
    },
    subjectSet(chosenSubject) {
      this.request.subject = chosenSubject;
    },
  },
  watch: {
    selectedSecretary: function (newSecretary) {
      this.selectedSecretary = newSecretary;
      this.currentComponent = "show-Availabilities";

      let secretaryId = newSecretary;

      axios
        .post("availabilities/", {
          secretaryId: secretaryId,
          date: this.request.date,
        })
        .then((response) => (this.availabilities = response.data))
        .catch((error) => console.log(error));

      this.$props.availabilities = this.availabilities;
    },
  },
  computed: {
    ...mapGetters(["users", "subjects"]),
  },
};
</script>
