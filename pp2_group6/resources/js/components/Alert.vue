<template>
      <div>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@alert">
  Alert
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Problem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <form >
                <label for="reason">Can you describe the problem?</label>
        
                <textarea name="reason" id="reason" cols="30" rows="4" value="description" v-model="description"></textarea>


        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-success" @submit="formSubmit" >Yes</button>

    

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

        data(){
            return {
                description: '',
                
            }
        },
          methods: {
            formSubmit() {
                let currentObj = this;
                
                axios.post('formSubmit', {
                    description: this.description
                })
                .then(function (response) {
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

                
            }
        },


    }

</script>