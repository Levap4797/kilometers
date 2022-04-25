@extends('layouts.app')

@section('title', 'Kilometers')


<?php

    if (empty($drive)) {
        $action = '/drives';
        $buttonName = 'Create';
    } else {
        $action = '/drives/' . $drive->id;
        $buttonName = 'Update';
    }


?>

@section('content')

<form action="{{ $action }}" method="POST">
    @if (!empty($drive))
        @method('PUT')
    @endif
    {{ csrf_field() }}
    <div class="form-group">
        <label>Kilometers</label>
        <input type="text" name="kilometers" class="form-control" value="{{isset($drive) ? $drive->kilometers : ''}}"/>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@stop
