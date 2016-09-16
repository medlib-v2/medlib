@extends('layouts.master') 

@section('title', 'Nous Contacter') 

@section('content')
<div class="container-fluid animated fadeInUp" style="margin-top: 20px;">

    <h1>Nous contacter</h1>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @include('flash.message')
    {!! Form::open(array('route' => 'contact.store', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('Votre nom') !!}
        {!! Form::text('name', null, 
            array('required', 'class'=>'form-control',  'placeholder'=>'Votre nom')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Votre email') !!}
        {!! Form::text('email', null, 
            array('required', 'class'=>'form-control', 'placeholder'=>'Votre email')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Votre Message') !!}
        {!! Form::textarea('message', null, 
            array('required', 'class'=>'form-control', 'placeholder'=>'Votre message')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Contacter nous!', 
        array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
</div>
@endsection 