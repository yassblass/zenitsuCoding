<template>
  <div>
    <b-list-group>
      <p>Secretary: </p><b-list-group-item active>{{  }} </b-list-group-item>
      <p>Date: </p><b-list-group-item active></b-list-group-item>
      <p>StartsAt: </p><b-list-group-item active ></b-list-group-item>
      <p>Subject: </p><b-list-group-item active></b-list-group-item>
    </b-list-group>

    <pre> {{ secretary }}</pre>
    <pre> {{ request }}</pre>

  </div>
</template>

<script>
import { mapGetters } from "vuex";


export default {
  props: ["request"],
  data () {
      return {
          secretary: '',
          secretaryId: '',
          
      }
  },
  created(){

      this.secretaryId = this.request['user_id'];
      this.users.foreach( function (user) {
          if(user.user_id === this.secretaryId ) {
              this.secretary = user.firstName + " " + user.lastName;
          }
      })
  },
  computed: {
    ...mapGetters(["users"]),
  },
};

</script>