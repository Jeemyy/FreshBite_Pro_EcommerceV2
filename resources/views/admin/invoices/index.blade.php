@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Invoices Management</h5>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="GET" action="{{ route('admin.invoices.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_from" class="form-control" placeholder="From date" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <input type="date" name="date_to" class="form-control" placeholder="To date" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number ?? '#' . $invoice->id }}</td>
                                    <td>#{{ $invoice->order_id }}</td>
                                    <td>{{ $invoice->order->user->name ?? $invoice->user->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($invoice->amount ?? $invoice->total, 2) }}</td>
                                    <td>
                                        @php
                                            $iClasses = ['paid' => 'badge-success', 'pending' => 'badge-warning', 'overdue' => 'badge-danger', 'cancelled' => 'badge-secondary'];
                                            $iClass = $iClasses[$invoice->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $iClass }}">{{ ucfirst($invoice->status) }}</span>
                                    </td>
                                    <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fe fe-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No invoices found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
