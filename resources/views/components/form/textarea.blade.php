@props([
    'name','value','label'
])

<label for="" >{{$label}}</label>
<textarea
    name="{{$name}}"
    {{$attributes}}  {{-- عشان باقي الحاجات البتتحط في الinput--}}
    @error($name) is-invalid @enderror"

>{{old($name,$value)}}</textarea>
@error($name)
<div class="invalid-feedback">
    {{$message}}
</div>
@endif
