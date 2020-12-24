<template>
  <div class="text-center">
    <navbar></navbar>

    <b-container style="text-align:left; position: absolute; top: 0; left:0; margin-top: 80px; margin-left: 25px;">
      <div>
        <b-button @click="backbutton" class="button button-close" variant="danger">Back</b-button>
      </div>
    </b-container> 


    <div>
      <form @submit.prevent="submitTime">
        <br />
        <h1>{{ title }}</h1>
        <br />
     
        <div class="mx-auto" style="width:400px;">
          <!-- [ALERT] Availability inserted successfully! -->
          <transition name="slide-fade">
            <b-alert
              :show="dismissCountDown"
              variant="success"
              @dismissed="dismissCountDown = 0"
              @dismiss-count-down="countDownChanged">
              Availability added successfully !
            </b-alert>
          </transition>

          <!-- [ALERT] Availability already exists! -->
          <transition name="slide-fade">
            <b-alert v-model="availabilityExists" variant="danger" dismissible>
              Availability already exists, please choose another date!
            </b-alert>
          </transition>

          <!-- [ALERT] Afternoon availability set successfully -->
          <transition name="slide-fade">
            <b-alert v-model="afternoonSet" variant="success" >
              You are now free for the afternoon on {{ selectedDate }}!
            </b-alert>
          </transition>

          <!-- [ALERT] Morning availability set successfully -->
          <transition name="slide-fade">
            <b-alert v-model="morningSet" variant="success" >
              You are now free for the morning on {{ selectedDate }}!
            </b-alert>
          </transition>
        </div>

        <div>
          <b-calendar
            :date-format-options="{
              day: 'numeric',
              year: 'numeric',
              month: 'numeric',
            }"
            v-model="selectedDate"
            :min="min"
            :date-disabled-fn="dateDisabled"
            locale="fr"
            required
          ></b-calendar>
        </div>

        <br />

        <div>
          <pre v-if="dateNotGiven"><strong>Date is required! Please choose a date.</strong></pre>
        </div>




        <div v-if="dateSelected && !selectHours">
          <div>
            <strong>Set me free for</strong>
          </div>

          <div>
            <div>
              <b-button
                type="button"
                variant="primary"
                @click="setMeFreeMorning">
                The morning
              </b-button>

              <b-button
                type="button"
                variant="danger"
                @click="setMeFreeAfternoon">
                The afternoon
              </b-button>
            </div>
          </div>

          <div>
            <strong>OR</strong>
          </div>

          <div>
            <div>
              <b-button type="button" variant="dark" @click="showTimeInput">
                Select hour
              </b-button>
            </div>
          </div>
        </div>


        <div v-if="selectHours">
          <label for="appt"><strong>Choose a time for your meeting</strong></label>

          <input
            type="time"
            id="appt"
            name="appt"
            min="09:00"
            max="18:00"
            step="1800"
            value="09:00"
            v-model="chosenTime"
            required/>

          <small>Office hours are 9AM to 6PM, (30 min)</small>
          <br /> <br /> 
          <div>
            <b-button type="submit" variant="primary"> Submit </b-button>
            <b-button type="submit" @click="resetComponents"> Cancel </b-button>
          </div>
        </div>
      </form>
    </div>
    <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
        <div>
            <alert></alert>
        </div>
    </b-container>

    <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    dateFormatOptions: { day: "numeric", month: "numeric", year: "numeric" },
  },
  data() {
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    // 15th two months prior
    const minDate = new Date(today);
    minDate.setYear(minDate.getFullYear());
    minDate.setMonth(minDate.getMonth());
    minDate.setDate(minDate.getDate() + 2);

    return {
      title: "When are you available?",
      selectedDate: "",
      min: minDate,
      hours: [],
      datetime: "",
      chosenTime: "",
      dateNotGiven: false,
      availabilityExists: false,
      dismissCountDown: 0,
      dismissSecs: 2,
      dateSelected: false,
      selectHours: false,
      afternoonSet: false,
      morningSet: false,
    };
  },
  methods: {
    resetComponents() {
      this.dateSelected = false;
      this.selectHours = false;
    },
    showTimeInput() {
      this.selectHours = true;
    },
    setMeFreeAfternoon() {
      axios
        .post("/secretary/freeAfternoon", {
          date: this.selectedDate,
        })
        .then((res) => {
          console.log(res.data);
        });
      this.afternoonSet = true;
      window.location.reload();
    },
    setMeFreeMorning() {
      axios
        .post("/secretary/freeMorning", {
          date: this.selectedDate,
        })
        .then((res) => {
          console.log(res.data);
        });
      this.morningSet = true;
      window.location.reload();
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    dateDisabled(ymd, date) {
      const weekday = date.getDay();

      return weekday === 0 || weekday === 6;
    },
    submitTime() {
      if (this.selectedDate === "") {
        this.dateNotGiven = true;
      } else {
        console.log("date:", this.selectedDate);
        console.log("time:", this.chosenTime);

        axios
          .post("/api/insertAvailabilities/", {
            date: this.selectedDate,
            time: this.chosenTime,
          })
          .then(
            (response) => {
              console.log(JSON.stringify(response.data) + " Done");
              if (response.data === 1) {
                console.log("Availability added!");

                this.dismissCountDown = this.dismissSecs;
              } else if (response.data === 0) {
                console.log("Availability already exists!");

                this.availabilityExists = true;
              } else {
                console.log("Unknown error!");
              }
            }
            //window.location.reload()
          )
          .catch((error) => console.log(error + " Failed"));
      }
    },
    backbutton() {
      this.$router.push({ name: "dashboard" });
    },
  },
  watch: {
    selectedDate: function (newDate) {
      //Set dateSelected boolean to true.
      this.dateSelected = true;
      //Assign newly selected date to local variable.
      this.selectedDate = newDate;
    },
  },
};
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.8s ease;
}
.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>