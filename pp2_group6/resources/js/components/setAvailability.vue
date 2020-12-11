<template>
<body :style="myStyle" id="grijs">
<div>
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand href="#">EHB</b-navbar-brand>

    <b-navbar-toggle target="navbar-toggle-collapse">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
        <b-icon v-else icon="chevron-bar-down"></b-icon>
      </template>
    </b-navbar-toggle>

    <b-collapse id="navbar-toggle-collapse" is-nav>
      <b-navbar-nav class="ml-auto">
        <b-nav-item href="#">Link 1</b-nav-item>
        <b-nav-item href="#">Link 2</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
<h1>{{title}}</h1>

  <div>
    <b-calendar       :date-format-options="{ day: 'numeric', year: 'numeric' , month: 'numeric'}"
    v-model="value" :min="min" :max="max" locale="fr" ></b-calendar>
    <p> Date: {{value}}</p>
  </div>
  <br>
  <hr>
 <div>
<input type="checkbox" id="1" value="09:00 - 09:30" v-model="checkedNames">
<label for="1">09:00 - 09:30</label>

<input type="checkbox" id="2" value="09:30 - 10:00" v-model="checkedNames">
<label for="2">09:30 - 10:00</label>

<input type="checkbox" id="3" value="10:00 - 10:30" v-model="checkedNames">
<label for="3">10:00 - 10:30</label>

<input type="checkbox" id="4" value="10:30 - 11:00" v-model="checkedNames">
<label for="4">10:30 - 11:00</label>

<input type="checkbox" id="5" value="11:00 - 11:30" v-model="checkedNames">
<label for="5">11:00 - 11:30</label>

<input type="checkbox" id="6" value="11:30 - 12:00" v-model="checkedNames">
<label for="6">11:30 - 12:00</label>
<br>
<input type="checkbox" id="7" value="13:00 - 13:30" v-model="checkedNames">
<label for="7">13:00 - 13:30</label>

<input type="checkbox" id="8" value="13:30 - 14:00" v-model="checkedNames">
<label for="8">13:30 - 14:00</label>

<input type="checkbox" id="9" value="14:00 - 14:30" v-model="checkedNames">
<label for="9">14:00 - 14:30</label>

<input type="checkbox" id="10" value="14:30 - 15:00" v-model="checkedNames">
<label for="10">14:30 - 15:00</label>

<input type="checkbox" id="11" value="15:00 - 15:30" v-model="checkedNames">
<label for="11">15:00 - 15:30</label>

<input type="checkbox" id="12" value="15:30 - 16:00" v-model="checkedNames">
<label for="12">15:30 - 16:00</label> 
 </div>
 <span>Hours : {{ checkedNames }}</span>
 <br>
 <br>
  <b-button pill variant="danger">Back</b-button>
  <b-button pill variant="danger">Save</b-button>
  <b-button v-b-tooltip.hover.bottom="'Signal here for a problem !'" >
  <b-icon icon="exclamation-circle-fill" variant="danger"></b-icon>
  </b-button>
</body>
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
        myStyle:{
                backgroundColor: "#d9d9d9"
            },
        checkedNames: [],
        
      }
     
    },
      methods: { 
 format(value, event) {
    return moment(value).format('DD/MM/YYYY')
}
      }
  }
</script>