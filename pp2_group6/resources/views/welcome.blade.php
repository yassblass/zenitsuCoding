<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel & Vue</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">

        <script src="<?php echo asset('/js/app.js')?>"></script>
        
    </head>
    <body>
        <div id="app" style="text-align:center;margin-top:2%;margin-bottom:2%;">
        <calendar></calendar>
        </div>
    </body>
</html>