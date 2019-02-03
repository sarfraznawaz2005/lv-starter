<div class="card bg-{{$type ?? 'light'}} border-{{$border_type ?? ''}} {{$classes ?? ''}}" {{$extra_attribs ?? ''}}>
    @if(isset($header))
        <div class="card-header bg-{{$header_type ?? 'light'}} {{$header_classes ?? ''}}" {{$header_extra_attribs ?? ''}}>
            {!! $header !!}
        </div>
    @endif

    <div class="card-body {{$body_classes ?? ''}}" {{$body_extra_attribs ?? ''}}>{!! $slot !!}</div>

    @if(isset($footer))
        <div class="card-footer">{!! $footer !!}</div>
    @endif
</div>