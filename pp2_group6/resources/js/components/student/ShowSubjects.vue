<template>
<div class ="d-flex justify-content-center">
  <b-form-group>
    <p><strong>Choose a subject</strong></p>
    <b-form-radio-group
      stacked
      v-model="chosenSubject"
      buttons
      button-variant="danger">
      <template v-for="subject in subjects">
        <b-form-radio style="margin-bottom:5px" :value="subject.name" :key="subject.subjectId" v-model="chosenSubject">
          {{ subject.name }}
          <br/>
        </b-form-radio>
        
      </template>
    </b-form-radio-group>
  </b-form-group>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  mounted (){
    this.$store.dispatch('fetchSubjects');
  },
  data() {
    return {
      subject: {
        name: "",
      },
      chosenSubject : '',
    };
  },
  watch: {
      //Function that is called whenever a subject is clicked on radio buttons.
      chosenSubject : function(newSubject) {
          
          //Fill in the subject object based on new subject.
          this.subject.name = newSubject;
          //Send new subject to parent component [createAppointments].
          this.$emit('subjectChosen', newSubject);
      }
  },
  computed: {
    ...mapGetters(["subjects"]),
  },
};
</script>