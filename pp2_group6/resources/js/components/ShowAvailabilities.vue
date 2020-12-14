<template>
  <div class="container">
    <div>
      <!--<table class="table table-stripped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Available hours</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="availability in availabilities" :key="availability.avId">
            <th>{{ availability.time }}</th>
            
           
            <th>
              <button>Choose</button>
            </th>
          </tr>
        </tbody>
      </table> -->

      <b-form-group label="Choose between available hours">
        <b-form-radio-group
          
          buttons
          button-variant="primary"
        >
          <template v-for="availability in availabilities">
            <b-form-radio
              :value="availability.time"
              :key="availability.avId"
              v-model="time"
            >
              {{ availability.time }}
            </b-form-radio>
          </template>
        </b-form-radio-group>
      </b-form-group>

       
    </div>
  </div>
</template>
<script>
export default {
    props: ['availabilities'],
  data() {
    return {
      time: '',
    };
  },
  created() {

    
  },
  watch: {
      time : function(newTime){

          this.$emit('childToParent', newTime);
      }
  }
};
</script>