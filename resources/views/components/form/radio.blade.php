@props([
    'name','options','checked'
])

@foreach($options as $value => $text)
    <div class="form-check">
        <input {{$attributes}}
               type="radio" name="{{$name}}"  value="{{$value}}"
            @checked(old($name,$checked)==$value)
        >
        <label class="form-check-label" >
{{--            Active--}}
            {{$text}}
        </label>
    </div>
@endforeach

