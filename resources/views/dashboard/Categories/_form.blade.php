@if($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured!</h3>
        <ul>
           @foreach($errors->all() as $error)
               <li>{{$error}}</li>
           @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
{{--    <label for="" >Category Name</label>--}}
{{--    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{old('name',$category->name)}}">--}}
{{--    @error('name')--}}
{{--        <div class="invalid-feedback">--}}
{{--            {{$message}}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--  we will do blade components  --}}
    <x-form.input label="Category Name" name="name" class="form-control" value="{{$category->name}}" type="text"/>
</div>
<div class="form-group">
    <label for="" >Category Parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach($parents as $parent)
            <option value="{{$parent->id}}" @selected(old('parent_id', $category->parent_id)==$parent->id)>{{$parent->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
{{--    <label for="" >Category Description</label>--}}
    <x-form.textarea label="Category Description" name="description" class="form-control" value="{{$category->description}}"/>
{{--    <textarea name="description" class="form-control"> {{old('description', $category->description)}}</textarea>--}}
</div>
<div class="form-group">
{{--    <label for="" >Category Image</label>--}}
    <x-form.input label="Category Image" name="image" class="form-control" accept="image/*" type="file"/>
{{--    <input type="file" name="image" class="form-control" accept="image/*">--}}
    @if($category->image)
        <img src="{{asset('storage/'.$category->image)}}" alt="image" height="100" width="50">
    @endif
</div>
<div class="form-group">
    <label for="" >Category Status</label>
    <x-form.radio name="status" checked="{{$category->status}}" :options="['active'=>'Active','archived'=>'Archived']" />
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" type="radio" name="status"  value="active" @checked(old('status',$category->status)=='active')>--}}
{{--        <label class="form-check-label" >--}}
{{--            Active--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" type="radio" name="status"  value="archived" @checked(old('status',$category->status)=='archived')>--}}
{{--        <label class="form-check-label">--}}
{{--            Archived--}}
{{--        </label>--}}
{{--    </div>--}}
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{$button_label}}</button>
</div>
