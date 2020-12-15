<template>
<div>
    <h1>{{title}}</h1> <b-button pill variant="primary">Add/Import iCal</b-button>

  <div>
    
<table class="table table-stripped table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">DATE TIME</th>
      <th scope="col">STUDENT</th>
      <th scope="col">SUBJECT</th>
      <th scope="col">CANCEL</th>
     
    

    </tr>

    
 </thead>
   <tbody>

  <tr v-for="appointment in appointments" :key="appointment.appointmentId" >
     <th >{{ appointment.startsAt }}</th>
     <th >{{ appointment.firstName }} {{ appointment.lastName }}</th>
     <th >{{ appointment.subject }}</th>
     <th><cancelappointment v-bind:id="appointment.appointmentId"></cancelappointment></th>

     <!--  v-bind:id="appointment.appointmentId" -->
    
      </tr>
      </tbody>
     <!--<pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->

</table>
</div>

<div> 
  <b-button squared variant="outline-danger">Back</b-button>
  <alert></alert>

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



