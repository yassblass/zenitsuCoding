<template>

  <div id="template">
     <navbar></navbar>

  
    <form @submit.prevent="insertAvailabilities">

<h1>{{title}}</h1>


  <div id="calendar">
    <b-calendar :date-format-options="{ day: 'numeric', year: 'numeric' , month: 'numeric'}"
    v-model="value" :min="min" :max="max" locale="fr" ></b-calendar>
  </div>
 <div id="time" >
<input type="checkbox" id="1" value=" 09:00:00" v-model="hours">
<label for="1">09:00 - 09:30 |</label>

<input type="checkbox" id="2" value=" 09:30:00" v-model="hours">
<label for="2">09:30 - 10:00 |</label>

<input type="checkbox" id="3" value=" 10:00:00" v-model="hours">
<label for="3">10:00 - 10:30 |</label>

<input type="checkbox" id="4" value=" 10:30:00" v-model="hours">
<label for="4">10:30 - 11:00 |</label>

<input type="checkbox" id="5" value=" 11:00:00" v-model="hours">
<label for="5">11:00 - 11:30 |</label>

<input type="checkbox" id="6" value=" 11:30:00" v-model="hours">
<label for="6">11:30 - 12:00 |</label>
<br>
<input type="checkbox" id="7" value=" 13:00:00" v-model="hours">
<label for="7">13:00 - 13:30 |</label>

<input type="checkbox" id="8" value=" 13:30:00" v-model="hours">
<label for="8">13:30 - 14:00 |</label>

<input type="checkbox" id="9" value=" 14:00:00" v-model="hours">
<label for="9">14:00 - 14:30 |</label>

<input type="checkbox" id="10" value=" 14:30:00" v-model="hours">
<label for="10">14:30 - 15:00 |</label>

<input type="checkbox" id="11" value=" 15:00:00" v-model="hours">
<label for="11">15:00 - 15:30 |</label>

<input type="checkbox" id="12" value=" 15:30:00" v-model="hours">
<label for="12">15:30 - 16:00 |</label> 
 </div>
   <br>
 <br>
  <div id="button-back">
  <b-button @click="backbutton"  class="button button-close" squared variant="outline-danger">Back</b-button>
  <b-button pill variant="danger" type="submit">Save</b-button>
  <div id="button-alert">
       <alert ></alert>
      </div>
  </div>
 
  
    </form>
     
            
    
</div>


</template>

<script>
export default {
  props : {
    dateFormatOptions: {day: 'numeric', month: 'numeric', year: 'numeric'}
  },
    data() {
      const now = new Date()
      const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
      // 15th two months prior
      const minDate = new Date(today)
      minDate.setMonth(minDate.getMonth() - 2)
      minDate.setDate(15)
      // 15th in two months
      const maxDate = new Date(today)
      maxDate.setMonth(maxDate.getMonth() + 2)
      maxDate.setDate(15)

      return {
        title: 'When are you available?',
        value: '',
        min: minDate,
        max: maxDate,
        hours: [],
        datetime: '',
        
      }
     
    },
      methods: { 
      // insert all the available hours that are selected with the selected date
      insertAvailabilities(){
      axios.post('/api/insertAvailabilities/', {
      date: this.value,
      hours: this.hours
      })
      .then(response => console.log(JSON.stringify(response.data)+ ' Done'),
       window.location.reload()
     )
      .catch(error => console.log(error + ' Failed'));        
      },
        backbutton(){
        this.$router.push({name:"dashboard"});
      },
  }
}
</script>

<style>
#template{
  background-color: #bababa;
}
#calendar{
  height : 50%;
  width: 40%;
  margin-left: right;

}
#button-back{
  text-align: center;
}
#button-alert{
  float: right;
}
#time {
   height : 50%;
  width: 40%;
  margin-left: auto;
  margin-top: auto;
}
</style>