<template>

  <div>
    <b-navbar variant="danger" type="dark" style="margin-bottom: 10%">
      <b-navbar-brand href="#" class="mx-auto">
        <img
          src="/images/ehb_logo_white_horizontal.png"
          class="d-inline-block align-top"
          style="width: 100px; height: 25px"
        />
      </b-navbar-brand>
    </b-navbar>
    <b-container class="mx-auto">
    <div class="d-flex justify-content-center" style="margin-top: 10%">
      <div>
        <b-form>
          <check-email
            v-if="showMailCheckComponent"
            v-on:nameChecked="showDateForm"
          ></check-email>

          <transition name="slide-fade">
            <show-availabilities
              :modify="modify"
              v-if="showAvailabilityComponent"
              :availabilities="availabilities"
              v-on:availabilityChosen="availabilitySet"
            ></show-availabilities>
          </transition>

          <transition name="slide-fade">
            <show-subjects
              v-if="showSubjectComponent"
              v-on:subjectChosen="subjectSet"
            ></show-subjects>
          </transition>

          <transition name="slide-fade">
            <modify-request
              :student_firstName="request.firstName"
              :student_lastName="request.lastName"
              v-if="showModifyRequestComponent"
              :request="request"
              v-on:showAvailabilityEdit="editSecretary"
              v-on:showSubjectEdit="editSubject"
              v-on:showVerificationComp="askVerification"
            ></modify-request>
          </transition>

          <transition name="slide-fade">
            <verification-code
              v-if="showVerificationComponent"
              :student_firstName="request.firstName"
              :student_lastName="request.lastName"
              v-on:codeValidated="showCaptcha"
            >
            </verification-code>
          </transition>

          <transition name="slide-fade">
            <captcha
              v-if="showCaptchaComponent"
              v-on:captchaVerified="showSummary()"
            >
            </captcha>
          </transition>

          <transition name="slide-fade">
            <request-summary
              :student_firstName="request.firstName"
              :student_lastName="request.lastName"
              :request="request"
              v-if="showSummaryComponent"
            ></request-summary>
          </transition>

          <transition name="slide-fade">
            <show-end-message
            v-if="showEndMessageComponent"
            > 
             
            </show-end-message>
          </transition>

          <b-button
            variant="primary"
            v-if="showSummaryComponent"
            @click.prevent="createAppointment(request)"
            >Make appointment</b-button
          >
          <b-button
            v-if="showSummaryComponent"
            @click.prevent="backToStartPage()"
            >Cancel</b-button
          >
        </b-form>
      </div>
    </div>
    </b-container>
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
import { mapGetters } from "vuex";
import checkEmail from "./checkEmail.vue";
import ShowSubjects from "./ShowSubjects.vue";
import VerificationCode from "./VerificationCode.vue";
import ModifyRequest from "./ModifyRequest.vue";
import VueRecaptcha from "vue-recaptcha";
import Captcha from "./Captcha.vue";
import requestSummary from "./RequestSummary.vue";
export default {
  components: {
    checkEmail,
    ShowSubjects,
    VerificationCode,
    ModifyRequest,
    Captcha,
  },
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
      selectedSecretary: "",
      availabilities: {},
      chosenTime: "",
      appointmentId: "",
      token: "",
      showVerificationComponent: false,
      showMailCheckComponent: true,
      showAvailabilityComponent: false,
      showSubjectComponent: false,
      showModifyRequestComponent: false,
      showSubmitComponent: false,
      showCaptchaComponent: false,
      showSendRequestButton: false,
      modify: false,
      showSummaryComponent: false,
      showEndMessageComponent: false,
    };
  },
  methods: {
    backToStartPage() {
      //This function redirects the student to the start page.
      window.location.href = "/";
    },
    showSummary() {
      //Hide captcha component
      this.showCaptchaComponent = false;

      //Show appointment request button
      this.showSummaryComponent = true;
    },
    editSecretary(value) {
      //hide modify component
      this.showModifyRequestComponent = false;
      this.modify = true;

      //show availability
      this.showAvailabilityComponent = true;
    },
    editSubject(value) {
      //show subject component
      this.showSubjectComponent = true;

      //hide modify component
      this.showModifyRequestComponent = false;
    },
    createAppointment(request) {
      let currentObj = this;
      
      this.showEndMessageComponent = true;
      this.showCaptchaComponent = false;
      this.showSummaryComponent = false;
      this.$store.dispatch("createAppointment", request);
    },
    availabilitySet(availabilityRequest) {
      //Extract data from child component [show availabilitie] & store them in local request object for later POST call.
      this.request.date = availabilityRequest.date;
      this.request.user_id = availabilityRequest.user_id;
      this.request.startsAt = availabilityRequest.startsAt;

      //hide availability component
      this.showAvailabilityComponent = false;
      //Show next component.
      this.showSubjectComponent = true;
    },
    showDateForm: function (value) {
      if (value[0] === 1) {
        //console.log(value[1].firstName);
        //Store first name & last name locally.
        this.request.firstName = value[1].firstName;
        this.request.lastName = value[1].lastName;

        //Hide name input
        this.showMailCheckComponent = false;

        //show availability component
        this.showAvailabilityComponent = true;

        //Jump to next component
        //this.currentComponent = "show-availabilities"
      }
    },
    askVerification() {
      //Hide modify-request component.
      this.showModifyRequestComponent = false;

      //Show verification code component.
      this.showVerificationComponent = true;
    },
    subjectSet(chosenSubject) {
      //Extract data from child component [show availabilitie] & store them in local request object for later POST call
      this.request.subject = chosenSubject;

      //Hide this component
      this.showSubjectComponent = false;

      //Show next component
      this.showModifyRequestComponent = true;
    },
    showCaptcha(value) {
      //Hide verification code component
      this.showVerificationComponent = false;

      //Show captcha component
      this.showCaptchaComponent = true;
    },
  },
  watch: {
    selectedSecretary: function (newSecretary) {
      //watch the changes on selection of secretary. This function gets executed everytime a different secretary is selected.
      //Set this secretary equal to the new one.
      this.selectedSecretary = newSecretary;

      //Isolate secretary Id from radio buttons. (Button value is not the name but the ID of the secretary.)
      let secretaryId = newSecretary;

      //Axios Call [POST] with secretary Id & selected date, which will return the availabilities of that secretary.
      axios
        .post("availabilities/", {
          secretaryId: secretaryId,
          date: this.request.date,
        })
        .then((response) => (this.availabilities = response.data))
        .catch((error) => console.log(error));

      //set local property 'availabilities' equal to the axios response (containing all availabilities).
      this.$props.availabilities = this.availabilities;
    },
  },
  computed: {
    //These are mapgetters returned from the functions (using vueX library) located at store/actions.js
    ...mapGetters(["users", "subjects"]),
  },
};
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.8s ease;
}
.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
