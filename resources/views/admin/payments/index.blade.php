@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Payments Management</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Total Revenue</h6>
                                    <h4 class="mb-0">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h4>
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
                            <div class="card bg-success text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Successful</h6>
                                    <h3 class="mb-0">{{ $stats['successful'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center py-3">
                                    <h6 class="card-title mb-0">Failed</h6>
                                    <h3 class="mb-0">{{ $stats['failed'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <select name="method" class="form-control">
                                        <option value="">All Methods</option>
                                        <option value="credit_card" {{ request('method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="paypal" {{ request('method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                    <td>{{ $payment->user->name ?? $payment->order->user->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->method ?? $payment->payment_method)) }}</td>
                                    <td>
                                        @php
                                            $pClasses = ['pending' => 'badge-warning', 'completed' => 'badge-success', 'successful' => 'badge-success', 'failed' => 'badge-danger', 'refunded' => 'badge-info'];
                                            $pClass = $pClasses[$payment->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $pClass }}">{{ ucfirst($payment->status) }}</span>
                                    </td>
                                    <td>{{ $payment->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fe fe-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
