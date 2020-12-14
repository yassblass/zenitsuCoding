<template>
  <div class="container">
    <div>
      <table class="table table-stripped table-bordered">
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
      </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      availabilities: {},
    };
  },
  created() {
      axios.get('availabilities')
      .then((response) => (this.availabilities = response.data))
      .catch((error) => console.log(error));
  },
};
</script>