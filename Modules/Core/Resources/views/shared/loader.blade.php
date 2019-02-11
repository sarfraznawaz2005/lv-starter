@push('styles')
    <style>
        .loading-indicator-with-overlay {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0
        }

        .loading-indicator-with-overlay:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .3)
        }

        .loading-indicator-with-overlay:not(:required) {
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0
        }

        .loading-indicator-with-overlay:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -.5em;
            -webkit-animation: spinner 1.5s infinite linear;
            -moz-animation: spinner 1.5s infinite linear;
            -ms-animation: spinner 1.5s infinite linear;
            -o-animation: spinner 1.5s infinite linear;
            animation: spinner 1.5s infinite linear;
            border-radius: .5em;
            -webkit-box-shadow: rgba(0, 0, 0, .75) 1.5em 0 0 0, rgba(0, 0, 0, .75) 1.1em 1.1em 0 0, rgba(0, 0, 0, .75) 0 1.5em 0 0, rgba(0, 0, 0, .75) -1.1em 1.1em 0 0, rgba(0, 0, 0, .5) -1.5em 0 0 0, rgba(0, 0, 0, .5) -1.1em -1.1em 0 0, rgba(0, 0, 0, .75) 0 -1.5em 0 0, rgba(0, 0, 0, .75) 1.1em -1.1em 0 0;
            box-shadow: rgba(0, 0, 0, .75) 1.5em 0 0 0, rgba(0, 0, 0, .75) 1.1em 1.1em 0 0, rgba(0, 0, 0, .75) 0 1.5em 0 0, rgba(0, 0, 0, .75) -1.1em 1.1em 0 0, rgba(0, 0, 0, .75) -1.5em 0 0 0, rgba(0, 0, 0, .75) -1.1em -1.1em 0 0, rgba(0, 0, 0, .75) 0 -1.5em 0 0, rgba(0, 0, 0, .75) 1.1em -1.1em 0 0
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0);
                -moz-transform: rotate(0);
                -ms-transform: rotate(0);
                -o-transform: rotate(0);
                transform: rotate(0)
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0);
                -moz-transform: rotate(0);
                -ms-transform: rotate(0);
                -o-transform: rotate(0);
                transform: rotate(0)
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0);
                -moz-transform: rotate(0);
                -ms-transform: rotate(0);
                -o-transform: rotate(0);
                transform: rotate(0)
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0);
                -moz-transform: rotate(0);
                -ms-transform: rotate(0);
                -o-transform: rotate(0);
                transform: rotate(0)
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        /* for BS validator */

        .help-block {
            display: block;
            margin-top: .25rem;
            font-size: .875rem;
            color: #dc3545;
        }

        .has-error .help-block {
            color: #dc3545;
        }

        .has-error .col-form-label {
            color: #dc3545;
        }

        .has-error .form-control {
            border-color: #dc3545;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        /* add spacing in content divs of tabs of bootstrap */
        .tab-content .tab-pane {
            margin: 15px 0;
        }
    </style>
@endpush

<div class="loading-indicator-with-overlay">Loading&#8230;</div>

@push('scripts')
    <script>
        $(document).ready(hideLoader);

        function showLoader() {
            $('.loading-indicator-with-overlay').show();
        }

        function hideLoader() {
            $('.loading-indicator-with-overlay').hide();
        }
    </script>
@endpush
