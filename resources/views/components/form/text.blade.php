<div class="form-group @if (isset($errors) and $errors->has($name)) has-error @endif">
    {{ Form::label($name, null, ['class' => 'control-label']) }}
    {!! Form::text($name, old($name), array_merge(['class' => 'form-control input-lg'], $attributes)) !!}
    @if (isset($errors) and $errors->has($name)) <p class="help-block">{{ $errors->first($name) }}</p> @endif
</div>

<!--
[
        'placeholder' => 'login',
        'class' => 'form-control input-lg',
        'pattern'=> '[a-zA-Z0-9]{2,64}',
        'required' => 'required',
        'tabindex' => 3])
-->