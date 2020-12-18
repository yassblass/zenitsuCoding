<template>
    <div :is=currentComponent>
        <b-navbar variant="danger" type="dark">
    <b-navbar-brand href="#">
      <img src="/images/ehb_logo_white_horizontal.png" class="d-inline-block align-top" style="width:100px; height:25px;">
    </b-navbar-brand>
  </b-navbar>
        <div>
            <b-jumbotron>
                <!-- Message: Says if appointment is found -->
                <h1> {{ check }}</h1>

                <template>
                Choose wheter you want to update or cancel your appointment. If all the information is correct just exit the page.
                </template>

                <hr>

                
                    
                <!-- Show appointment data -->
                <p>Appointment ID: {{ appointmentId }} </p>
                <p>Student ID: {{ student_id }} </p>
                <p>Secretary ID: {{ user_id }} </p>
                <p>Date: {{ date }} </p>
                <p>Starts At: {{ startsAt }} </p>
                <p>Subject: {{ subject }} </p>
                <p>Status: {{ status }} </p>

                <hr />

                <!-- Show update page button -->
                <b-button type="button"  variant="info" @click="showUpdateComponent()">Update Appointment Request</b-button> <br > <br>
                <!-- Call to cancel appointment method button-->
                <b-button type="button"  variant="info" @click="cancelAppointment(appointmentId)">Cancel Appointment </b-button>
            </b-jumbotron>
        </div> 

        <div>
        

    <!-- Update page component, gets called only if property "currentCOmponent" = name of this component -->
    <update-page :is=currentComponent > </update-page>
    
    
    </div>
<footer style="height:50px; background-color:red; position: absolute;left: 0; right: 0; bottom: 0;">
    <p style="padding-top: 13px; color:white; ">&copy; Copyright 2020 | PP2 - Group 6</p>
</footer>

    </div>
</template>

<script>
import updatePage from './updatePage.vue';


export default{
  components: { updatePage },
    props: [
        'check',
        'appointmentId',
        'student_id',
        'user_id',
        'date',
        'startsAt',
        'subject',
        'status',
        'cancelToken',
    ],
    
    data() {
        return{
            output : '',
            currentComponent: 'div',
            appointment: {
        appointmentId: "",
        student_id: "",
        user_id: "",
        date: "",
        startsAt: "",
        subject: "",
      },
            
        }
        
    },
    
    methods:  {
        cancelAppointment(appointmentId) {
            let thisResponse ="";
            let currentObject = this;
            axios.delete('/appointment/cancel/' + appointmentId)
            .then(function (response) {
                    currentObject.output = response.data;

                    this.thisResponse = response.data;

                }).catch(function (error) {
                    //
                });

                if(this.thisResponse = 1){

                    //If delete query returned true, redirect to home page.
                    window.location.href = "/" 
                }
                else{

                    currentObject.output = "Error. Maybe the appoint you are trying to cancel doesn't exist anymore ?";
                }
                
        },
        showUpdateComponent (){


            //Check current component name and change it accordingly.
            if(this.currentComponent === 'div') {
                this.currentComponent = 'updatePage';
            }
            else if (this.currentComponent === 'updatePage') 
            {
                this.currentComponent = 'div';
            }
            
        }

    }
}
</script>