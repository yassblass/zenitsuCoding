<template>
  <div>
    <!-- Incorrect captcha error -->
    <b-alert v-model="showIncorrect" variant="danger" dismissible>
      Captcha incorrect or not filed!
    </b-alert>

    <!-- Captcha -->
    <vue-recaptcha
      ref="recaptcha"
      SameSite="none"
      Secure
      @verify="onVerify"
      sitekey="6LfMNwoaAAAAALzFmSgpp9RRDmBXGiWQQ8GWd-rW"
    >
    </vue-recaptcha>

    <br />

    <!-- Submit Captcha -->
    <b-button type="button" @click="submitCaptcha">
      I am definitely not a robot &#128517;
    </b-button>
  </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
export default {
  data() {
    return {
      form: {
        robot: false,
      },
      showIncorrect: false,
    };
  },
  components: {
    "vue-recaptcha": VueRecaptcha,
  },

  methods: {
    submitCaptcha() {
      //If Captcha returns true (means it is validated).
      if (this.form.robot) {
        //Call parent component to trigger the next action.
        this.$emit("captchaVerified", true);
      } else {
        //Show error alert when captcha is filled incorrectly
        this.showIncorrect = true;
      }
    },
    onVerify(response) {
      //When captcha is validated, set 'robot' = true.
      if (response) this.form.robot = true;
    },
  },
};
</script>