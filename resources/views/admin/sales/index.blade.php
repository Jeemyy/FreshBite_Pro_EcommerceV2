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
                <strong class="card-title">Update Sale</strong>
            </div>
            <form class="card-body" action="{{ route('admin.sales.update', 1) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Month</label>

                            <input type="text" name="sale[month]" class="form-control" placeholder="Month..."
                                value="{{ $sale->sale['month'] ?? '' }}">

                            <x-input-error :messages="$errors->get('sale.month')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Discount</label>

                            <input type="phone" name="sale[discount]" class="form-control" placeholder="Discount..."
                                value="{{ $sale->sale['discount'] ?? '' }}">

                            <x-input-error :messages="$errors->get('sale.discount')" class="mt-2" />
                        </div>
                    </div>
                </div>


                <input type="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    </main> <!-- main -->
@endsection
