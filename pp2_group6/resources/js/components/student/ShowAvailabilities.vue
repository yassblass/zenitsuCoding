<template>
  <div class="container">
    <div>
      <b-form-group label="Choose a date">
        <b-form-datepicker
          v-model="selectedDate"
          :min="min"
          :date-disabled-fn="dateDisabled"
          :state="state"
          reset-button
          close-button
        >
        </b-form-datepicker>
      </b-form-group>
      
      <!-- {{ request.date }} -->
      <div class="container">
        <div v-if="users.length && dateSelected">
          <p>Choose between available secretaries</p>
          <hr/>
        </div>

        <div v-if="dateSelected && !users.length">
          <p>No secretary available on {{ selectedDate }} !</p>
          <hr/>
        </div>
      </div>

      
<div class="container" v-if="dateSelected">
      <b-form-group>
        <b-form-radio-group
          v-model="request.user_id"
          buttons
          button-variant="danger"
          stacked
        >
          <template v-for="user in users">
            <b-form-radio
              style="margin-bottom:5px"
              :value="user.user_id"
              :key="user.user_id"
              
              
              v-model="selectedSecretary"
            >
              {{ user.firstName + " " + user.lastName }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group> 

      </div>

      <!-- <pre> {{ request }}</pre> -->
      <hr v-if="secretarySelected" />
      <div v-if="secretarySelected" class="container">
        <p>Choose between available hours</p>
      </div>

    <div class="container" v-if="secretarySelected && dateSelected">
      <b-form-group>
        <b-form-radio-group buttons button-variant="primary" stacked>
          <template v-for="availability in availabilities">
            <b-form-radio
              :value="availability.time"
              :key="availability.avId"
              v-model="chosenTime"
              style="margin-bottom:5px">
              {{ availability.time }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  props: ['modify'],

  data() {
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

    const minDate = new Date(today);
    minDate.setYear(minDate.getFullYear());
    minDate.setMonth(minDate.getMonth());
    minDate.setDate(minDate.getDate() + 2);

    return {
      request: {
        user_id: "",
        date: "",
        startsAt: "",
      },
      availabilities: {},
      selectedSecretary: "",
      chosenTime: "",
      min: minDate,
      state: false,
      selectedDate: "",
      dateSelected: false,
      secretarySelected: false,
      messageIsDisplayed: null,
    };
  },
  mounted() {
    if(this.$props.modify === true){
      this.request.date = '';
      this.request.user_id = '';
    }

  },
  methods: {
    dateDisabled(ymd, date) {
      const weekday = date.getDay();

      return weekday === 0 || weekday === 6;
    },
  },
  watch: {
    // time : function(newTime){

    //     this.chosenTime = nexTime;
    // },
    selectedDate: function () {
      this.state = true;
      this.request.date = this.selectedDate;
      this.dateSelected = true;
      this.secretarySelected = false;
      this.$store.dispatch("fetchUsers", this.request);
    },
    selectedSecretary: function (newSecretary) {
      this.selectedSecretary = newSecretary;
      //this.currentComponent = "show-Availabilities";

      //Displayavailability message
      this.secretarySelected = true;
      let secretaryId = newSecretary;

      axios
        .post("availabilities/", {
          secretaryId: secretaryId,
          date: this.request.date,
        })
        .then((response) => (this.availabilities = response.data))
        .catch((error) => console.log(error));
    },
    chosenTime: function (chosenTime) {
      this.request.startsAt = chosenTime;
      this.$emit("availabilityChosen", this.request);
    },
  },
  computed: {
    ...mapGetters(["users"]),
  },
};
</script>