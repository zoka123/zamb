@extends('zamb::Layouts.crud-index')

@section('content')
    @parent
    @include('zamb::menu.admin-menu')


    <div class="container">

        <div class="notifications"></div>

        <div class="text-right">
            <button class="btn btn-success" data-toggle="iframe-modal"
                    data-iframe-src="{{ URL::route('Admin.Roles.Create') }}">
                <i class="fa fa-plus"></i> {{{ Lang::get('zamb::button.create') }}}
            </button>
        </div>
        <hr>

        <table class="datatables table">
            <thead>
            <tr>
                <th>{{{ Lang::get('zamb::Admin/Roles/table.name') }}}</th>
                <th>{{{ Lang::get('zamb::Admin/table.created_at') }}}</th>
                <th class="actions-column">{{{ Lang::get('zamb::table.actions') }}}</th>
            </tr>
            </thead>
        </table>
    </div>

@stop

@section('scripts')
    @parent
    <script>
        var oTable = initDatatables($('.datatables'), "{{ URL::to('admin/roles/data') }}");
    </script>
@stop
