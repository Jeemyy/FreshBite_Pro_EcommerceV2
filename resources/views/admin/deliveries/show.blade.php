@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Delivery Detail - Order #{{ $delivery->order_id }}</h5>
                <a href="{{ route('admin.deliveries.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Order Information</strong>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th>Order ID:</th>
                            <td>#{{ $delivery->order_id }}</td>
                        </tr>
                        <tr>
                            <th>Customer:</th>
                            <td>{{ $delivery->order->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Order Total:</th>
                            <td>${{ number_format($delivery->order->total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Status:</th>
                            <td>
                                @php
                                    $dClasses = ['preparing' => 'badge-primary', 'shipping' => 'badge-info', 'out_for_delivery' => 'badge-info', 'delivered' => 'badge-success', 'cancelled' => 'badge-danger'];
                                    $dClass = $dClasses[$delivery->status] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $dClass }}">{{ ucfirst(str_replace('_', ' ', $delivery->status)) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Assigned To:</th>
                            <td>{{ $delivery->assignedTo->name ?? 'Unassigned' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Delivery Tracking Timeline</strong>
                </div>
                <div class="card-body">
                    @forelse ($delivery->trackings as $tracking)
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                @php
                                    $tClasses = ['preparing' => 'badge-primary', 'out_for_delivery' => 'badge-info', 'delivered' => 'badge-success', 'cancelled' => 'badge-danger'];
                                    $tClass = $tClasses[$tracking->status] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $tClass }}">{{ ucfirst(str_replace('_', ' ', $tracking->status)) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0">{{ $tracking->note ?? 'No note' }}</p>
                                <small class="text-muted">
                                    By {{ $tracking->admin->name ?? 'System' }} &middot; {{ $tracking->created_at->format('d M, Y H:i') }}
                                </small>
                            </div>
                        </div>
                        @if (!$loop->last)
                            <hr class="my-2">
                        @endif
                    @empty
                        <p class="text-muted mb-0">No tracking updates yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Update Delivery Status</strong>
                </div>
                <form class="card-body" action="{{ route('admin.deliveries.update-status', $delivery->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="preparing" {{ $delivery->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                    <option value="out_for_delivery" {{ $delivery->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                    <option value="delivered" {{ $delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $delivery->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="note">Note</label>
                                <textarea name="note" id="note" class="form-control" rows="2" placeholder="Add a note about this update...">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fe fe-check"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
