<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta name="author" content="Sarfraz Ahmed">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{Meta::get('title') . ' :: ' . appName()}}</title>

    <link rel="shortcut icon" href="/tools.ico">

    <link rel="stylesheet" href="/modules/crud/css/bootstrap/css/theme.min.css">
    <link rel="stylesheet" href="/modules/crud/css/bootstrap/css/custom.css">
    <link rel="stylesheet" href="/modules/core/css/loader.css">
    <link rel="stylesheet" href="/modules/crud/css/custom.css">

    @stack('styles')
</head>
