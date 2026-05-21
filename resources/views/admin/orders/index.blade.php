@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Orders Management</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Total Orders</h6>
                                    <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Pending</h6>
                                    <h3 class="mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Processing</h6>
                                    <h3 class="mb-0">{{ $stats['processing'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Completed</h6>
                                    <h3 class="mb-0">{{ $stats['completed'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search by ID or customer name..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_from" class="form-control" placeholder="From date" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_to" class="form-control" placeholder="To date" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->items_count ?? $order->items->count() }}</td>
                                    <td>{{ number_format($order->total, 2) }}</td>
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
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fe fe-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
