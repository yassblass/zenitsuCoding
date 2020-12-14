<template>
    <div class="container">
        <b-form-group label="Insert your first name">
            <b-form-input
                type="text"
                placeholder="First name"
                v-model="student.firstName">
            </b-form-input>
        </b-form-group>

        <b-form-group label="Insert your last name">
            <b-form-input
                type="text"
                placeholder="Last name"
                v-model="student.lastName">
            </b-form-input>
        </b-form-group>

        <b-button v-on:click="checkEmail">Check</b-button>
    </div>
</template>
<script>
export default {
  data() {
    return {
        student: {
            firstName: "",
            lastName:""
        }
        
    };
  },
  created() {
    
  },
  methods: {
      checkEmail (event) {
          let response = "";
            axios.post('checkEmail', this.student)
                .then(res => {
                    console.log("Response: " + res.data);
                    this.response = res.data;
                    if(this.response === 1) {
                        //If email exists
                        console.log("Email exists!")

                        //SEND TRUE to Parent.
                        this.$emit('nameChecked', 1)
                    }
                    else if(this.response === 2){
                        //If student is flagged
                       console.log("You have been flagged, try again in 15 minutes!")
                    } else if(this.response === 3){
                        //If student has no rights
                       console.log("You have no rights, try again in 15 minutes!")
                    }  else if(this.response === 0) {
                        //If email has not been found in DB
                        console.log("Email does not exist in organization!")
                    } else {
                        console.log("Something went wrong, try again!")
                    }
                    
                }).catch(err => {
                console.log(err)
            })

            
      }
  }
};
</script>