@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Edit Category</strong>
            </div>
            <form class="card-body" action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Category Title">Title</label>
                            <input type="text" id="Category Title" name="title" class="form-control"
                                placeholder="Title" value="{{ $category->title }}">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02" name="image"
                                    value="{{ $category->image }}">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            <img src="{{ asset('storage/categories/' . $category->image) }}" alt=""
                                class="rounded mx-auto d-block w-25">
                        </div>
                    </div> <!-- /.col -->
                </div>

                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </main> <!-- main -->
@endsection
