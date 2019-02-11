{{-- bootstrap card component --}}

@php
    $type = $type ?? 'white';
    $header_type = $header_type ?? 'light';
    $border_type = $border_type ?? '';

    # this only shows what these passed variable values can be
    assert(in_array($type, ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'white']));
    assert(in_array($header_type, ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'white']));
    assert(in_array($border_type, ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'white', ''], true));
@endphp

<div class="card bg-{{$type}} border-{{$border_type}} {{$classes ?? ''}}" {!! $extra_attribs ?? '' !!}>
    @if(isset($header))
        <div class="card-header bg-{{$header_type}} {{$header_classes ?? ''}}" {!! $header_extra_attribs ?? '' !!}>
            {{$header}}
        </div>
    @endif

    <div class="card-body {{$body_classes ?? ''}}" {!! $body_extra_attribs ?? '' !!}>
        {{$slot}}
    </div>

    @if(isset($footer))
        <div class="card-footer">
            {{$footer}}
        </div>
    @endif
</div>
