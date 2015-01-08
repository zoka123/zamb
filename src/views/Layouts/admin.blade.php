@extends('zamb::Layouts.default')

@section('stylesheets')
    @parent
    <link rel="stylesheet"
          href="//cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2-bootstrap.min.css">

@stop

@section('scripts')
    @parent

    <script type="text/javascript" language="javascript"
            src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="//cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript"
            src="//cdn.datatables.net/plug-ins/725b2a2115b/api/fnReloadAjax.js"></script>
    <script type="text/javascript" language="javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js"></script>

    <script type="text/javascript" language="javascript" src="{{asset('assets/js/application.js')}}"></script>
@stop
