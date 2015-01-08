<?php

// Prepare additional container classes
$additionalClass = '';

if(!empty($name) && !empty($errors) && $errors->first($name)){
    $additionalClass .= 'has-error';
    $errMsg = $errors->first($name, '<span class="control-label help-inline">:message</span>');
    }
?>

@if($type == 'checkbox')
    {{-- Load checkbox specific file --}}
    @include('Form.checkbox')

@elseif($type == 'select')
    {{-- Load checkbox specific file --}}
    @include('Form.select')

@elseif($type == 'textarea')
    {{-- Load checkbox specific file --}}
    @include('Form.textarea')

@else
    {{-- Render standard input --}}
    <div class="form-group {{{ $additionalClass }}}">
        <label
            class="control-label"
            for="@if(!empty($name)) {{{ $type }}} @endif">
                @if(!empty($label)) {{{ $label }}} @endif
        </label>

        <input
            @if(!empty($type)) type="{{{ $type }}}" @endif
            class="form-control"
            @if(!empty($name))
                id="{{{ $name }}}"
                name="{{{ $name }}}"
                @unless(!empty($skipOldInputs) && $skipOldInputs)
                    value="{{{ Input::old( $name, $model->$name ) }}}"
                @endunless
            @endif

            @if(!empty($placeholder)) placeholder="{{{ $placeholder  }}}" @endif
            @if(!empty($additional)) {{ $additional }} @endif />

        @if(!empty($errMsg))
            {{ $errMsg }}
        @endif
    </div>
@endif