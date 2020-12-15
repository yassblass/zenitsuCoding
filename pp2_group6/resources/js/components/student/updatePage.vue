<template>
  <div>
      <!-- Form for appointment update -->
    <form>
      <h4 class="text-center font-weight-bold">Update an Appointment</h4>
      <div class="form-group"></div>
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

        <!-- Update request button -->
      <div class="form-group">
        <button
          class="btn btn-block btn-primary"
          type="button"
          @click="updateRequest(appointment)"
        >
          Update Request
        </button>

        <!-- Get back to cancel Page request button -->
        <button class="btn btn-block btn-primary" @click="hideUpdatePage()">
          Back
        </button>
      </div>
    </form>

    <!-- Testing purposes -->
    <pre> {{ output }} </pre>
  </div>
</template>

<script>
export default {
  props: [
    "check",
    "appointmentId",
    "student_id",
    "user_id",
    "date",
    "startsAt",
    "subject",
    "status",
    "cancelToken",
  ],

  data() {
    return {
      output: "",
      appointment: {
        appointmentId: "",
        student_id: "",
        user_id: "",
        date: "",
        startsAt: "",
        subject: "",
      },
      currentComponent: "cancelPage",
    };
  },

  methods: {
    updateRequest(appointment) {
      //Declaring needed variables
      let thisResponse = "";
      let currentObject = this;

      //Get CancelToken & appointment ID from parent propreties.
      let cancelToken = this.$parent.$props.cancelToken;
      appointment.appointmentId = this.$parent.$props.appointmentId;

      //Axios call [POST]
      axios
        .post("/appointment/update/", {
          appointment: appointment,
        })
        .then(function (response) {
          //currentObject.output = response.data;
          console.log(response.data);
          this.thisResponse = response.data;

          this.thisResponse = response.data;
        })
        .catch(function (error) {
          //
        });

      //Whether true or false is returned by the axios call, different actions will be triggered.
      if ((this.thisResponse = 1)) {
        //Redirect to cancel Page
        window.location.href = "/appointment/token/" + cancelToken;
      } else {
        //Output the error message on the screen. For testing purposes.
        currentObject.output = "Error.Could not update the appointment request";
      }
    },
    hideUpdatePage() {
      this.$parent.showUpdateComponent();
    },
  },
};
</script>