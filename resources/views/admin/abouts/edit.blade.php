@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Edit About</strong>
            </div>
            <form class="card-body" action="{{ route('admin.abouts.update', $about->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $about->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="about Title">Title</label>
                            <input type="text" id="about Title" name="title" class="form-control"
                                placeholder="Title" value="{{ $about->title }}">
                                <x-input-error :messages="$errors->get('title')"  class="mt-2" />

                        </div>
                    </div> <!-- /.col -->


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="about description">Description</label>
                            <textarea type="text" id="about description" name="description" class="form-control"
                                placeholder="Description" value="{{ $about->description }}">{!! $about->description !!}</textarea>
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
                                <img src="{{ asset('storage/'. $about->icon) }}" alt="" style="width: 150px; border-radius: 10px">
                            </div>
                    </div> <!-- /.col -->
                </div>

                <input type="submit" class="btn btn-primary" value="Store">
            </form>
        </div>
    </main> <!-- main -->
@endsection
