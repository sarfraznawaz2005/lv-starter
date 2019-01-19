@extends('main::layouts.master')

@section('content')

    <div class="jumbotron text-center">
        <h1>{{config('app.name')}}</h1>
        <p class="padded">
            Welcome to Laravel Starter!
        </p>
        <p>
            @guest
                <a class="btn btn-lg btn-success btn-raised" href="{{ url('/user/register') }}" role="button">
                    <i class="fa fa-paper-plane"></i> Get Started!
                </a>
            @endguest
        </p>
    </div>

@stop
