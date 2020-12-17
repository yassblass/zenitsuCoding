<template>
<div id="template">
   <navbar></navbar>
  <div id="titel">
    <h1>{{title}} </h1>
</div>
    <div id="table">
        
          <table class="table table-stripped table-bordered">
   <tbody>
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
            
</div>

</template>

<script>

export default {


 props: ['id', 'data', 'myId'],
 data(){

    return{
  
      title : "Manage Availabilities",
      availabilities: '',

    
      
    }
  },
  mounted() {
            axios.get('/api/user').then((res)=>{
                this.user = res.data;
            })
            console.log('Component mounted.');
        },
  created(){
      axios.get('/api/getAllAvailabilities')
      .then(response => this.availabilities = response.data)
      .catch(error => console.log(error))
    },
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



