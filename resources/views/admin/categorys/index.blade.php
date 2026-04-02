@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="col-md-12 my-4">
                <div class="card shadow">
                    <div class="card-body flex">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Category Management</h5>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
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
                                    <th>Image</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($categories) > 0)
                                    @foreach ($categories as $item)
                                    <tr>
                                        <td>{{ "1" }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <img src="{{ asset('storage/'. $item->image) }}" alt=""
                                        style="width: 50px; border-radius: 10px"
                                        >
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-outline-info">Edit</a>

                                        <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="alert alert-danger">No categories found.</td>
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
