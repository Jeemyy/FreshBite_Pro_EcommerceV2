@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Admin User</strong>
        </div>
        <form class="card-body" action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label class="mb-2">Roles</label>
                    <div class="row">
                        @forelse ($roles as $role)
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->id }}" class="form-check-input" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <p class="text-muted">No roles available.</p>
                            </div>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Create Admin">
        </form>
    </div>
</main>
@endsection
