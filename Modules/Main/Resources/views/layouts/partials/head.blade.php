<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Sarfraz Ahmed (sarfraznawaz2005@gmail.com)">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(request()->isSecure())
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>
    @endif

    <title>{{Meta::get('title') . ' :: ' . appName()}}</title>

    {!! Meta::tag('robots') !!}

    {!! Meta::tag('title') !!}

    {!! Meta::tag('description') !!}
    {!! Meta::tag('site_name') !!}
    {!! Meta::tag('url') !!}
    {!! Meta::tag('locale') !!}

    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Styles -->
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    <link rel="stylesheet" href="/modules/main/css/custom.css">

    @stack('styles')
</head>
