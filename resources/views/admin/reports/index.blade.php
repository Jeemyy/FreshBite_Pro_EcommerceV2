@extends('layouts.master-admin')
@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="col-md-12 my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Reports</h5>
                <form method="GET" action="{{ route('admin.reports.index') }}" class="form-inline">
                    <select name="period" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                        <option value="weekly" {{ request('period', 'monthly') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('period', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ request('period', 'monthly') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </form>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Total Revenue</h6>
                            <h4 class="mb-0">${{ number_format($totalRevenue ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Monthly Revenue</h6>
                            <h4 class="mb-0">${{ number_format($monthlyRevenue ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Orders</h6>
                            <h3 class="mb-0">{{ $totalOrders ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Customers</h6>
                            <h3 class="mb-0">{{ $totalCustomers ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Products</h6>
                            <h3 class="mb-0">{{ $totalProducts ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center py-3">
                            <h6 class="card-title mb-0">Average Order Value</h6>
                            <h4 class="mb-0">${{ number_format($avgOrderValue ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Revenue Overview ({{ ucfirst(request('period', 'monthly')) }})</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Period</th>
                                            <th>Orders</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($revenueData ?? [] as $data)
                                            <tr>
                                                <td>{{ $data['period'] ?? $data->period ?? '' }}</td>
                                                <td>{{ $data['orders'] ?? $data->orders ?? 0 }}</td>
                                                <td>${{ number_format($data['revenue'] ?? $data->revenue ?? 0, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">No revenue data available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Orders by Status</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ordersByStatus ?? [] as $status => $count)
                                        <tr>
                                            <td>
                                                @php
                                                    $sClasses = ['pending' => 'badge-warning', 'confirmed' => 'badge-info', 'preparing' => 'badge-primary', 'shipping' => 'badge-info', 'delivered' => 'badge-success', 'cancelled' => 'badge-danger'];
                                                    $sClass = $sClasses[$status] ?? 'badge-secondary';
                                                @endphp
                                                <span class="badge {{ $sClass }}">{{ ucfirst($status) }}</span>
                                            </td>
                                            <td>{{ $count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">No data available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
