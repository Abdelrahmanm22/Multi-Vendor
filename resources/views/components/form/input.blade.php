@props([
    'type'=>'','name','value'=>'','label'=>''
])

@if($label)
    <label for="" >{{$label}}</label>
@endif
<input
    type="{{$type}}"
    name="{{$name}}"
    {{$attributes}}  {{-- عشان باقي الحاجات البتتحط في الinput--}}
    @error($name) is-invalid @enderror
    value="{{old($name,$value)}}"
>
@error($name)
<div class="invalid-feedback">
    {{$message}}
</div>
@endif
