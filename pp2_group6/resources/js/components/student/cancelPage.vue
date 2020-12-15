<template>
    <div :is=currentComponent>

        <div>
        <!-- Message: Says if appointment is found -->
        <h1> {{ check }}</h1>
        
        <!-- Show appointment data -->
        <p>Appointment ID: {{ appointmentId }} </p>
        <p>Student ID: {{ student_id }} </p>
        <p>User ID: {{ user_id }} </p>
        <p>Date: {{ date }} </p>
        <p>Starts At: {{ startsAt }} </p>
        <p>Subject: {{ subject }} </p>
        <p>Status: {{ status }} </p>
        <p>Token: {{ cancelToken }} </p>

    <!-- Update page component, gets called only if property "currentCOmponent" = name of this component -->
    <update-page :is=currentComponent > </update-page>


    <pre> {{ output }} </pre>
    
    <!-- Show update page button -->
    <button type="button" class="btn btn-block btn-primary" @click="showUpdateComponent()">Update Appointment Request</button>
    <!-- Call to cancel appointment method button-->
    <button type="button" class="btn btn-block btn-primary" @click="cancelAppointment(appointmentId)">Cancel Appointment </button>
    </div>


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