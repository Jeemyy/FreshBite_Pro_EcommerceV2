@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Order #{{ $order->id }}</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Order Information</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Order ID:</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'badge-warning',
                                                'confirmed' => 'badge-info',
                                                'preparing' => 'badge-primary',
                                                'shipping' => 'badge-info',
                                                'delivered' => 'badge-success',
                                                'cancelled' => 'badge-danger',
                                            ];
                                            $class = $statusClasses[$order->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $class }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Date:</th>
                                    <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $order->updated_at->format('d M, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Customer Information</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $order->user->email ?? 'N/A' }}</td>
                                </tr>
                                @if ($order->user->phone ?? false)
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $order->user->phone }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Order Items</strong>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? $item->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>${{ number_format($order->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Payment Information</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Method:</th>
                                    <td>{{ $order->payment->payment_method ?? $order->payment->method ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td>{{ $order->payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $pStatus = $order->payment->status ?? 'pending';
                                            $pClasses = ['completed' => 'badge-success', 'pending' => 'badge-warning', 'failed' => 'badge-danger', 'refunded' => 'badge-info'];
                                            $pClass = $pClasses[$pStatus] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $pClass }}">{{ ucfirst($pStatus) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Delivery Address</strong>
                        </div>
                        <div class="card-body">
                            @if ($order->address)
                                <p class="mb-1"><strong>{{ $order->address->full_name ?? $order->address->name ?? '' }}</strong></p>
                                <p class="mb-1">{{ $order->address->address_line_1 ?? $order->address->address ?? '' }}</p>
                                @if ($order->address->address_line_2 ?? false)
                                    <p class="mb-1">{{ $order->address->address_line_2 }}</p>
                                @endif
                                <p class="mb-1">{{ $order->address->city ?? '' }}, {{ $order->address->state ?? '' }} {{ $order->address->postal_code ?? '' }}</p>
                                <p class="mb-0">{{ $order->address->country ?? '' }}</p>
                                @if ($order->address->phone ?? false)
                                    <p class="mb-0 mt-2"><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                @endif
                            @else
                                <p class="text-muted mb-0">No address information available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Update Order Status</strong>
                </div>
                <form class="card-body" action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="cancel_reason">Reason (if cancelled)</label>
                                <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="2" placeholder="Enter cancellation reason...">{{ old('cancel_reason') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fe fe-check"></i> Update Status
                    </button>
                </form>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Assign Delivery Employee</strong>
                </div>
                <form class="card-body" action="{{ route('admin.orders.assign-delivery', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="delivery_employee">Delivery Employee</label>
                                <select name="delivery_employee_id" id="delivery_employee" class="form-control">
                                    <option value="">Select Employee</option>
                                    @foreach ($deliveryEmployees as $employee)
                                        <option value="{{ $employee->id }}" {{ ($order->delivery_employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fe fe-user-check"></i> Assign
                    </button>
                </form>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Delivery Tracking Timeline</strong>
                </div>
                <div class="card-body">
                    @forelse ($order->deliveryTrackings as $tracking)
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                @php
                                    $tClasses = [
                                        'pending' => 'badge-warning',
                                        'preparing' => 'badge-primary',
                                        'shipping' => 'badge-info',
                                        'out_for_delivery' => 'badge-info',
                                        'delivered' => 'badge-success',
                                        'cancelled' => 'badge-danger',
                                    ];
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
        </div>
    </div>
</main>
@endsection
