@extends('layouts.master')

@section('title', 'Profile '. Auth::user()->getName())

@section('content')
    <div id="content" class="content" role="main">
        <div id="page-content" class="container">
            <br>
            <div class="row">
                Public Profile
            </div>
        </div>
    </div>
@endsection