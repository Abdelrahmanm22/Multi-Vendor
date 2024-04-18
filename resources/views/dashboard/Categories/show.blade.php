@extends('layouts.dashboard')


@section('title',$category->name)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @php
        $products = $category->products()->with('store')->paginate(5)
        @endphp
        @if($category->products->count())
            @foreach($products as $product)
                <tr>
                    <td><img src="{{$product->image}}" alt="image" height="50" width="50"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">
                    No Categories Defined.
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    {{$products->links()}}
@endsection
