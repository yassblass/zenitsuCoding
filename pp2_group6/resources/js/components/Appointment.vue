<template>
<div>
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand href="#"><img src="/img/logo.jpg" width="50" height="40"></b-navbar-brand>

    <b-navbar-toggle target="navbar-toggle-collapse">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
        <b-icon v-else icon="chevron-bar-down"></b-icon>
      </template>
    </b-navbar-toggle>

    <b-collapse id="navbar-toggle-collapse" is-nav>
      <b-navbar-nav class="ml-auto">
        <b-nav-item href="#">Link 1</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>

    <h1>{{title}}</h1>

  <div>
<table class="table table-stripped table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">DATE TIME</th>
      <th scope="col">STUDENT</th>
      <th scope="col">SUBJECT</th>
     

    </tr>

    
 </thead>
   <tbody>
  <tr>
      <th> WOE, 02/12  09:30AM </th>
      <th> Yassine Tanouti </th>
      <th> Request Documents </th>
     <th><b-button squared variant="outline-danger">Button</b-button></th>
      </tr>
      </tbody>
</table>
</div>

<div> 
  <button> Back </button>
</div>
</div>
</template>

<script>
export default {
  data(){
    return{
      title : "Manage Appointments"

    }
  }
}
</script>



