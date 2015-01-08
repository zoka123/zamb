<div class="form-group {{{ $additionalClass }}}">

    <label
        class="control-label"
        for="@if(!empty($name)) {{{ $type }}} @endif">
            @if(!empty($label)) {{{ $label }}} @endif
    </label>

    <select
        class="form-control @if(!empty($class)) {{{ $class }}} @endif"
        @if(!empty($multiple)) multiple="multiple" @endif
        @if(!empty($name))
            id="{{{ $name }}}"
            name="{{{ $name }}}"
        @endif >
            @foreach($options as $value => $label)
                <option
                    @if(!empty($multiple))
                        @if(!empty($selectedValue) && in_array($value, $selectedValue)) selected="selected" @endif
                    @else
                        @if(!empty($selectedValue) && $value == $selectedValue) selected="selected" @endif
                    @endif
                    value="{{{ $value  }}}"> {{{ $label }}}</option>
            @endforeach
    </select>

    @if(!empty($errMsg))
          {{ $errMsg }}
    @endif
</div>