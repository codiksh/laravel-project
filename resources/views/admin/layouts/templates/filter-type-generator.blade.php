<div class="row">
    <div class="col-sm-3">
        {!! Form::select("{$filterName}_type", ['In' => 'IN', 'NotIn' => 'NOT IN'], ['IN'], ['class' => 'form-control filter','id' => "{$filterName}_type"]) !!}
    </div>
    <div class="col-sm-9">
        {!! $input !!}
    </div>
</div>
