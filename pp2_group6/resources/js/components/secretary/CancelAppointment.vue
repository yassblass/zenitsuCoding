<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-danger"
      data-toggle="modal"
      data-target="#exampleModal"
      data-whatever="@cancel"
    >
      Delete
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Cancel Appointment
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <input type="hidden" value="v-bind:id" />

              <label for="reason"
                >Are you sure you want to cancel this appointment?</label
              >
              <textarea
                name="reason"
                id="reason"
                cols="30"
                rows="4"
                value="description"
                v-model="description"
              ></textarea>
              <div class="modal-footer">
                <pre> {{ output }}</pre>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  No
                </button>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="cancelAppointment()"
                >
                  Yes
                </button>
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
  props: ["id", "myId"],
  data() {
    return {
      appointments: {},
      description: "",
      output: "",
    };
  },
  methods: {
    cancelAppointment() {
      let currentObj = this;
      axios
        .post("/secretary/cancelAppointment", {
          id: this.$props.id,
          description: this.description,
        })
        .then(function (response) {
          currentObj.output = response.data;
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
    getResults(page = 1) {
      axios.get("/appointmentList?page=" + page).then((response) => {
        this.appointments = response.data;
      });
    },
  },
};
</script>