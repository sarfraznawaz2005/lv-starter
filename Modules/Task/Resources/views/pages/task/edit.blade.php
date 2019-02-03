@extends('main::layouts.master')

@section('content')

    @card(['type' => 'white', 'header_type' => 'light', 'classes' => 'mb3'])
    @slot('header')
        <div class="pull-left">
            <a href="{{route('task.index')}}" class="btn btn-secondary">
                <i class="fa fa-arrow-circle-left"></i> Back to Tasks
            </a>
        </div>
        <div class="clearfix"></div>
    @endslot

    @include('task::pages.task._form')

    @endcard

@endsection
