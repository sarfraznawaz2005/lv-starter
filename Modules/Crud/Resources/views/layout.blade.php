@include('crud::partials/head')

<body class="animated fadeIn">

<div class="container" style="margin-top: 20px; padding: 0;" id="app">
    <div class="row">
        <div class="col-md-12">

            @section('main_crud_panel.component_panel_content')
                @include('flash::message')
                @include('core::shared.errors')

                @yield('content')
            @endsection

            @include('core::components.panel', [
                'id' => 'main_crud_panel',
                'panel_type' => 'default',
                'panel_heading' => '<h1><a href="/"><i class="glyphicon glyphicon-th"></i> '.appName().'</a></h1>',
                'show_panel_footer' => false,
            ])
        </div>
    </div>
</div>

@include('crud::partials/footer')
