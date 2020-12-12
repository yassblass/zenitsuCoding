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
</body>
</template>
<script>
export default {

    data(){
        return {
            title : 'Manage Requests',
            
            myStyle:{
                backgroundColor: "#d9d9d9"
            },
            appointments: {},
            appointmentAccepted: ''
            }
    },
    // use function called created to get the appointments in pending
            created(){
      axios.get('/appointmentList')
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
<style scoped>

</style>