{{-- bootstrap modal component --}}

<!-- general modal start -->
<div id="{{$id}}" class="modal fade" tabindex="-1" role="dialog" style="z-index: 99999;">
    <div class="modal-dialog {{isset($wide) ? 'modal-xl' : ''}}">
        <div class="modal-content">
            <div class="modal-header {{$header_class ?? ''}}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title">
                    {!! $title_icon ?? '' !!}
                    {{$title}}
                </h4>
            </div>

            <div class="modal-body" style="padding: 0 20px 5px 20px;">
                {{$slot}}
            </div>

            <div class="modal-footer" style="padding: 7px 10px 5px 10px;">
                {!! $button ?? '' !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- general modal end -->

<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 70%;
            max-width: 1200px;
        }
    }
</style>
