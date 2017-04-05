@extends('layouts.master')

@section('title', 'Requests friends')

@section('content')
    <div class="content-wrap">
        <main id="content" class="content" role="main">
            <div class="row" data-toggle="isotope">
                <div class="col-md-12 col-lg-12">
                    @include('friends.partials.friend')
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
@endsection