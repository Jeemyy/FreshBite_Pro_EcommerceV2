@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Add New Product</strong>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product Title">Title</label>
                            <input type="text" id="product Title" name="title" class="form-control"
                                placeholder="Title" value="{{ $product->title }}" disabled>
                                {{-- <x-input-error :messages="$errors->get('title" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product category">Category</label>
                            <select class="form-select" aria-label="Default select example" name="category_id" id="">
                                <option value="{{$product->id}}" selected>{{$product->title}}</option>
                            </select>
                                {{-- <x-input-error :messages="$errors->get('category_id" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="product description">Description</label>
                            <textarea type="text" id="product description" name="description" class="form-control"
                                placeholder="Description" value="{{ $product->description }}" disabled>{{ $product->description }}</textarea>
                                {{-- <x-input-error :messages="$errors->get('description" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product price">Price</label>
                            <input type="number" id="product price" name="price" class="form-control"
                                placeholder="Price" value="{{ $product->price }}" step="0.01" disabled>
                                {{-- <x-input-error :messages="$errors->get('price" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product quantity">Quantity</label>
                            <input type="number" id="product quantity" name="quantity" class="form-control"
                                placeholder="Quantity" value="{{ $product->quantity }}" step="1" disabled>
                                {{-- <x-input-error :messages="$errors->get('quantity" class="mt-2" /> --}}
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group mb-3">
                                {{-- <input type="file" class="form-control" id="inputGroupFile02" name="image" > --}}
                                <img src="{{ asset('storage/'.$product->image) }}" alt="" width="150px" style="border-radius: 10px">

                                <label class="input-group-text" for="inputGroupFile02">Product Image</label>
                                {{-- <x-input-error :messages="$errors->get('image" class="mt-2" /> --}}
                            </div>
                        </div>
                    </div> <!-- /.col -->
                </div>
            </div>

        </div>
    </main> <!-- main -->
@endsection
