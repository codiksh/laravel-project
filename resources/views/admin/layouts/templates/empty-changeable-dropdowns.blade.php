<div class="drop-down">
    <a href='javascript:void(0);' data-toggle='dropdown' role="button" id="{{ "$changeable-$model->uuid" }}"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="{{ $changeTriggererClass }}">
        {!! ($displayVal == '' ? 'Update ' . \Illuminate\Support\Str::title($changeable) : $displayVal) !!}
    </a>
    <div class="dropdown-menu" aria-labelledby="{{ "$changeable-$model->uuid" }}" style="max-height: 300px; overflow-y: auto"></div>
</div>
