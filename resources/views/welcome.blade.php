@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="content">
        <div class="links m-b-md">
            <a href="{{ route('users.index') }}">Users</a>
            <a href="{{ route('drives.index') }}">Drives</a>
        </div>
    </div>
@stop


