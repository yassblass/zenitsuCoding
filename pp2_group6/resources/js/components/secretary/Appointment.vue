<template>
<div id="template">
   <navbar></navbar>
  <div id="titel">
    <h1>{{title}} <b-button pill id="iCall" variant="primary">Add/Import iCal</b-button> </h1>
</div>

    <div id="table">
    <textarea name='reason' placeholder="Describe the reason why you cancel the appointment" id='reason' cols='125' rows='3' value='description' v-model='description'> Reason why you cancel</textarea>
                
          <table class="table table-stripped table-bordered">
  
            <tr v-for="appointment in appointments" :key="appointment.appointmentId" >
              <th >{{ appointment.date }} {{ appointment.startsAt }}</th>
              <th >{{ appointment.firstName }} {{ appointment.lastName }}</th>
              <th >{{ appointment.subject }}</th>
              <th><button type="submit" class="btn btn-danger" @click='cancelAppointmentSubmit(appointment.appointmentId)' id="cancel">Delete</button></th>
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


 //props: ['id', 'data', 'myId'],
 data(){

    return{
  
      title : "Manage Appointments",
      appointments: '',
      description: '',
      output : '',
      id : '',
    
      
    }
  },
  mounted() {
    //@click='cancelAppointmentSubmit(appointment.appointmentId)
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
    cancelAppointmentSubmit(id) {
      let currentObj = this;
    //call the function 
      axios.post('/api/cancelAppointment/' + id, {
      description: this.description
    })
     .then(function (response) {
     currentObj.output = response.data;    
       window.location.reload()

    })
      .catch(function (error) {
      currentObj.output = error;
    });
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



