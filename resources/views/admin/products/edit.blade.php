@extends('layouts.master-admin')
@section('content')
    <main role="main" class="main-content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Edit Product</strong>
            </div>
            <form class="card-body" action="{{ route('admin.products.update', $product->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $product->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product Title">Title</label>
                            <input type="text" id="product Title" name="title" class="form-control"
                                placeholder="Title" value="{{ $product->title }}">
                                <x-input-error :messages="$errors->get('title')"  class="mt-2" />

                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product category">Category</label>
                            <select class="form-select" aria-label="Default select example" name="category_id" id="">
                                <option value="{{$product->category_id}}" selected>{{$product->category->title}}</option>
                                @foreach ($categories as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="product description">Description</label>
                            <textarea type="text" id="product description" name="description" class="form-control"
                                placeholder="Description" value="{{ $product->description }}">{!! $product->description !!}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product price">Price</label>
                            <input type="number" id="product price" name="price" class="form-control"
                                placeholder="Price" value="{{ $product->price }}" step="0.01">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product quantity">Quantity</label>
                            <input type="number" id="product quantity" name="quantity" class="form-control"
                                placeholder="Quantity" value="{{ $product->quantity }}" step="1">
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                    </div> <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile02" name="image">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                                <img src="{{ asset('storage/'. $product->image) }}" alt="" style="width: 150px; border-radius: 10px">
                            </div>
                    </div> <!-- /.col -->
                </div>

                <input type="submit" class="btn btn-primary" value="Store">
            </form>
        </div>
    </main> <!-- main -->
@endsection
