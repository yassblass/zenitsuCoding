<template>
<div>
    <h1>{{title}}</h1>
    <br> 
    <br>
  <table>
  <tr v-for="appointment in appointments" :key="appointment.appointmentId">
      <th >{{ appointment.startsAt }}</th>
      <th >{{ appointment.firstName }} {{ appointment.lastName }}</th>
      <th >{{ appointment.status }}</th>
      <th> 
        <b-button variant="primary" @click="editAccept(appointment.appointmentId)">Accept</b-button>
        <b-button variant="danger"  @click="editRefuse(appointment.appointmentId)">Refuse</b-button>
        </th>
  </tr>
  </table>
      <b-button pill variant="danger">Back</b-button>


</div>
</template>
<script>
export default {

    data(){
        return {
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
          axios.post('/editAccept/' + id)
          .then(response => console.log(JSON.stringify(response.data)+ ' Done'),
          window.location.reload()
          )
          .catch(error => console.log(error + ' Failed'));
        },
     // update the status to refused

        editRefuse(id){
          axios.post('/editRefuse/' + id)
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