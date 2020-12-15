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
      <transition name="slide-fade">
        <show-availabilities
          v-if="nameChecked && !dateChecked"
          :availabilities="availabilities"
          v-on:availabilityChosen="availabilitySet"
        ></show-availabilities>
      </transition>
      <!-- <pre> {{ request }} </pre> -->

      <!-- <pre>{{ selectedSecretary }} </pre>
            <pre>{{ availabilities }} </pre> -->

      <transition name="slide-fade">
        <show-subjects
          v-if="dateChecked && !subjectChecked"
          v-on:subjectChosen="subjectSet"
        ></show-subjects>
      </transition>

      <transition name="slide-fade">
        <modify-request
          v-if="subjectChecked && nameChecked"
          :request="request"
          v-on:showAvailabilityEdit="editSecretary"
          v-on:showSubjectEdit="editSubject"
        ></modify-request>
      </transition>
      <b-button
        v-if="subjectChecked"
        @click.prevent="createAppointment(request)"
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
      subjectChecked: false,
    };
  },
  methods: {
    editSecretary(value) {
      this.dateChecked = value.dateChecked;
      this.nameChecked = value.nameChecked;
      this.subjectChecked = false;
    },
    editSubject(value) {
      this.dateChecked = value.dateChecked;
      this.subjectChecked = value.subjectChecked;
    },
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
      this.subjectChecked = true;
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

<style scoped>
.slide-fade-enter-active {
  transition: all 0.8s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
