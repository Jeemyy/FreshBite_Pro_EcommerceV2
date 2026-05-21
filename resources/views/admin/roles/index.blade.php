@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">Roles Management</h5>
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus"></i> Add Role
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Permissions</th>
                                <th>Admins</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td><code>{{ $role->slug ?? $role->name }}</code></td>
                                    <td>{{ $role->permissions_count ?? $role->permissions->count() }}</td>
                                    <td>{{ $role->admins_count ?? $role->admins->count() }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fe fe-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fe fe-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No roles found.</td>
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
