@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">View News</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="news Title">Title</label>
                            <input type="text" id="news Title" class="form-control" value="{{ $news->title }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="news description">Description</label>
                            <textarea id="news description" class="form-control" disabled>{{ $news->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Published At</label>
                            <input type="text" class="form-control" value="{{ optional($news->published_at)->format('d F, Y') }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="" width="300px" style="border-radius: 10px">
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </main>
@endsection
