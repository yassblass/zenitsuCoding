<template>
<div id="template">
  <div id="titel">
    <h1>{{title}} <b-button pill id="iCall" variant="primary">Add/Import iCal</b-button> </h1>
</div>
    <div id="table">
          <table class="table table-stripped table-bordered">
            <!-- <thead class="thead-dark">
              <tr>
                <th scope="col">DATE TIME</th>
                <th scope="col">STUDENT</th>
                <th scope="col">SUBJECT</th>
                <th scope="col">CANCEL</th>
              </tr>   
          </thead> -->
            <tr v-for="appointment in appointments" :key="appointment.appointmentId" >
              <th >{{ appointment.date }} {{ appointment.startsAt }}</th>
              <th >{{ appointment.firstName }} {{ appointment.lastName }}</th>
              <th >{{ appointment.subject }}</th>
              <th><cancelappointment :id="appointment.appointmentId"></cancelappointment></th>
              <!--  v-bind:id="appointment.appointmentId" -->
              </tr>
              <!--<pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->
          </table>
    </div>
    <br>

            <div id="button-alert">
              <alert ></alert>
            </div>
            <div id="button-back">
            <b-button @click="backbutton" class="button button-close" squared variant="outline-danger">Back</b-button>
            </div>
            
</div>

</template>

<script>

export default {


 props: ['id', 'data', 'myId'],
 data(){

    return{
  
      title : "Manage Appointments",
      appointments: '',

    
      
    }
  },
  mounted() {
            axios.get('/api/user').then((res)=>{
                this.user = res.data;
            })
            console.log('Component mounted.');
        },
  created(){
      axios.get('/api/appointmentLists')
      .then(response => this.appointments = response.data)
      .catch(error => console.log(error))
    },
    methods : {

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

#table { 
  height: 80%;
  width: 75%;
  background-color: white;
  border: 2px solid black;
  border-radius: 12px;
  margin-left: auto;
  margin-right: auto;
  overflow: auto; 
  height:400px;

  
}
#buttons{
 margin: 0;
}
#button-back{
  text-align: center;
}
#button-alert{
  float: right;
}
</style>



