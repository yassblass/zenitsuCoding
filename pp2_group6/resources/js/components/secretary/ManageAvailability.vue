<template>
<div class="text-center">
    <navbar></navbar>
    <br />
    <br />
    <h1>{{ title }}</h1>

    <b-container style="text-align:left; position: absolute; top: 0; left:0; margin-top: 80px; margin-left: 25px;">
      <div>
        <b-button @click="backbutton" class="button button-close" variant="danger">Back</b-button>
      </div>
    </b-container> 

    <b-container >
      <div>
        <table class="table" >
          <thead>
            <th scope="col">Date and time</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
          </thead>
          <tbody>
          <tr v-for="availability in availabilities" :key="availability.avId" >
              <th >{{ availability.date }} {{ availability.time }}</th>
              <th >{{ availability.status }}</th>
              <th><b-button variant="danger" @click="cancelAvailability(availability.avId)">Cancel</b-button></th>
          </tr>
          </tbody>
      
          <!-- <pagination :data="appointments" @pagination-change-page="getResults"></pagination> -->
        </table>
      </div>
    </b-container>



    
   

    <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
        <div>
            <alert></alert>
        </div>
    </b-container>

    <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
    </div>
  </div>


<!-- <div id="template">
   <navbar></navbar>
  <div id="titel">
    <h1>{{title}} </h1>
</div>
    <div id="table">
        
          <table class="table table-stripped table-bordered">
   <tbody>
            <div class="d-flex justify-content-center"><strong v-if="!availabilities.length && componentMounted">No Availabilities yet! </strong></div>
            <tr v-for="availability in availabilities" :key="availability.avId" >
              <th >{{ availability.date }} {{ availability.time }}</th>
              <th >{{ availability.status }}</th>
              <th>
                <b-button variant="danger" @click="cancelAvailability(availability.avId)">Cancel</b-button>
              </th>
              
            </tr>
             </tbody>
          </table>
    </div>
    <br>
      <div id="button-alert">
      <alert ></alert>
      </div>
      <div id="button-back">
      <b-button @click="backbutton"  class="button button-close" squared variant="outline-danger">Back</b-button>
      </div>
            
</div> -->

</template>

<script>

export default {


 props: ['id', 'data', 'myId'],
 data(){

    return{
      title : "Manage Availabilities",
      availabilities: '',
      componentMounted: false,
    }
  },
  mounted() {
    axios.get('/api/user').then((res)=>{
      this.user = res.data;
      this.componentMounted = true;
    })
     //console.log('Component mounted.');

     axios.get('/api/getAllAvailabilities')
    .then(response => {
      this.availabilities = response.data;
      })
    .catch(error => console.log(error))
    
    },
    
  created(){},
    
  methods : {

      backbutton(){
        this.$router.push({name:"dashboard"});
      },
      cancelAvailability(id) {
        let currentObj = this;
        //call the function 
        axios.post('/api/deleteAvailability/' + id, {
        })
        .then(function (response) {
          currentObj.output = response.data;
          window.location.reload()
        })
        .catch(function (error) {
          currentObj.output = error;
        });
      }
    }

  }

</script>
<style scoped>
</style>



