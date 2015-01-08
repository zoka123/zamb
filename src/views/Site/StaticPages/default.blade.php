@extends('zamb::Layouts.default')

@section('content')
    @parent
    @include('Navigation.menu')

    <div class="container">

        <h1>{{{ $page->title }}}</h1>
        <hr>
        <div class="static-page-content col-xs-12">
            {{ $page->body }}
        </div>

    </div>

@stop

@section('scripts')
    @parent

@stop
