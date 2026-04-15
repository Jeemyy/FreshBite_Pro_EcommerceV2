@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="mb-3">
            @if (session('success'))
                <span class="alert alert-success" style="width: 100%">{{ session('success') }}</span>
            @endif
        </div>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Edit setting</strong>
            </div>
            <form class="card-body" action="{{ route('admin.settings.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="setting About">About</label>
                            <input type="text" id="setting about" name="about" class="form-control" placeholder="about"
                                value="{{ $setting->about }}">
                            <x-input-error :messages="$errors->get('about')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Address</label>

                            <input type="text" name="contact[address]" class="form-control" placeholder="address"
                                value="{{ $setting->contact['address'] ?? '' }}">

                            <x-input-error :messages="$errors->get('contact.address')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email</label>

                            <input type="email" name="contact[email]" class="form-control" placeholder="email"
                                value="{{ $setting->contact['email'] ?? '' }}">

                            <x-input-error :messages="$errors->get('contact.email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone Number</label>

                            <input type="phone" name="contact[phone]" class="form-control" placeholder="phone"
                                value="{{ $setting->contact['phone'] ?? '' }}">

                            <x-input-error :messages="$errors->get('contact.phone')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($allPages as $page)
                        <!-- $allPages = ['Home','About','Shop','News','Contact'] -->
                        <div class="col-md-2">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="pages[]" value="{{ $page }}"
                                    id="page_{{ $page }}"
                                    {{ in_array($page, $setting->pages ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="page_{{ $page }}">
                                    {{ $page }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>{{--  --}}


                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </main> <!-- main -->
@endsection
