<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EhB | Appointment</title>
    </head>
    <body>
        <div id="app">
            <div class="container">
                <div>
                    <create-appointments></create-appointments>
                </div>
                <div>
                    <appointments></appointments>
                </div>
            </div>
        </div>


        <!--Scripts-->
        <script src="<?php echo asset('/js/app.js')?>"></script>
    </body>
</html>