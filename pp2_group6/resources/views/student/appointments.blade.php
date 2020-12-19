<!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Vue.js app</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <!--<link rel="stylesheet" href="{{mix('css/app.css')}}"-->

        <!-- Styles -->
        <style>
            html {
                height:100%;
            }

            body {
                min-height:100%; 
                position: relative; 
                padding-bottom: 50px;
            }
        </style>
    </head>
    <body style="background-color: #FFF9F7; color:#767676;">
   
        <div id="app" style="text-align:center;">
             <create-appointments></create-appointments>   
        </div>

        
    <!-- scripts-->
    <script src="https://unpkg.com/vue@latest/dist/vue.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
    <script src="https://unpkg.com/vue-recaptcha@latest/dist/vue-recaptcha.min.js"></script>
    <script src="<?php echo asset('/js/app.js')?>"></script>
    </body>
    </html>