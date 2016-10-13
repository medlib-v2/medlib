@extends('layouts.dashboards.dashboard')

@section('title', 'Results search')

    @section('content')
        <div class="content-wrap">
            <main id="content" class="content" role="main">
                @if(!$users->count())

                    <p>No results found.</p>
                @else

                    <div class="row" data-toggle="isotope">
                        <div class="col-md-12 col-lg-12">
                        @foreach($users as $user)

                            @include('dashboard.searchs.users')

                        @endforeach
                        </div>
                    </div>
                @endif
            </main>
        </div>
    @endsection

@section('script')
@endsection