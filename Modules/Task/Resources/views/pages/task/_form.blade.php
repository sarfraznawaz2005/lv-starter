@if (isset($task) && $task->exists)
    {!! Former::open_for_files()->action(route('task.update', $task))->method('put')->class('validate') !!}
    {{--{!! Former::setOption('automatic_label', false) !!}--}}
    {!! Former::populate($task) !!}
@else
    {!! Former::open_for_files()->action(route('task.store'))->method('post')->class('validate') !!}
@endif

{!! Former::text('description', 'Task Description')->required() !!}

@if (isset($task) && $task->file)
    <img src="{!! $task->imageUrl('file') !!}" alt="Image">
@endif

{!! Former::file('file', 'Optional Image')->accept('image/jpeg', 'image/png')->max(2, 'MB') !!}

<div class="card-footer border-light">
    @button
    <i class="fa fa-save"></i> Save
    @endbutton
</div>

{!! Former::close() !!}

