<template>
  <div id="template">
    <navbar></navbar>

    <div class="d-flex justify-content-center">
      <form @submit.prevent="submitTime">
        <h1>{{ title }}</h1>
        <br />
        <hr />
        <br />
        <div class="d-flex justify-content-center">
          <transition name="slide-fade">
            <b-alert
              :show="dismissCountDown"
              variant="success"
              @dismissed="dismissCountDown = 0"
              @dismiss-count-down="countDownChanged"
            >
              Availability added successfully !
            </b-alert>
          </transition>

          <b-alert v-model="availabilityExists" variant="danger" dismissible>
            Availability already exists, please choose another date!
          </b-alert>
        </div>

        <div id="calendar" class="d-flex justify-content-center">
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
        <div class="d-flex justify-content-center">
          <pre id="dateMessage" v-if="dateNotGiven">
 <strong>Date is required! Please choose a date.</strong></pre>
        </div>

        <!-- <div id="time" >

        <input type="checkbox" id="1" value=" 09:00:00" v-model="hours">
        <label for="1">09:00 - 09:30 |</label>
        <input type="checkbox" id="2" value=" 09:30:00" v-model="hours">
        <label for="2">09:30 - 10:00 |</label>
        <br>

        <input type="checkbox" id="3" value=" 10:00:00" v-model="hours">
        <label for="3">10:00 - 10:30 |</label>
        <input type="checkbox" id="4" value=" 10:30:00" v-model="hours">
        <label for="4">10:30 - 11:00 |</label>
        <br>

        <input type="checkbox" id="5" value=" 11:00:00" v-model="hours">
        <label for="5">11:00 - 11:30 |</label>
        <input type="checkbox" id="6" value=" 11:30:00" v-model="hours">
        <label for="6">11:30 - 12:00 |</label>
        <br>

        <input type="checkbox" id="7" value=" 13:00:00" v-model="hours">
        <label for="7">13:00 - 13:30 |</label>
        <input type="checkbox" id="8" value=" 13:30:00" v-model="hours">
        <label for="8">13:30 - 14:00 |</label>
        <br>

        <input type="checkbox" id="9" value=" 14:00:00" v-model="hours">
        <label for="9">14:00 - 14:30 |</label>
        <input type="checkbox" id="10" value=" 14:30:00" v-model="hours">
        <label for="10">14:30 - 15:00 |</label>
        <br>

        <input type="checkbox" id="11" value=" 15:00:00" v-model="hours">
        <label for="11">15:00 - 15:30 |</label>
        <input type="checkbox" id="12" value=" 15:30:00" v-model="hours">
        <label for="12">15:30 - 16:00 |</label> 
        </div> -->

        <div>
          <label for="appt"
            ><strong>Choose a time for your meeting:</strong></label
          >

          <input
            type="time"
            id="appt"
            name="appt"
            min="09:00"
            max="18:00"
            step="1800"
            value="09:00"
            v-model="chosenTime"
            required
          />

          <small>Office hours are 9AM to 6PM, (30 min)</small>
          <br />
          <hr />
          <div class="d-flex justify-content-center">
            <b-button type="submit"> Submit </b-button>
          </div>
        </div>
        <b-button type="button" variant="primary" @click="setMeFreeMorning"> Set me free for the morning </b-button>
        <b-button type="button" variant="success" @click="setMeFreeAfternoon"> Set me free for the afternoon </b-button>

        <div id="button-back">
          
          <b-button
            @click="backbutton"
            class="button button-close"
            squared
            variant="outline-danger"
            >Back</b-button
          >

          <b-button squared variant="danger" type="submit">Save</b-button>
          <div id="button-alert">
            <alert></alert>
          </div>
        </div>
      </form>
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
    };
  },
  methods: {
    setMeFreeAfternoon () {
      axios.post('/secretary/freeAfternoon', {
        date: this.selectedDate,
      })
      .then(res => {
        console.log(res.data);
      })
    },
    setMeFreeMorning (){
      axios.post('/secretary/freeMorning', {
        date: this.selectedDate,
      })
      .then(res => {
        console.log(res.data);
      })
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
    // insert all the available hours that are selected with the selected date
    insertAvailabilities() {
      axios
        .post("/api/insertAvailabilities/", {
          date: this.value,
          hours: this.hours,
        })
        .then(
          (response) => console.log(JSON.stringify(response.data) + " Done"),
          window.location.reload()
        )
        .catch((error) => console.log(error + " Failed"));
    },
    backbutton() {
      this.$router.push({ name: "dashboard" });
    },
  },
};
</script>

<style scoped>
#template {
  background-color: #bababa;
  /*height: 720px;*/
}
#calendar {
  /* position: absolute;
  left: 30%;
  width: 20%;
  margin-top: 80px; */
}
#button-back {
  text-align: center;
  margin-top: 35%;
}
#button-alert {
  float: right;
}

#dateMessage {
  color: red;
}

h1 {
  text-align: center;
  font-size: 50px;
  font-family: Georgia;
}
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