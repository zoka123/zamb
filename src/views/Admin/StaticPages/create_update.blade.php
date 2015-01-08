@extends('zamb::Layouts.iframe')

@section('iframe-body')
<div class="container ">

@if(!empty($model->id))
{{-- UPDATE --}}
{{ Form::model($model, array('route' => array('Admin.StaticPages.Update', $model->id))) }}
@else
{{-- NEW --}}
{{ Form::model($model, array('route' => array('Admin.StaticPages.Store', $model->id))) }}
@endif

    @include('zamb::Form.input', array(
        'label'=>'Title',
        'type'=>'text',
        'placeholder'=>'Title',
        'name'=>'title',
    ))

    @include('zamb::Form.input', array(
            'label'=>'Slug',
            'type'=>'text',
            'placeholder'=>'Slug',
            'name'=>'slug',
        ))

    @include('zamb::Form.input', array(
        'label' => 'Body',
        'type' => 'textarea',
        'class' => 'full-width wysihtml5',
        'rows' => 6,
        'placeholder' => 'Body',
        'name' => 'body',
    ))

    @include('zamb::Form.input', array(
            'label'=>'Active',
            'type'=>'select',
            'name'=>'active',
            'options' => array("No", "Yes"),
            'selectedValue' => Input::old('active', isset($model) ? $model->active : 0)
        ))

    <hr>

    <button type="submit" class="btn btn-success">
    <i class="fa fa-check"></i> {{{ Lang::get('zamb::button.submit') }}}
    </button>

    <input type="hidden" name="iframe" value="1"/>
{{ Form::close() }}
</div>

<script src="//cdn.ckeditor.com/4.4.5/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'body' );
</script>
@stop
