<div class="radio">
    {!! Form::radio('gender', 'woman', true) !!}
    {{ Form::label($name, $value, ['class' => 'control-label', 'for'=> 'radio2']) }}
    <label for="radio2">Homme</label>
</div>