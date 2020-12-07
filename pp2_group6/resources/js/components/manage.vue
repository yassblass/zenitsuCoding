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
  <br> <br>
  <div>
      <b-container class="text-center">
      <p> Woe, 02/12 | Souheib Touri | Request documents</p>
      <b-button variant="primary">Accept</b-button>
      <b-button variant="danger">Cancel</b-button>
      </b-container>
      <br>
  </div>
    <div>
      <b-container fluid>
      <p> Woe, 02/12 | Adil El Ghamarti | Request documents</p>
      <b-button variant="primary">Accept</b-button>
      <b-button variant="danger">Cancel</b-button>
      </b-container>
      <br>
  </div>
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
            }
            }
    }
}
</script>
<style scoped>

</style>