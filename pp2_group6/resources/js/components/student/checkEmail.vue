<template>
  <div class="container">
    <!-- First name error -->
    <b-alert v-model="showFirstName" variant="danger" dismissible>
      {{ errors.get("firstName") }}
    </b-alert>
    <!-- Last name error -->
    <b-alert v-model="showLastName" variant="danger" dismissible>
      {{ errors.get("lastName") }}
    </b-alert>
    <!-- Flagged error -->
    <b-alert v-model="showFlagged" variant="danger" dismissible>
      Your email is flagged, try again later!
    </b-alert>
    <!-- hasRight error -->
    <b-alert v-model="showHasRight" variant="danger" dismissible>
      Your email has no rights, try again later!
    </b-alert>
    <!-- Email does not exist in organization error -->
    <b-alert v-model="showUnknown" variant="danger" dismissible>
      Your email does not exist in our organization!
    </b-alert>
    <!-- General error -->
    <b-alert v-model="showError" variant="danger" dismissible>
      Oops! Something went wrong, try again.
    </b-alert>

    <b-form-group label="Insert your first name">
      <b-form-input
        type="text"
        placeholder="First name"
        v-model="student.firstName">
      </b-form-input>
    </b-form-group>

    <b-form-group label="Insert your last name">
      <b-form-input
        type="text"
        placeholder="Last name"
        v-model="student.lastName">
      </b-form-input>
    </b-form-group>

    <div class="d-flex justify-content-center" >
        <b-button class="d-flex justify-content-center" v-on:click="checkEmail">Check</b-button>
    </div>
</div>
</template>
<script>

//Class to record error and error message
class Errors {
  constructor() {
    this.errors = {};
  }

  //Get error message
  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }

  //Record the error
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
      showFlagged: false,
      showHasRight: false,
      showUnknown: false,
      showError: false
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
            this.showFlagged = true;
            console.log("You have been flagged, try again later.");
          } else if (this.response === 3) {
            //If student has no rights
            this.showHasRight = true;
            console.log("You have no rights, try again later.");
          } else if (this.response === 0) {
            //If email has not been found in DB
            this.showUnknown = true;
            console.log("Email does not exist in organization!");
          } else {
            this.showError = true;
            console.log("Something went wrong, try again!");
          }

        })
        .catch((err) => {
          
          this.errors.record(err.response.data);
          
          if(err.response.data.errors['firstName'] && err.response.data.errors['lastName']){
            //If both errors are triggered show both alerts
            this.showFirstName = true;
            this.showLastName = true;
          } else if (err.response.data.errors['lastName']){
            //If only lastName error is triggered show lastName alert
            this.showFirstName = false;
            this.showLastName = true;
          } else {
            //If only firstName error is triggered show firstName alert
            this.showFirstName = true;
            this.showLastName = false;
          }
        });
    },
  },
}
</script>