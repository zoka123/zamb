@extends('zamb::Layouts.iframe')

@section('iframe-body')
<div class="container text-center">

{{-- DELETE --}}
<div class="well">
<p>
<b>Are you sure ?</b><br/>
This action cannot be reverted
</p>
</div>
{{ Form::model($model, array('route' => array('Admin.StaticPages.Destroy', $model->id))) }}
       <button type="submit" class="btn btn-primary">Delete</button>
       <a onclick="parent.modal.modal('hide');" class="btn btn-default">Cancel</a>
{{ Form::close() }}
</div>
@stop
