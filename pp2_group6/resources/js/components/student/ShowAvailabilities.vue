<template>
  <div class="container">
    <div>
      <!--<table class="table table-stripped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Available hours</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="availability in availabilities" :key="availability.avId">
            <th>{{ availability.time }}</th>
            
           
            <th>
              <button>Choose</button>
            </th>
          </tr>
        </tbody>
      </table> -->

      <b-form-group label="Choose a date">
            <b-form-datepicker 
              v-model="selectedDate" 
              :min="min" 
              :date-disabled-fn="dateDisabled"
              :state="state"
              reset-button
              close-button>
            </b-form-datepicker>
      </b-form-group>

      {{ request.date }}

<b-form-group label="Choose between available secretary">
        <b-form-radio-group
          v-model="request.user_id"
          buttons
          button-variant="danger">
          <template v-for="user in users">
            <b-form-radio
              :value="user.user_id"
              :key="user.user_id"
              v-model="selectedSecretary">
              {{ user.firstName + " " + user.lastName }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>



    <!-- <pre> {{ request }}</pre> -->

      <b-form-group label="Choose between available hours">
        <b-form-radio-group
          
          buttons
          button-variant="primary"
        >
          <template v-for="availability in availabilities">
            <b-form-radio
              :value="availability.time"
              :key="availability.avId"
              v-model="chosenTime"
            >
              {{ availability.time }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>

       
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    const now = new Date()
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())

    const minDate = new Date(today)
    minDate.setYear(minDate.getFullYear())
    minDate.setMonth(minDate.getMonth())
    minDate.setDate(minDate.getDate() + 2)


    return {
      request: {
        user_id: "",
        date: "",
        startsAt: "",
      },
      availabilities: {},
      selectedSecretary : '',
      chosenTime : '',
      min: minDate,
      state: false,
      selectedDate: ''
    };
  },
  created() {

  },
  methods: {
    dateDisabled(ymd, date) {
        const weekday = date.getDay()

        return weekday === 0 || weekday === 6
    }
  },
  watch: {
      // time : function(newTime){

      //     this.chosenTime = nexTime;
      // },
      selectedDate: function() {
          this.state = true;
          this.request.date = this.selectedDate;
      },
      selectedSecretary: function (newSecretary) {
      this.selectedSecretary = newSecretary;
      //this.currentComponent = "show-Availabilities";

      let secretaryId = newSecretary;

      axios
        .post("availabilities/",{
            secretaryId : secretaryId,
            date : this.request.date,
        } )
        .then((response) => (
          this.availabilities = response.data))
        .catch((error) => console.log(error));

        

      // this.availabilities = this.availabilities;
    },
    chosenTime: function (chosenTime) {
      
      this.request.startsAt = chosenTime;
      this.$emit('availabilityChosen', this.request);
    }
  },
  computed: {
    ...mapGetters(["users"])
  },
};
</script>