@extends('layouts.dashboards.dashboard')

@section('title', 'Dashboard Books')

    @section('content')
    <div class="content-wrap">
        <main id="content" class="content" role="main">
            <ol class="breadcrumb">
                <li>DASHBOARD</li>
                <li class="active">Ma bibliothèque</li>
            </ol>
            <div class="alert alert-warning alert-sm pull-right no-margin" id="app-alert">
                <button type="button" class="ml-lg close" data-dismiss="alert" aria-hidden="true">×</button>
                Hey! This is a <span class="fw-semi-bold">real app</span> with CRUD and Search functions. Have fun!
            </div>
            <h1 class="page-title">Ma bibliothèque - <span class="fw-semi-bold">Mes livres</span></h1>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="clearfix mb-xs">
                        <a class="btn btn-default btn-sm width-50 pull-left hide" id="back-btn" href="inbox.html">
                            <i class="fa fa-angle-left fa-lg"></i>
                        </a>
                        <div class="pull-right" id="folder-stats">
                            <p class="widget-books-count">Showing 1 - 10 of 96 books</p>
                            <ul class="pagination pagination-sm widget-books-pagination">
                                <li class="prev disabled"><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="next"><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <section class="widget widget-books">
                        <header id="widget-books-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" href="#" data-toggle="dropdown">Select
                                            <i class="fa fa-angle-down "></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a id="select-all" href="#">All</a></li>
                                            <li><a id="select-none" href="#">None</a></li>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-default dropdown-toggle" href="#" data-toggle="dropdown">Actions
                                            <i class="fa fa-angle-down "></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a id="view" href="#">View</a></li>
                                            <li><a id="shared" href="#">Shared</a></li>
                                            <li><a id="archive" href="#">Archive</a></li>
                                            <li class="divider"></li>
                                            <li><a id="add" href="#">Add</a></li>
                                            <li><a id="delete" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm width-200 pull-right" id="books-search" placeholder="Search Book" type="text">
                                </div>
                            </div>
                        </header>
                        <div class="widget-body" id="books-content">
                            <table class="table table-striped table-books table-hover" id="folder-view">
                                <thead>
                                <tr>
                                    <th colspan="3">
                                        <div class="checkbox">
                                            <input id="toggle-all" type="checkbox">
                                            <label for="toggle-all"></label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="unread">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox1014958" type="checkbox">
                                            <label for="checkbox1014958"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star"></i></span></td>
                                    <td class="name hidden-xs">Philip Horbacheuski</td>
                                    <td class="subject">Hi, Welcome to Google Mail</td>
                                    <td class="hidden-xs"><i class="fa fa-paperclip"></i></td>
                                    <td class="date">18:58</td>
                                </tr>
                                <tr class="unread">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox1016274" type="checkbox">
                                            <label for="checkbox1016274"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star-o"></i></span></td>
                                    <td class="name hidden-xs">StackExchange</td>
                                    <td class="subject">New Python questions for this week!</td>
                                    <td class="hidden-xs"><i class="fa fa-paperclip"></i></td>
                                    <td class="date">Aug 14</td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox487201" type="checkbox">
                                            <label for="checkbox487201"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star-o"></i></span></td>
                                    <td class="name hidden-xs">notifications@facebook.com</td>
                                    <td class="subject">Someone just commented on your photo!</td>
                                    <td class="hidden-xs"></td>
                                    <td class="date">Aug 7</td>
                                </tr>
                                <tr class="unread">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox1866535" type="checkbox">
                                            <label for="checkbox1866535"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star"></i></span></td>
                                    <td class="name hidden-xs">Twitter</td>
                                    <td class="subject">@hackernews is now following you on Twitter</td>
                                    <td class="hidden-xs"></td>
                                    <td class="date">Jul 31</td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox748207" type="checkbox">
                                            <label for="checkbox748207"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star-o"></i></span></td>
                                    <td class="name hidden-xs">Nikola Foley</td>
                                    <td class="subject">Quiet led own cause three him</td>
                                    <td class="hidden-xs"><i class="fa fa-paperclip"></i></td>
                                    <td class="date">Jul 22</td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox1710373" type="checkbox">
                                            <label for="checkbox1710373"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star-o"></i></span></td>
                                    <td class="name hidden-xs">Ernst Hardy</td>
                                    <td class="subject">Raising say express had chiefly detract demands she</td>
                                    <td class="hidden-xs"></td>
                                    <td class="date">Jul 15</td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox685836" type="checkbox">
                                            <label for="checkbox685836"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star-o"></i></span></td>
                                    <td class="name hidden-xs">LinkedIn</td>
                                    <td class="subject">Jobs you may be interested in</td>
                                    <td class="hidden-xs"></td>
                                    <td class="date">Jul 12</td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <div class="checkbox">
                                            <input class="selected-checkbox" id="checkbox1918767" type="checkbox">
                                            <label for="checkbox1918767"></label>
                                        </div>
                                    </td>
                                    <td><span class="starred"><i class="fa fa-star"></i></span></td>
                                    <td class="name hidden-xs">Naevius Victorsson</td>
                                    <td class="subject">Front no party young abode state up</td>
                                    <td class="hidden-xs"></td>
                                    <td class="date">Jul 11</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
    @endsection

@section('script')
    @include('dashboard.scripts.books')
@endsection
