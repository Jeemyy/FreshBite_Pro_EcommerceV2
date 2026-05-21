@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Admin Users Management</h5>
                        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus"></i> Add Admin
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Created Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @forelse ($admin->roles as $role)
                                            <span class="badge badge-info">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">No roles</span>
                                        @endforelse
                                    </td>
                                    <td>{{ $admin->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fe fe-edit"></i> Edit
                                        </a>
                                        @if ($admin->id !== auth()->id())
                                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fe fe-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No admin users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
