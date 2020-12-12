//Getters => to acces our State data
let getters = {
    appointments: state => {
        return state.appointments
    },
    users: state => {
        return state.users
    },
    subjects: state => {
        return state.subjects
    }
}

export default  getters