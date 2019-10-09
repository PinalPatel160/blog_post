@extends('layouts.index')

@section('content')
    <main role="main" class="container">
        <div class="jumbotron">
            <h1 class="text-success">{{$message}}</h1>
            <p class="lead">Hi {{$user->name}},</p>
            <p class="lead"> Thanks for verifying your email on Project! <a href="#" class="text-danger">Click here to login.</a> </p>
        </div>
    </main>
@endsection
