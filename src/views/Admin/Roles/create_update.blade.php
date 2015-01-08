@extends('zamb::Layouts.iframe')

@section('iframe-body')
<div class="container ">

@if(!empty($model->id))
{{-- UPDATE --}}
{{ Form::model($model, array('route' => array('Admin.Roles.Update', $model->id))) }}
@else
{{-- NEW --}}
{{ Form::model($model, array('route' => array('Admin.Roles.Store', $model->id))) }}
@endif

    @include('zamb::Form.input', array(
        'label'=>'Name',
        'type'=>'text',
        'placeholder'=>'Name',
        'name'=>'name',
    ))

    @include('zamb::Form.input', array(
        'label'=>'Permissions',
        'type'=>'select',
        'name'=>'perms[]',
        'options' => $permissions,
        'selectedValue' => Input::old('perms', isset($model) ? $model->getRelatedIDs('perms') : null),
        'class' => 'select2',
        'multiple' => 'multiple',
    ))

    <hr>

    <button type="submit" class="btn btn-success">
    <i class="fa fa-check"></i> {{{ Lang::get('zamb::button.submit') }}}
    </button>

    <input type="hidden" name="iframe" value="1"/>
{{ Form::close() }}
</div>
@stop
