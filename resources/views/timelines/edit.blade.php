@extends('layouts.master')

@section('title', 'Timeline')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Timeline</h1>
            </div>
        </div>

        @include('vendor.common.errors')

        <div class="row">
            {!! Form::model($timeline, ['route' => ['timelines.update', $timeline->id], 'method' => 'patch']) !!}

            @include('timelines.fields')

            {!! Form::close() !!}
        </div>
@endsection