<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin::partials.head')
<body class="app sidebar-mini animated fadeIn">
@include('admin::partials.nav')
@include('admin::partials.sidebar')

<main class="app-content" id="app">

    @if (config('admin.breadcrumb'))
        {!! Breadcrumbs::render() !!}
    @endif

    @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
    @slot('header')
        <strong class="page-title"><b class="fa fa-th-large"></b> {{Meta::get('title')}}</strong>
    @endslot

    @include('flash::message')
    @include('core::shared.errors')

    @yield('content')
    @endcard

</main>

@include('admin::partials.footer')

</body>
</html>
