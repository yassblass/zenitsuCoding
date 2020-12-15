<template>
    <div>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel" data-whatever="@cancel">
  Delete
</button>

<!-- Modal -->
<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>

          <input type="hidden" value= v-bind:id>

                <label for="reason">Are you sure you want to cancel this appointment?</label>
                <textarea name="reason" id="reason" cols="30" rows="4" value="description" v-model="description"></textarea>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success" @click='cancelAppointmentSubmit(ids)' >Yes</button>
                    </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
    </div>

</template>

<script>
    export default {
        
 props: ['id'],
        

 data(){
    return{
      ids: this.$props.id,
      appointments: {},
      description: '',
      output : '',
      

    }
  },


    methods : {
          cancelAppointmentSubmit(id) {
                let currentObj = this;
                //call the function 
                axios.post('/api/cancelAppointment/' + id, {
                    description: this.description
                })
                .then(function (response) {
                    currentObj.output = response.data;
                    

                })
                .catch(function (error) {
                    currentObj.output = error;
                });
    },

    
     getResults(page = 1) {
			  axios.get('/appointmentList?page=' + page)
				.then(response => {
			  		this.appointments = response.data;
			  	});
      },
      
      
 
  }
    }
</script>