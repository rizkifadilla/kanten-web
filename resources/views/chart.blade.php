@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="content">
                <div id="chart">
                {!! $data->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! $data->script() !!}

@endsection