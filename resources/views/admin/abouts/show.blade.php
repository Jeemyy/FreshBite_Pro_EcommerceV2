@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">View About</strong>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="about Title">Title</label>
                            <input type="text" id="about Title" name="title" class="form-control" placeholder="Title"
                                value="{{ $about->title }}" disabled>
                            {{-- <x-input-error :messages="$errors->get('title" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="about description">Description</label>
                            <textarea type="text" id="about description" name="description" class="form-control" placeholder="Description"
                                value="{{ $about->description }}" disabled>{{ $about->description }}</textarea>
                            {{-- <x-input-error :messages="$errors->get('description" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group mb-3">
                                {{-- <input type="file" class="form-control" id="inputGroupFile02" name="image" > --}}
                                <img src="{{ asset('storage/' . $about->icon) }}" alt="" width="150px"
                                    style="border-radius: 10px">

                                <label class="input-group-text" for="inputGroupFile02">about Icon</label>
                                {{-- <x-input-error :messages="$errors->get('image" class="mt-2" /> --}}
                            </div>
                        </div>
                    </div> <!-- /.col -->
                </div>
            </div>

        </div>
    </main> <!-- main -->
@endsection
