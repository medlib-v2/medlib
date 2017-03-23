@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New Timeline</h1>
        </div>
    </div>

    @include('vendor.common.errors')

    <div class="row">
        {!! Form::open(['route' => 'timelines.store']) !!}

            @include('timelines.fields')

        {!! Form::close() !!}
    </div>
@endsection