let mutations = {
    CREATE_APPOINTMENT(state, appointment) {
        state.appointments.unshift(appointment)
    },
    FETCH_APPOINTMENTS(state, appointments) {
        return state.appointments = appointments
    },
    DELETE_APPOINTMENT(state, appointment) {
        let index = state.appointments.findIndex(item => item.id === appointment.appointmentId)
        state.appointments.splice(index, 1)
    }

}
export default mutations