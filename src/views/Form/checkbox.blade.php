<div class="{{{ $additionalClass }}}">
  <div class="radio">
    <label class="checkbox control-label">
      <input
        type="checkbox"
        @if($checked) checked @endif
        @if(!empty($name))
            name="{{{ $name }}}"
            id="{{{ $name }}}"
            value="true" >
        @endif
        @if(!empty($label)) {{{ $label }}} @endif
    </label>
  </div>
  @if(!empty($errMsg))
      {{ $errMsg }}
  @endif
</div>