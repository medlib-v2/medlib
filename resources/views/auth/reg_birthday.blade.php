@extends('layouts.master')

@section('content')
<div id="site-container" class="context-loader-container">
    <div id="page-content" class="container">
        <div id="section_header"></div>
        @if (isset($errors) and $errors->has())
            <div class="alert alert-danger" role="alert">
                <strong>Whoops!</strong> {{ trans('messages.problems_with_input') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>Pourquoi votre date de naissance</h2>
        Votre date de naissance garantit que votre expérience Medlib est adaptée à votre âge. Pour changer qui peut voir ça, allez dans la section À propos de votre profil. Pour en savoir plus, consultez notre Politique d’utilisation des données.
    </div><!-- and div content -->
</div><!-- and div context-loader-container -->
@endsection