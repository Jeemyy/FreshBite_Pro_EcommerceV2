@extends('layouts.master-admin')
@section('content')
@php
    $counter = 0;
@endphp
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="col-md-12 my-4">
                <div class="card shadow">
                    <div class="card-body flex">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Product Management</h5>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
                        </div>
                        <div class="mb-3 w-100">
                            @if (session('success'))
                                <span class="alert alert-success">{{ session('success') }}</span>
                            @endif
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $item)
                                @php
                                    $counter++;
                                @endphp
                                    <tr>
                                        <td>{{ $counter }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->category->title }}</td>
                                    <td>
                                        <img src="{{ asset('storage/'. $item->image) }}" alt=""
                                        style="width: 50px; border-radius: 10px"
                                        >
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.products.show', $item->id) }}" class="btn btn-outline-warning">Show</a>
                                        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-outline-info">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @php
                                    $counter = 0;
                                @endphp
                                <tr>
                                    <td class="text-center" colspan="5">
                                        <span class="alert alert-danger d-flex justify-content-center items-center">
                                            No products found.
                                        </span>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- simple table -->
        </div>
    </main> <!-- main -->
@endsection
