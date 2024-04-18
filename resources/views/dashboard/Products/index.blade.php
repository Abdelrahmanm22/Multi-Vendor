@extends('layouts.dashboard')


@section('title','Products')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary mr-3">Add Product</a>
{{--        <a href="{{route('dashboard.products.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>--}}
    </div>

    <x-alert/>
{{--    <x-alert type="info"/>--}}

    <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control" class="mx-3">
            <option value="">All</option>
            <option value="active" @selected(request('status')=='active')>Active</option>
            <option value="archived" @selected(request('status')=='archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">
            Filter
        </button>
    </form>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @if($products->count())
        @foreach($products as $product)
        <tr>
            <td><img src="{{$product->image}}" alt="image" height="50" width="50"></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post" >
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
   {{$products->withQueryString()->links()}} {{-- to do well, go app->providers->AppServiceProvider in functon boot--}}
@endsection
