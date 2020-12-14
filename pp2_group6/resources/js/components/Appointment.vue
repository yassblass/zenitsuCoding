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
            <div id="button-alert">
              <alert ></alert>
            </div>
            <div id="button-back">
            <b-button  class="button button-close" squared variant="outline-danger">Back</b-button>
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
  created(){
      axios.get('/api/appointmentLists')
      .then(response => this.appointments = response.data)
      .catch(error => console.log(error))
    },
    methods : {


      deleteAppointment(id){
        //window.location.reload();
        axios.delete('/appointment/' + id)
        .then(response => this.id = response.data)
        .catch(error => console.log(error));
      },
    }

  }

</script>

<style>
#template{
  background-color: #bababa;
}

#table { 
  width: 75%;
  background-color: white;
  border: 2px solid black;
  border-radius: 12px;
  margin-left: auto;
  margin-right: auto;
    overflow: scroll;

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



