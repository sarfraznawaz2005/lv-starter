@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
                @slot('header')
                    <strong><i class="fa fa-lock"></i> Account Details</strong>
                @endslot

                {!! Former::open()->action(route('login'))->method('post')->class('validate') !!}

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

                @if(config('user.remember_me_checkbox', true))
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                Stay Signed In
                            </label>
                        </div>
                    </div>
                @endif

                {!!
                Former::actions(Former::primary_button('<span class="fa fa-sign-in"></span> Sign In')
                ->type('submit')
                ->class('btn btn-block btn-success btn-raised'))
                !!}

                {!! Former::close() !!}

                @slot('footer')
                    @if(config('user.enable_password_reset', true))
                        <div class="pull-left">
                            <a href="{{ route('password.request') }}" class="text-blue">
                                Forgot Password
                            </a>
                        </div>
                    @endif
                    <div class="pull-right">
                        <a href="{{ route('register') }}" class="text-blue">
                            Create Account
                        </a>
                    </div>
                    <div class="clearfix"></div>
                @endslot
                @endcard

            </div>
        </div>
    </div>
@endsection
