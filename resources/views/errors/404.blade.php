@extends('layouts.master')

@section('title', 'Page not found')

@section('class') container-fluid be-error-404 @endsection

@section('content')
    <main id="content" class="error-container" role="main">
        <section class="error-container">
            <div class="error-number">404</div>
            <div class="error-description">Opps, il semble que cette page n'existe pas.</div>
            <div class="error-goback-text">Would you like to go home?</div>
            <div class="error-goback-button"><a href="{{ route('home') }}" class="btn btn-xl btn-primary">Let's go home</a></div>
        </section>
    </main>
@endsection

