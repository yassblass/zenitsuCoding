<template>
  <div >
   
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
        <br />

      </div>
    </b-form-group>

  </div>
</template>

<script>
export default {
  props: ["request", "student_firstName", "student_lastName"],
  data() {
    return {
      secretary: "",
    };
  },
  methods: {
    
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