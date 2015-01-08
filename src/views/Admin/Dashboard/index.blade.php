@extends('zamb::Layouts.admin')

@section('content')
    @parent
    @include('zamb::menu.admin-menu')


    <div class="container">

        <div class="notifications"></div>


    </div>

@stop

@section('scripts')
    @parent

@stop
