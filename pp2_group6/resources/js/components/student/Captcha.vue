<template>
  <div >
    <vue-recaptcha
      ref="recaptcha"
      SameSite="none"
      Secure
      @verify="onVerify"
      sitekey="6LfMNwoaAAAAALzFmSgpp9RRDmBXGiWQQ8GWd-rW"
    >
    </vue-recaptcha>
    <br />
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
    };
  },
  components: {
    "vue-recaptcha": VueRecaptcha,
  },

  methods: {
    submitCaptcha() {
      if (this.form.robot) {
        this.$emit("captchaVerified", true);
      } else {
        alert("Captcha incorrect or not filed!");
      }
    },
    onVerify(response) {
      if (response) this.form.robot = true;
    },
  },
};
</script>