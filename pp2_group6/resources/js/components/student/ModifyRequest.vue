<template>

  <div>
    <h3>Are you sure you want to make an appointment with this information?</h3>
    <br />

    <b-form-group>
      <div>
        You want an appointment with
        <strong>{{
          secretary["firstName"] + " " + secretary["lastName"]
        }}</strong>
        on <strong>{{ request["date"] }}</strong> at
        <strong>{{ request["startsAt"] }}</strong> <br />
        The subject of the appointment is
        <strong>{{ request["subject"] }}</strong>

        <br />
        <br />

        <b-button
          type="button"
          @click="showAvailabilityEdit"
          class="btn btn-primary"
        >
          Edit the information
        </b-button>

        <br />
      </div>
    </b-form-group>

    <b-button type="button" @click="showVerification"
      >All the information is correct</b-button
    >
    <!-- <pre> {{ secretary }}</pre> -->
    <!-- <pre> {{ request }}</pre> -->
  </div>

</template>

<script>
export default {
  props: ["request", "student_firstName", "student_lastName"],
  data() {
    return {
      secretary: "",
      selectedSecretary: "",
    };
  },
  methods: {
    showAvailabilityEdit() {
      //Show edit page of availability in the parent component.
      let dateChecked = false;
      let nameChecked = true;

      //Call parent component, which will show the availability component next.
      this.$emit("showAvailabilityEdit", {
        dateChecked: dateChecked,
        nameChecked: nameChecked,
      });
    },
    showVerification() {
      //Send Verification code by email
      axios
        .post("sendCode/", {
          student_firstName: this.$props.student_firstName,
          student_lastName: this.$props.student_lastName,
        })
        .then(function (response) {
          if (response.data === 1) {
            console.log("Verification code status: ", true);
          }
        })
        .catch(function (error) {
          console.log(error);
        });

      //Call verificationCode component in parent component.
      this.$emit("showVerificationComp", 1);
    },
  },

  mounted() {
    //When this component is mounted:
    //Get user Name based on user_id that the parent gave us as a prop 'request'.
    axios
      .get("users/getName/" + this.request["user_id"])
      .then((response) => (this.secretary = response.data))
      .catch((error) => console.log(error));
  },
  computed: {},
};
</script>