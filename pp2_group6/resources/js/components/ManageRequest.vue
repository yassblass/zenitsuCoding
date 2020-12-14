<template>
<div :style="myStyle">
    <h1>{{title}}</h1>
    <br> 
    <br>
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
          <th >{{ appointment.date }} {{ appointment.startsAt }}</th>
          <th >{{ appointment.firstName }} {{ appointment.lastName }}</th>
          <th >{{ appointment.subject }}</th>
          <b-button variant="primary" @click="editAccept(appointment.appointmentId)">Accept</b-button>
          <b-button variant="danger"  @click="editRefuse(appointment.appointmentId)">Refuse</b-button>

          
            </tr>
            </tbody>

      </table>
  
<div style="position:absolute">
      <b-button  pill variant="danger">Back</b-button>
      <alert></alert>
</div>
      
</div>
</template>
<script>
export default {

    data(){
        return {
            myStyle:{
            backgroundColor: "#bababa",
          
            },
            title : 'Manage Requests',
            
            appointments: {},
            appointmentAccepted: ''
            }
    },
    // use function called created to get the appointments in pending
            created(){
      axios.get('/api/appointmentList')
      .then(res => {
        this.appointments = res.data;
      })
      .catch(error => console.log(error))
    },
    methods: {
      // update the status to confirmed
      
        editAccept(id){
          axios.post('/api/editAccept/' + id)
          .then(response => console.log(JSON.stringify(response.data)+ ' Done'),
          window.location.reload()
          )
          .catch(error => console.log(error + ' Failed'));
        },
     // update the status to refused

        editRefuse(id){
          axios.post('/api/editRefuse/' + id)
          .then(response => console.log(JSON.stringify(response.data)+ ' Done'),
          window.location.reload()
          )
          .catch(error => console.log(error + ' Failed'));
        }
    }
}
</script>
<style>

</style>