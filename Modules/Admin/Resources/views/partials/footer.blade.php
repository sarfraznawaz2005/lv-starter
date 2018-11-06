<!-- Scripts -->
<script src="{{mix('/js/app.js')}}"></script>
<script src="/modules/admin/js/custom.js"></script>

@stack('scripts')

@include('noty::view')

@if (config('core.settings.enable_socket'))
    @include('core::shared.socket')
@endif

