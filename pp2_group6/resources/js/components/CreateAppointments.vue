<template>
    <div>
        <h2>Create an appointment</h2>
        <b-form @submit="createAppointment(appointment)">
            <check-email :is=currentComponent v-on:nameChecked="showDateForm"></check-email>

            <b-form-group label="Choose between available secretary">
                <b-form-radio-group
                    v-model="request.user_id"
                    buttons
                    button-variant="danger">
                    <template v-for="user in users">
                        <b-form-radio :value="user.user_id" :key="user.user_id">
                            {{ user.firstName + " " + user.lastName }}
                        </b-form-radio>
                    </template>
                </b-form-radio-group>
            </b-form-group>

            <pre> {{ check }} </pre>

            <b-form-group label="Choose a date">
                <b-form-input
                    type="date"
                    placeholder="Date"
                    v-model="request.date">
                </b-form-input>
            </b-form-group>

            <b-form-group label="Choose a date and time">
                <b-form-input
                    type="datetime-local"
                    placeholder="Time"
                    v-model="request.startsAt">
                </b-form-input>
            </b-form-group>

            <b-form-group label="Choose a subject">
                <b-form-radio-group
                    v-model="request.subject"
                    buttons
                    button-variant="danger">
                    <template v-for="subject in subjects">
                        <b-form-radio :value="subject.name" :key="subject.subjectId">
                            {{ subject.name }}
                        </b-form-radio>
                    </template>
                </b-form-radio-group>
            </b-form-group>

            <b-button @click.prevent="createAppointment(request)">Make appointment</b-button>
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
            <button
                class="btn btn-block btn-primary"
                @click="showAppointment(token)"></button>
  <div>
    <h2>Create an appointment</h2>
    <b-form @submit="createAppointment(appointment)">
      <b-form-group label="Insert your first name">
        <b-form-input
          type="text"
          placeholder="First name"
          v-model="request.firstName"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group label="Insert your last name">
        <b-form-input
          type="text"
          placeholder="Last name"
          v-model="request.lastName"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group label="Choose a date">
        <b-form-input type="date" placeholder="Date" v-model="request.date">
        </b-form-input>
      </b-form-group>
      <b-form-group label="Choose between available secretary">
        <b-form-radio-group
          v-model="request.user_id"
          buttons
          button-variant="danger"
        >
          <template v-for="user in users">
            <b-form-radio
              :value="user.user_id"
              :key="user.user_id"
              v-model="selectedSecretary"
            >
              {{ user.firstName + " " + user.lastName }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>

      <show-availabilities
        :is="currentComponent"
        :availabilities="availabilities" v-on:childToParent="timeIsChosen"
      >
      </show-availabilities>

      
      <!-- <pre>{{ selectedSecretary }} </pre>
      <pre>{{ availabilities }} </pre> -->

      <!--<b-form-group label="Choose a date and time">
        <b-form-input
          type="datetime-local"
          placeholder="Time"
          v-model="request.startsAt"
        >
        </b-form-input>
      </b-form-group> -->

      <b-form-group label="Choose a subject">
        <b-form-radio-group
          v-model="request.subject"
          buttons
          button-variant="danger"
        >
          <template v-for="subject in subjects">
            <b-form-radio :value="subject.name" :key="subject.subjectId">
              {{ subject.name }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>

      <b-button @click.prevent="createAppointment(request)"
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
    </div>

    <div>
      <pre> {{ output }} </pre>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import checkEmail from './checkEmail.vue';
export default {
  components: { checkEmail },
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
                subject: ""
            },
            request: {
                appointmentId: "",
                student_id: "",
                firstName: "",
                lastName: "",
                user_id: "",
                date: "",
                startsAt: "",
                subject: "",
            },
            user: {
              firstName: "",
              lastName: ""
            },
            subject: {
              name: "",
              duration: ""
            },
            student:{
                firstName: "",
                lastName: ""
            },
            output: "",
            currentComponent:"check-email",
            appointmentId: "",
            token: "",
            check: "THIS IS THE CHECK",
        };
    },
    methods: {
        createAppointment(student) {

          let currentObj = this;
            this.$store.dispatch("createAppointment" , request);
        },
        confirmAppointment(appointmentId) {
            //Declare needed Variables
            let currentObj = this;

            //Axios call [POST]
            axios
                .get("appointment/confirm/" + appointmentId)
                .then(function(response) {
                    //This.output gets filled with the response data.
                    currentObj.output = response.data;
                })
                .catch(function(error) {
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
        showDateForm: function(value) {
        
            if(value === 1){
                this.check = "NAME HAS BEEN VALIDATED";

                //Jump to next component
            }
        }
    },
    watch: {
        
    },
  computed: {
    ...mapGetters(["users", "subjects"]),
  },
};
</script>
