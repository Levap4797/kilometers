@extends('layouts.app')

@section('title', 'Users')

@section('content')


<form action='/change_password' method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" class="form-control"/>
    </div>

    <div class="form-group">
        <label>Confirm Password</label>
        <input type="text" name="confirmed_password" class="form-control"/>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@stop
