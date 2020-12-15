<template>
  <b-form-group label="Choose a subject">
    <b-form-radio-group
      v-model="chosenSubject"
      buttons
      button-variant="danger"
    >
      <template v-for="subject in subjects">
        <b-form-radio :value="subject.name" :key="subject.subjectId" v-model="chosenSubject">
          {{ subject.name }}
        </b-form-radio>
      </template>
    </b-form-radio-group>
  </b-form-group>
</template>

<script>
import { mapGetters } from "vuex";

export default {
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