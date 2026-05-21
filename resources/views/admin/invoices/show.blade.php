@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Invoice {{ $invoice->invoice_number ?? '#' . $invoice->id }}</h5>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm">
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
                            <strong class="card-title">Invoice Information</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Invoice #:</th>
                                    <td>{{ $invoice->invoice_number ?? '#' . $invoice->id }}</td>
                                </tr>
                                <tr>
                                    <th>Order #:</th>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $invoice->order_id) }}">#{{ $invoice->order_id }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td><strong>${{ number_format($invoice->amount ?? $invoice->total, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $iClasses = ['paid' => 'badge-success', 'pending' => 'badge-warning', 'overdue' => 'badge-danger', 'cancelled' => 'badge-secondary'];
                                            $iClass = $iClasses[$invoice->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $iClass }}">{{ ucfirst($invoice->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Issue Date:</th>
                                    <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                                </tr>
                                @if ($invoice->due_date ?? false)
                                <tr>
                                    <th>Due Date:</th>
                                    <td>{{ $invoice->due_date->format('d M, Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Customer:</th>
                                    <td>{{ $invoice->order->user->name ?? $invoice->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Email:</th>
                                    <td>{{ $invoice->order->user->email ?? $invoice->user->email ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Billing Address</strong>
                        </div>
                        <div class="card-body">
                            @if ($invoice->order->address ?? false)
                                <p class="mb-1"><strong>{{ $invoice->order->address->full_name ?? $invoice->order->address->name ?? '' }}</strong></p>
                                <p class="mb-1">{{ $invoice->order->address->address_line_1 ?? $invoice->order->address->address ?? '' }}</p>
                                @if ($invoice->order->address->address_line_2 ?? false)
                                    <p class="mb-1">{{ $invoice->order->address->address_line_2 }}</p>
                                @endif
                                <p class="mb-1">{{ $invoice->order->address->city ?? '' }}, {{ $invoice->order->address->state ?? '' }} {{ $invoice->order->address->postal_code ?? '' }}</p>
                                <p class="mb-0">{{ $invoice->order->address->country ?? '' }}</p>
                            @else
                                <p class="text-muted mb-0">No address available.</p>
                            @endif
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
                            @forelse (($invoice->order->items ?? []) as $item)
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
                                <th>${{ number_format($invoice->amount ?? $invoice->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.invoices.download', $invoice->id) }}" class="btn btn-primary btn-sm">
                    <i class="fe fe-download"></i> Download PDF
                </a>
                @if ($invoice->status != 'paid')
                    <form action="{{ route('admin.invoices.mark-paid', $invoice->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fe fe-check"></i> Mark as Paid
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
