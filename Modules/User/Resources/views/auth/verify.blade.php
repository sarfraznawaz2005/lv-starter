@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @section('mycard.component_card_content')
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a
                        href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                @endsection

                @include('core::components.card', [
                    'id' => 'mycard',
                    'card_heading' => '<i class="fa fa-lock"></i> ' . __('Verify Your Email Address'),
                    'card_type' => '',
                    'card_heading_type' => '',
                    'card_heading_color' => '',
                    'show_card_footer' => false,
                ])
            </div>
        </div>
    </div>
@endsection
