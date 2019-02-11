{{-- bootstrap button component --}}

@php
    $type = $type ?? 'submit';
    $class = $class ?? 'success';

    # this only shows what these passed variable values can be
    assert(in_array($type, ['button', 'submit']));
    assert(in_array($class, ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'default']));
@endphp

<button type="{{$type}}" class="btn btn-{{$class}}">
    {{$slot}}
</button>
