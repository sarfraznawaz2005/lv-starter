@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
                @slot('header')
                    <strong><i class="fa fa-lock"></i> Reset Password</strong>
                @endslot

                {!! Former::open()->action(route('password.update'))->method('post')->class('validate') !!}
                {!! Former::hidden('token')->value($token) !!}

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
                Former::actions(Former::primary_button('<span class="fa fa-paper-plane"></span> Reset Password')
                ->type('submit')
                ->class('btn btn-block btn-success btn-raised'))
                !!}

                {!! Former::close() !!}

                @endcard

            </div>
        </div>
    </div>
@endsection
