@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Role</strong>
        </div>
        <form class="card-body" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Role name" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="role-slug" value="{{ old('slug') }}">
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Role description" rows="3">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label class="mb-2">Permissions</label>
                    @foreach ($permissions as $group => $groupPermissions)
                        <div class="card mb-3">
                            <div class="card-header py-2">
                                <strong>{{ ucfirst($group) }}</strong>
                            </div>
                            <div class="card-body py-2">
                                <div class="row">
                                    @foreach ($groupPermissions as $permission)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" id="perm_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Create Role">
        </form>
    </div>
</main>
@endsection
