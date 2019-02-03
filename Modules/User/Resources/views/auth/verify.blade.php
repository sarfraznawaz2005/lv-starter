@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
                @slot('header')
                    <i class="fa fa-lock"></i> {{__('Verify Your Email Address')}}
                @endslot

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a
                        href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

                @endcard

            </div>
        </div>
    </div>
@endsection
