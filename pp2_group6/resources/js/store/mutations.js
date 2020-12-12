//Mutations => used to commit and track State changes
let mutations = {
    //Appointments
    CREATE_APPOINTMENT(state, appointment) {
        state.appointments.unshift(appointment)
    },
    FETCH_APPOINTMENTS(state, appointments) {
        return state.appointments = appointments
    },
    DELETE_APPOINTMENT(state, appointment) {
        let index = state.appointments.findIndex(item => item.id === appointment.appointmentId)
        state.appointments.splice(index, 1)
    },

    //Users
    FETCH_USERS(state, users) {
        return state.users = users
    },

    //Subjects
    FETCH_SUBJECTS(state, subjects) {
        return state.subjects = subjects
    }

}
export default mutations