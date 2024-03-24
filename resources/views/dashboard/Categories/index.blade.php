@extends('layouts.dashboard')


@section('title','Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Add Category</a>
    </div>
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @if($categories->count())
        @foreach($categories as $category)
        <tr>
            <td><img src="{{asset('storage/'.$category->image)}}" alt="image" height="50" width="50"></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post" >
                    @csrf
                    <!-- ***Form Method Spoofing -->
{{--                   (1) <input type="hidden" name="_method" value="delete">--}}
                    <!--(2)-->@method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="7">
                    No Categories Defined.
                </td>
            </tr>
        @endif
    </tbody>
</table>
@endsection
