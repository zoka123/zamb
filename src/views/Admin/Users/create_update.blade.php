@extends('zamb::Layouts.iframe')

@section('iframe-body')
<div class="container ">

@if(!empty($model->id))
{{-- UPDATE --}}
{{ Form::model($model, array('route' => array('Admin.Users.Update', $model->id))) }}
@else
{{-- NEW --}}
{{ Form::model($model, array('route' => array('Admin.Users.Store', $model->id))) }}
@endif

    @include('zamb::Form.input', array(
        'label'=>'Username',
        'type'=>'text',
        'placeholder'=>'Username',
        'name'=>'username',
    ))

    @include('zamb::Form.input', array(
        'label'=>'Password',
        'type'=>'password',
        'placeholder'=>'Password',
        'name'=>'password',
        'skipOldInputs' => true,
    ))

    @include('zamb::Form.input', array(
        'label'=>'Password Confirmation',
        'type'=>'password',
        'placeholder'=>'Password Confirmation',
        'name'=>'password_confirmation',
        'skipOldInputs' => true,
    ))

    @include('zamb::Form.input', array(
        'label'=>'Email',
        'type'=>'email',
        'placeholder'=>'Email',
        'name'=>'email',
    ))

    @include('zamb::Form.input', array(
        'label'=>'Role',
        'type'=>'select',
        'name'=>'roles[]',
        'options' => $roles,
        'selectedValue' => Input::old('roles', isset($model) ? $model->getRelatedIDs('roles') : null),
        'class' => 'select2',
        'multiple' => 'multiple',
    ))

    @include('zamb::Form.input', array(
        'label'=>'Confirmed',
        'type'=>'select',
        'name'=>'confirmed',
        'options' => array("No", "Yes"),
        'selectedValue' => Input::old('confirmed', isset($model) ? $model->confirmed : 0)
    ))

    <hr>

    <button type="submit" class="btn btn-success">
    <i class="fa fa-check"></i> {{{ Lang::get('zamb::button.submit') }}}
    </button>

    <input type="hidden" name="iframe" value="1"/>
{{ Form::close() }}
</div>
@stop
