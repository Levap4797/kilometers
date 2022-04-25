@extends('layouts.app')

@section('title', 'Users')


<?php


    if (empty($user)) {
        $action = '/users';
        $buttonName = 'Create';
    } else {
        $action = '/users/' . $user->id;
        $buttonName = 'Update';
    }


?>

@section('content')

<form action="{{ $action }} " method="POST">
    {{ csrf_field() }}
    @if (!empty($user))
        @method('PUT')
    @endif
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{isset($user) ? $user->name : ''}}"/>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="{{isset($user) ? $user->email : ''}}"/>
    </div>
    @if (empty($user))
    <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" class="form-control"/>
    </div>
    @endif
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@stop
