@extends('layouts.master')

@section('title', settings('site_title').' | '.settings('site_tagline'))

@section('class') container-fluid @endsection

@section('content')
    <main id="content" class="content content-profile" role="main">
        <section class="user-profile">
            <div class="container-fluid">
            @include('flash.message')
            <!-- main-section -->
                <!-- <div class="main-content"> -->
                <div class="container">
                    <div class="row">
                        <div class="visible-lg col-lg-2">
                            @include('timelines.partials.home-leftbar', compact('trending_tags'))
                        </div>

                        <div class="col-md-7 col-lg-6">
                            @if (Session::has('message'))
                                <div class="alert alert-{{ Session::get('status') }}" role="alert">
                                    {!! Session::get('message') !!}
                                </div>
                            @endif


                            @if(isset($active_announcement))
                                <div class="announcement alert alert-info">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <h3>{{ $active_announcement->title }}</h3>
                                    <p>{{ $active_announcement->description }}</p>
                                </div>
                            @endif
                            @include('timelines.partials.create-post', compact('timeline'))

                            <div class="timeline-posts">
                                @if($posts->count() > 0)
                                    @foreach($posts as $post)
                                        @include('timelines.partials.post', compact('post','timeline','next_page_url'))
                                    @endforeach
                                @else
                                    <div class="no-posts alert alert-warning">{{ trans('common.no_posts') }}</div>
                                @endif
                            </div>
                        </div><!-- /col-md-6 -->

                        <div class="col-md-5 col-lg-4">
                            @include('timelines.partials.home-rightbar', compact('suggested_users', 'suggested_groups', 'suggested_pages'))
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!-- /main-section -->
            </div>
        </section>
    </main>
@endsection

@section('script')
@endsection