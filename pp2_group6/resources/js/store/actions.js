let actions = {
        //Appointments
        createAppointment({commit}, request) {

            //Declare needed Variables
            let crypto = require("crypto");
            let currentObj = this;
            let thisResponse ="";
            //Generate unique token
            var token = crypto.randomBytes(15).toString("hex");

            //Axios call [POST]
            axios.post('appointment/create/', {
                request : request,
                token : token,
            })
                .then(res => {
                    console.log(res.data);
                    commit('CREATE_APPOINTMENT', res.data)
                }).catch(err => {
                console.log(err)
            })


            //Whether true or false is returned by the axios call, different actions will be triggered.
            if(this.thisResponse === 1) {
                //handle action
            }
            else {
                //handle action

            }
            window.location.reload();
        },
        fetchAppointments({commit}) {
             //Declare needed Variables
             let currentObj = this;
             let thisResponse ="";

            //Axios [GET]
            axios.get('appointment/get')
                .then(res => {
                    console.log(res.data);
                    commit('FETCH_APPOINTMENTS', res.data)
                }).catch(err => {
                console.log(err)
            })

            //Whether true or false is returned by the axios call, different actions will be triggered.
            if(this.thisResponse === 1) {
                //handle action
            }
            else {
                //handle action
            }
            
        },

        deleteAppointment({commit}, appointment, e) {
            //Declare needed Variables
            let currentObj = this;
            let thisResponse ="";

            //Axios [DELETE]
            axios.delete('appointment/delete/' + appointment.appointmentId)
                .then(res => {
                    console.log(appointment.appointmentId);
                    console.log(res.data);
                    if (res.data === 'ok')
                        commit('DELETE_APPOINTMENT', appointment)
                }).catch(err => {
                console.log(err)
            })

            //Whether true or false is returned by the axios call, different actions will be triggered.
            if(this.thisResponse === 1) {
                //handle action
            }
            else {
                //handle action
            }
            window.location.reload();
        },

        //Users
        fetchUsers({commit}) {
            axios.get('users/get')
                .then(res => {
                    commit('FETCH_USERS', res.data)
                }).catch(err => {
                console.log(err)
            })
        },

        //Subjects
        fetchSubjects({commit}) {
            axios.get('subjects/get')
                .then(res => {
                    commit('FETCH_SUBJECTS', res.data)
                }).catch(err => {
                console.log(err)
            })
        }
    }

    export default actions