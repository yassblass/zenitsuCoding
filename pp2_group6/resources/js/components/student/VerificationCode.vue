<template>
  <div>
    <b-form-group
      id="v_code"
      label="Enter 6 digits verifictation code"
      label-for="v_code-input"
      valid-feedback="Press Submit to validate."
    >
      <b-form-input
        type="number"
        id="v_code-input"
        v-model="verificationData.v_code"
        :formatter="formatNumber"
      ></b-form-input>
    </b-form-group>
    <button type="button" @click="verifyCode()">Verify Code</button>
  </div>
</template>

<script>
export default {
  props: ["student_firstName", "student_lastName"],
  computed: {},
  data() {
    return {
      verificationData: {
        v_code: "",
        student_firstName: "",
        student_lastName: "",
      },
    };
  },
  methods: {
    verifyCode() {
      let response = "";

      //Assign props that came from parent component to this object.
      this.verificationData.student_firstName = this.$props.student_firstName;
      this.verificationData.student_lastName = this.$props.student_lastName;

      //Axios [POST] with object containing v_code, firstname & lastname. (which will be used to retrieve student_id in backend).
      axios
        .post("verifyCode/", this.verificationData)
        .then(res => {
          //This.output gets filled with the response data.
          if (res.data === 1) {
            //Code verification succesfull
            //this.res = response.data
            //code verification successfull.
            console.log("Code verification successfull");

            this.$emit("codeValidated", 1);
          } else if (res.data === 2) {
            //Code incorrect.
            console.log("Verificaiton code incorrect!");
          } else if (res.data === 3) {
            //Code verification
            console.log("Oops. Verification code is expired!");
          } else if (res.data === 0) {
            //Code verification
            console.log(
              "Verification code is already redeemed or student may not exist!"
            );
          }
          else {
            console.log(res.data);
          }
        }).catch(function (error) {
          console.log(error);
        });
    },

    formatNumber(e) {
      return String(e).substring(0, 6);
    },
  },
};
</script>