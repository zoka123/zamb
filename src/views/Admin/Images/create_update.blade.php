@extends('zamb::Layouts.iframe')

@section('iframe-body')
<div class="container ">

    @if(!empty($model->id))
    {{-- UPDATE --}}
    <div class="text-center">
        <img src="{{{ \Helpers\ImageHelper::getImageUrlById($model->id, 'thumbnail') }}}"/>
    </div>
    {{ Form::model($model, array('route' => array('Admin.Images.Update', $model->id), 'files' => true)) }}
    @else
    {{-- NEW --}}
    {{ Form::model($model, array('route' => array('Admin.Images.Store', $model->id), 'files' => true)) }}
    @endif

    @include('Form.input', array(
    'label'=>'Title',
    'type'=>'text',
    'placeholder'=>'Title',
    'name'=>'title',
    ))

    @include('Form.input', array(
    'label'=>'Caption',
    'type'=>'text',
    'placeholder'=>'Caption',
    'name'=>'caption',
    ))

    @include('Form.input', array(
    'label'=>'File',
    'type'=>'file',
    'name'=>'file',
    'additional' => ' multiple="false" ',
    ))

    <hr>

    <button type="submit" class="btn btn-success">
        <i class="fa fa-check"></i> {{{ Lang::get('button.submit') }}}
    </button>

    <input type="hidden" name="iframe" value="1"/>
    {{ Form::close() }}
</div>
@stop
