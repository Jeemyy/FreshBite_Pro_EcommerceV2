@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Delivery Management</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Preparing</h6>
                                    <h3 class="mb-0">{{ $stats['preparing'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Shipping</h6>
                                    <h3 class="mb-0">{{ $stats['shipping'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Delivered</h6>
                                    <h3 class="mb-0">{{ $stats['delivered'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.deliveries.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <select name="employee_id" class="form-control">
                                        <option value="">All Employees</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Latest Tracking</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deliveries as $delivery)
                                <tr>
                                    <td>#{{ $delivery->order_id }}</td>
                                    <td>{{ $delivery->order->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $dClasses = ['preparing' => 'badge-primary', 'shipping' => 'badge-info', 'out_for_delivery' => 'badge-info', 'delivered' => 'badge-success', 'cancelled' => 'badge-danger'];
                                            $dClass = $dClasses[$delivery->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $dClass }}">{{ ucfirst(str_replace('_', ' ', $delivery->status)) }}</span>
                                    </td>
                                    <td>{{ $delivery->assignedTo->name ?? 'Unassigned' }}</td>
                                    <td>{{ $delivery->latestTracking->note ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.deliveries.show', $delivery->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fe fe-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No deliveries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $deliveries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
