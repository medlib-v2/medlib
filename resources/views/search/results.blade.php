@extends('layouts.master')

@section('title', 'Result of search')

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <div class="row">
                <!-- Starting filter -->
                @include('search.filters.mfilter')
                <!-- Ending filter -->
                <!-- Beginning content search -->
                @include('search.contents.content')
                <!-- Ending content search -->
            </div>
        </div>
    </div>
@endsection