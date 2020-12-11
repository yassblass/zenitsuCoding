let actions = {
        createAppointment({commit}, appointment) {
            axios.post('appointments', appointment)
                .then(res => {
                    console.log(res.data);
                    commit('CREATE_APPOINTMENT', res.data)
                }).catch(err => {
                console.log(err)
            })
        },
        fetchAppointments({commit}) {
            axios.get('appointments')
                .then(res => {
                    commit('FETCH_APPOINTMENTS', res.data)
                }).catch(err => {
                console.log(err)
            })
        },
        deleteAppointment({commit}, appointment, e) {
            axios.delete(`appointments/` + appointment.appointmentId)
                .then(res => {
                    console.log(appointment.appointmentId);
                    console.log(res.data);
                    if (res.data === 'ok')
                        commit('DELETE_APPOINTMENT', appointment)
                }).catch(err => {
                console.log(err)
            })
        }
        ,
        fetchUsers({commit}) {
            axios.get('users')
                .then(res => {
                    commit('FETCH_USERS', res.data)
                }).catch(err => {
                console.log(err)
            })
        }
    }

    export default actions