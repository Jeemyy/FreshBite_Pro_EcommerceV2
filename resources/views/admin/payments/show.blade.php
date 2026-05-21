@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Payment Detail - {{ $payment->transaction_id ?? '#' . $payment->id }}</h5>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Payment Information</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Method:</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->method ?? $payment->payment_method)) }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $pClasses = ['pending' => 'badge-warning', 'completed' => 'badge-success', 'successful' => 'badge-success', 'failed' => 'badge-danger', 'refunded' => 'badge-info'];
                                            $pClass = $pClasses[$payment->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $pClass }}">{{ ucfirst($payment->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $payment->created_at->format('d M, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Customer:</th>
                                    <td>{{ $payment->user->name ?? $payment->order->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Email:</th>
                                    <td>{{ $payment->user->email ?? $payment->order->user->email ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Related Orders</strong>
                        </div>
                        <div class="card-body">
                            @if ($payment->order)
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th>Order ID:</th>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $payment->order->id) }}">#{{ $payment->order->id }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Total:</th>
                                        <td>${{ number_format($payment->order->total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status:</th>
                                        <td>
                                            @php
                                                $oClasses = ['pending' => 'badge-warning', 'confirmed' => 'badge-info', 'preparing' => 'badge-primary', 'shipping' => 'badge-info', 'delivered' => 'badge-success', 'cancelled' => 'badge-danger'];
                                                $oClass = $oClasses[$payment->order->status] ?? 'badge-secondary';
                                            @endphp
                                            <span class="badge {{ $oClass }}">{{ ucfirst($payment->order->status) }}</span>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted mb-0">No related orders.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Transaction History</strong>
                </div>
                <div class="card-body">
                    @forelse ($payment->histories ?? $payment->transactionHistories ?? [] as $history)
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                @php
                                    $hClasses = ['created' => 'badge-info', 'completed' => 'badge-success', 'failed' => 'badge-danger', 'refunded' => 'badge-warning'];
                                    $hClass = $hClasses[$history->status] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $hClass }}">{{ ucfirst($history->status) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0">{{ $history->note ?? $history->description ?? 'No details' }}</p>
                                <small class="text-muted">{{ $history->created_at->format('d M, Y H:i') }}</small>
                            </div>
                        </div>
                        @if (!$loop->last)
                            <hr class="my-2">
                        @endif
                    @empty
                        <p class="text-muted mb-0">No transaction history available.</p>
                    @endforelse
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Actions</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm" {{ $payment->status == 'completed' ? 'disabled' : '' }}>
                            <i class="fe fe-check-circle"></i> Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.payments.mark-failed', $payment->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-sm" {{ $payment->status == 'failed' ? 'disabled' : '' }}>
                            <i class="fe fe-x-circle"></i> Mark Failed
                        </button>
                    </form>
                    <form action="{{ route('admin.payments.refund', $payment->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to refund this payment?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning btn-sm" {{ $payment->status == 'refunded' ? 'disabled' : '' }}>
                            <i class="fe fe-rotate-ccw"></i> Refund
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
