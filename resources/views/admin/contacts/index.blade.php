@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="col-md-12 my-4">
                <div class="card shadow">
                    <div class="card-body flex">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Contact Us Management</h5>
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
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($contacts) > 0)
                                    @foreach ($contacts as $item)
                                        <tr>
                                            <td>{{ '1' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->subject }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.contacts.show', $item->id) }}"
                                                    class="btn btn-outline-warning">Show</a>

                                                <form action="{{ route('admin.contacts.destroy', $item->id) }}"
                                                    method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="alert alert-danger">No ContactUs found.</td>
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
