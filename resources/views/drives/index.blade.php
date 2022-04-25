<?php

$data = collect($table->getPaginator()->items())->toJson();
?>
@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-flex pl-3 py-1 export-action">
        <button onclick="Export()"
           class="btn btn-warning"
           title="Export">
            {!! config('laravel-table.icon.create') !!}
            Export Table
        </button>
    </div>

    {{ $table }}

    <script>
        const DATA = JSON.parse('<?php echo $data ?>');
        function Export()
        {
            console.log('Clicked');
            // var serialisedData = sessionStorage.getItem('data');
            var post = {
                "_token": "{{ csrf_token() }}",
                data: DATA
            };
            var xhr = new XMLHttpRequest();
            xhr.open("POST", '/export', true);
            xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')

            xhr.responseType = "blob";
            xhr.onload = function (event) {
                var blob = xhr.response;
                var link=document.createElement('a');
                link.href=window.URL.createObjectURL(blob);
                link.click();
            };

            xhr.send(JSON.stringify(post));
        }

        {{--window.addEventListener('DOMContentLoaded', (event) => {--}}
        {{--    sessionStorage.removeItem('data');--}}
        {{--    sessionStorage.setItem('data', '<?php echo $data ?>');--}}
        {{--});--}}
    </script>
@stop
