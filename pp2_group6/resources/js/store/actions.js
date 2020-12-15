let actions = {
        //Appointments
        createAppointment({commit}, request) {
            //Declare needed Variables
            let crypto = require("crypto");
            let response = "";
            //Generate unique token
            let token = crypto.randomBytes(15).toString("hex");

            //Axios call [POST]
            axios.post('appointment/create/', {
                request : request,
                token : token,
            })
                .then(res => {
                    //console.log("Response: " + res.data);
                    response = res.data;

                    if(response === 1) {
                        //handle action
                        console.log("Appointment created!")
                        window.location.reload();
                        commit('CREATE_APPOINTMENT', res.data)
                    }
                    else if(response === 2){
                        //handle action
                       console.log("You have been flagged, try again in 15 minutes!")
                    } else if(response === 3){
                        //handle action
                       console.log("You have no rights, try again in 15 minutes!")
                    }  else if(response === 0) {
                        console.log("Email does not exist in organization!")
                    } else {
                        console.log("Something went wrong, try again!")
                    }
                }).catch(err => {
                console.log(err)
            })
        },


        fetchAppointments({commit}) {
             //Declare needed Variables
             let currentObj = this;
             let thisResponse ="";

            //Axios [GET]
            axios.get('appointment/get')
                .then(res => {
                    //console.log(res.data);
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
            //window.location.reload();
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