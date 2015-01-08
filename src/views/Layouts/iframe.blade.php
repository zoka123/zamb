@extends('zamb::Layouts.admin')

@section('stylesheets')
    @parent
    <style>
        body {
            padding: 15px;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid text-right clearfix">
        <div class="col-sm-12">
            <a href="javascript:void(0);" class="iframe-close btn btn-primary btn-sm"
               onclick="parent.modal.modal('toggle')">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>

    <div class="modal-body">
        @yield('iframe-body')
    </div>

@stop