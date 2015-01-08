<div class="form-group {{{ $additionalClass }}}">

    <label
        class="control-label"
        for="@if(!empty($name)) {{{ $type }}} @endif">
            @if(!empty($label)) {{{ $label }}} @endif
    </label>

    <textarea

        class="form-control @if(!empty($class)) {{{ $class }}} @endif"
            @if(!empty($name))
                id="{{{ $name }}}"
                name="{{{ $name }}}"
            @endif

        rows="{{{ $rows or 4 }}}">{{{ Input::old( $name, $model->$name )}}}</textarea>

    @if(!empty($errMsg))
          {{ $errMsg }}
    @endif
</div>