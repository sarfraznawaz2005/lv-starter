{{-- IE es6 pollyfill --}}
@if(Browser::isIE())
    <script src="/modules/core/js/pollyfills.js"></script>
@endif

<!-- Scripts -->
<script src="{{mix('/js/app.js')}}"></script>
<script src="/modules/admin/js/custom.js"></script>

@stack('scripts')

@include('noty::view')

@livewireAssets
