<template>
  <div>
    <b-form-group
      label="Are you sure you want to make an appoint with the following data?"
    >
    <div>
      <b-form-radio-group buttons button-variant="danger">
        <b-form-radio v-model="selectedSecretary">
          {{ secretary["firstName"] + " " + secretary["lastName"] }}
        </b-form-radio>
        
      </b-form-radio-group>
    

      <br />
      <b-form-radio-group buttons button-variant="danger">
        <b-form-radio >
          {{ request['date']  }}
        </b-form-radio>
       
      </b-form-radio-group>

      <br />

      <b-form-radio-group buttons button-variant="danger">
        <b-form-radio >
          {{ request['startsAt'] }}
        </b-form-radio>
        <button
          type="button"
          @click="showAvailabilityEdit"
          class="btn btn-primary"
        >
          Edit
        </button>
      </b-form-radio-group>
      </div>
      <br />
      <b-form-radio-group buttons button-variant="danger">
        <b-form-radio v-model="selectedSecretary">
          {{ request['subject'] }}
        </b-form-radio>
         <button
          type="button"
          @click="showSubjectEdit"
          class="btn btn-primary"
        >
          Edit
        </button> 
      </b-form-radio-group>
    </b-form-group>

    <!-- <pre> {{ secretary }}</pre> -->
    <!-- <pre> {{ request }}</pre> -->
  </div>
</template>

<script>
export default {
  props: ["request"],
  data() {
    return {
      secretary: "",
      selectedSecretary: "",
    };
  },
  methods: {
    showAvailabilityEdit() {
      let dateChecked = false;
      let nameChecked = true;

      this.$emit("showAvailabilityEdit", { 'dateChecked' : dateChecked, 'nameChecked': nameChecked});
    },
    showSubjectEdit (){
        let dateChecked = true;
        let subjectChecked = false;
        
        this.$emit('showSubjectEdit',{ 'dateChecked' : dateChecked, 'subjectChecked': subjectChecked} )
    }
  },
  mounted() {
    axios
      .get("users/getName/" + this.request["user_id"])
      .then((response) => (this.secretary = response.data))
      .catch((error) => console.log(error));
  },
  computed: {},
};
</script>