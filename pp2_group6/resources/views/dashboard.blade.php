@extends('layout')


@section('content')

<div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
        <div class="flex">
            <router-link class="mr-4" to="/login"><span style="color:white">Login</span></router-link>
            <router-link to="/register"><span style="color:white">Register</span></router-link>
            
        </div>
    </div>
</div>

<nav class="navbar navbar-dark bg-dark ">
    <div class="container-fluid">
         <button class="navbar-toggler" id="navButton" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
    </div>

            
</nav>

<router-view></router-view>


@endsection