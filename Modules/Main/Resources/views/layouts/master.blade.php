<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('main::layouts.partials.head')

<body class="animated fadeIn">
@include('main::layouts.partials.nav')

@if (config('main.breadcrumb'))
    {!! Breadcrumbs::render() !!}
@endif

<main role="main" class="container main" id="app">
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            @include('core::shared.errors')

            @yield('content')
        </div>
    </div>
</main>

@include('main::layouts.partials.footer')

</body>
</html>
