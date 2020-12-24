<template>
    <b-navbar  type="dark" variant="dark">
      <b-navbar-brand href="#" class="mx-auto"> 
        <img
          src="/images/ehb_logo_white_horizontal.png"
          style="width: 100px; height: 25px"/>
      </b-navbar-brand>

      <b-navbar-nav v-if="user.user_id > 0">
        <b-nav-item-dropdown right>
          <b-dropdown-item v-if="user.user_id <= 0" to="/secretary/login">Login</b-dropdown-item>
          <b-dropdown-item v-if="user.admin == true" to="/secretary/register">Register secretary</b-dropdown-item>
          <b-dropdown-item v-if="user.user_id > 0" to="/secretary/avatar">Change profile picture</b-dropdown-item>
          <b-dropdown-item v-if="user.user_id > 0" @click.prevent="logout"><span style="color:red;">Logout</span></b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>



      <!-- <b-navbar-nav>
        <b-nav-item v-if="user.user_id <= 0" to="/secretary/login">
            Login
          </b-nav-item>
          <b-nav-item v-if="user.admin == true" to="/secretary/register">
            Register a secretary
          </b-nav-item>
          <b-nav-item to="/secretary/avatar">
            Change profile picture
          </b-nav-item>
      </b-navbar-nav> 

      <b-navbar-nav class="ml-auto">
        <b-nav-item  right @click.prevent="logout">
          <span style="color:red;">Logout</span>
        </b-nav-item> 
      </b-navbar-nav>    -->
    </b-navbar>
    <!-- <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <div class="flex">
          <router-link
            v-if="user.user_id <= 0"
            class="mr-4"
            to="/secretary/login"
            ><span style="color: white">Login</span>
          </router-link>
          <router-link v-if="user.admin == true" to="/secretary/register">
            <button class="btn btn-light" style="margin-left: 20px">
              Register
            </button>
          </router-link>
          <router-link to="/secretary/avatar">
            <button class="btn btn-light" style="margin-left: 20px">
              Avatar
            </button>
          </router-link>
          <button
            @click.prevent="logout"
            class="btn btn-light"
            style="margin-left: 20px">
            Logout
          </button>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <button
          v-if="userIsLoggedIn"
          class="navbar-toggler"
          id="navButton"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarToggleExternalContent"
          aria-controls="navbarToggleExternalContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <img src="/images/ehb_logo_white_horizontal.png" style="width: 100px; height: 25px" />
      </div>
    </nav> -->
</template>

<script>
export default {
  props: ["onLoginPage"],
  data() {
    return {
      user: "",
      userIsLoggedIn: false,
    };
  },
  methods: {
    // method to logout and then redirect to login
    logout() {
      axios.post("/api/logout").then(() => {
        this.$router.push({ name: "login" });
      });
    },
  },
  // when component is mountend get user who is logged in to show on page
  mounted() {
    //Get call to verify if user is logged in.
    if (!this.$props.onLoginPage) {
      axios.get("/api/authenticated").then((res) => {
        //Set local response variable equal to axios response.
        //console.log("Authenticated response:", res.data);
        if (res.data === 1) {
          this.userIsLoggedIn = true;

          axios.get("/api/user").then((res) => {
            //console.log("user info:", res.data);
            this.user = res.data;
          });
        }
      });
    }
  },
};
</script>

<style scoped>
</style>
