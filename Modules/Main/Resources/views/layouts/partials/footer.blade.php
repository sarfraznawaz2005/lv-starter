<div class="clearfix">&nbsp;</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">&copy; {{date('Y')}} <a href="/">{{appName()}}</a> - All rights reserved.</p>
    </div>
</footer>

{{-- IE es6 pollyfill --}}
@if(Browser::isIE())
    <script src="/modules/core/js/pollyfills.js"></script>
@endif

<!-- Scripts -->
<script src="{{mix('/js/app.js')}}"></script>
<script src="/modules/main/js/custom.js"></script>

@stack('scripts')

@include('noty::view')

@livewireAssets
