@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Add New About</strong>
            </div>
            <form class="card-body" action="{{ route('admin.abouts.store') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="About Title">Title</label>
                            <input type="text" id="About Title" name="title" class="form-control"
                                placeholder="Title" value="{{ old('title') }}">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="About Description">Description</label>
                            <textarea type="text" id="product description" name="description" class="form-control"
                                placeholder="Description" value="{{ old('description') }}"></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02" name="icon">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>
                        </div>
                    </div> <!-- /.col -->
                </div>

                <input type="submit" class="btn btn-primary" value="Store">
            </form>
        </div>
    </main> <!-- main -->
@endsection
