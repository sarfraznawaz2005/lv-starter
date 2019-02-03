@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
                @slot('header')
                    <strong><i class="fa fa-user"></i> Account Details</strong>
                @endslot

                {!! Former::open()->action(route('register'))->method('post')->class('validate') !!}

                {!!
                     Former::text('name')
                     ->required()
                     ->label('')
                     ->placeholder('Name')
                 !!}

                {!!
                    Former::email('email', 'E-Mail Address')
                    ->required()
                    ->label('')
                    ->placeholder('E-Mail Address')
                    ->autocomplete('off')
                !!}

                {!!
                    Former::password('password', 'Password')
                    ->required()
                    ->label('')
                    ->placeholder('Password')
                    ->autocomplete('off')
                !!}

                {!!
                     Former::password('password_confirmation', 'Confirm Password')
                     ->required()
                     ->label('')
                     ->placeholder('Confirm Password')
                     ->autocomplete('off')
                 !!}

                {!!
                Former::actions(Former::primary_button('<span class="fa fa-paper-plane"></span> Sign Up')
                ->type('submit')
                ->class('btn btn-block btn-success btn-raised'))
                !!}

                {!! Former::close() !!}

                @slot('footer')
                    <div class="text-center">
                        <i class="fa fa-info-circle"></i> Already have an account?
                        <a href="{{ route('login') }}" class="text-blue">Sign In</a>
                    </div>
                @endslot
                @endcard

            </div>
        </div>
    </div>
@endsection
