@extends('layouts.master')

@section('title', 'Result of search')

@section('content')
    <div class="content">
        <main id="content" class="content" role="main">
            <div id="" class="page-container">
                <div class="row">
                    <!-- Starting filter -->
                    @include('search.filters.mfilter')
                    <!-- Ending filter -->
                    <!-- Beginning content search -->
                    @include('search.contents.content')
                    <!-- Ending content search -->
                </div>
            </div>
        </main>
    </div>
@endsection