<template>
  <div class="container">
    <b-alert v-model="showFirstName" variant="danger" dismissible>
      {{ errors.get("firstName") }}
    </b-alert>
    <b-alert v-model="showLastName" variant="danger" dismissible>
      {{ errors.get("lastName") }}
    </b-alert>
    <b-form-group label="Insert your first name">
      <b-form-input
        type="text"
        placeholder="First name"
        v-model="student.firstName"
      >
      </b-form-input>
    </b-form-group>

    <b-form-group label="Insert your last name">
      <b-form-input
        type="text"
        placeholder="Last name"
        v-model="student.lastName"
      >
      </b-form-input>
    </b-form-group>
    <div class="d-flex justify-content-center">
      <b-button class="d-flex justify-content-center" v-on:click="checkEmail"
        >Check</b-button
      >
    </div>
  </div>
</template>
<script>
class Errors {
  constructor() {
    this.errors = {};
  }

  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }

  record(errors) {
    this.errors = errors.errors;
  }
}
export default {
  data() {
    return {
      student: {
        firstName: "",
        lastName: "",
      },
      errors: new Errors(),
      showFirstName: false,
      showLastName: false,
    };
  },
  created() {},
  methods: {
    checkEmail(event) {
      let response = "";
      axios
        .post("checkEmail", this.student)
        .then((res) => {
          console.log("Response: " + res.data);
          this.response = res.data;
          if (this.response === 1) {
            //If email exists
            console.log("Email exists!");

            //SEND TRUE to Parent.
            this.$emit("nameChecked", [1, this.student]);
          } else if (this.response === 2) {
            //If student is flagged
            console.log("You have been flagged, try again later.");
          } else if (this.response === 3) {
            //If student has no rights
            console.log("You have no rights, try again in 15 minutes!");
          } else if (this.response === 0) {
            //If email has not been found in DB
            console.log("Email does not exist in organization!");
          } else {
            console.log("Something went wrong, try again!");
          }
        })
        .catch((err) => {
          this.showFirstName = true;
          this.showLastName = true;

          this.errors.record(err.response.data);
        });
    },
  },
};
</script>