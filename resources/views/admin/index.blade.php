@extends('layouts.master-admin')

@section('content')
      <main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="row">
                <div class="col-md-6 col-xl-3 mb-4">
                  <div class="card shadow bg-primary text-white border-0">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary-light">
                            <i class="fe fe-16 fe-dollar-sign text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col pr-0">
                          <p class="small text-muted mb-0">Total Revenue</p>
                          <span class="h3 mb-0 text-white">${{ number_format($totalRevenue, 2) }}</span>
                          <span class="small text-muted">Monthly: ${{ number_format($monthlyRevenue, 2) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                  <div class="card shadow border-0">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col pr-0">
                          <p class="small text-muted mb-0">Total Orders</p>
                          <span class="h3 mb-0">{{ $totalOrders }}</span>
                          <span class="small text-success">+{{ $deliveredOrders }} delivered</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                  <div class="card shadow border-0">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-clock text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col">
                          <p class="small text-muted mb-0">Pending Orders</p>
                          <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                              <span class="h3 mr-2 mb-0">{{ $pendingOrders }}</span>
                            </div>
                            <div class="col-md-12 col-lg">
                              <div class="progress progress-sm mt-2" style="height:3px">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ $totalOrders > 0 ? ($pendingOrders / $totalOrders) * 100 : 0 }}%"
                                    aria-valuenow="{{ $pendingOrders }}"
                                    aria-valuemin="0" aria-valuemax="{{ $totalOrders }}"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                  <div class="card shadow border-0">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-users text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col">
                          <p class="small text-muted mb-0">Customers</p>
                          <span class="h3 mb-0">{{ $totalCustomers }}</span>
                          <p class="small text-muted mb-0 mt-1">{{ $totalProducts }} Products</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row align-items-center my-2">
                <div class="col">
                  <h5 class="mb-0">Dashboard Overview</h5>
                </div>
                <div class="col-auto ml-auto">
                  <form class="form-inline">
                    <div class="form-group">
                      <label for="reportrange" class="sr-only">Date Ranges</label>
                      <div id="reportrange" class="px-2 py-2 text-muted">
                        <i class="fe fe-calendar fe-16 mx-2"></i>
                        <span class="small"></span>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row my-4">
                <div class="col-md-12">
                  <div class="card shadow">
                    <div class="card-body">
                      <h5 class="card-title">Revenue (Last 30 Days)</h5>
                      <div class="chart-box">
                        <div id="columnChart"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="card shadow mb-4">
                    <div class="card-body">
                      <div class="card-title">
                        <strong>Order Status</strong>
                      </div>
                      @php
                        $statusColors = [
                          'pending' => 'warning',
                          'confirmed' => 'info',
                          'preparing' => 'primary',
                          'shipping' => 'secondary',
                          'delivered' => 'success',
                          'cancelled' => 'danger',
                        ];
                        $statusLabels = [
                          'pending' => 'Pending',
                          'confirmed' => 'Confirmed',
                          'preparing' => 'Preparing',
                          'shipping' => 'Shipping',
                          'delivered' => 'Delivered',
                          'cancelled' => 'Cancelled',
                        ];
                      @endphp
                      @foreach($ordersByStatus as $status => $count)
                        @if($count > 0)
                        <div class="row align-items-center my-2">
                          <div class="col">
                            <strong>{{ $statusLabels[$status] ?? ucfirst($status) }}</strong>
                          </div>
                          <div class="col-auto">
                            <strong>{{ $count }}</strong>
                          </div>
                          <div class="col-4">
                            <div class="progress" style="height: 4px;">
                              <div class="progress-bar bg-{{ $statusColors[$status] ?? 'secondary' }}"
                                  role="progressbar"
                                  style="width: {{ $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0 }}%"
                                  aria-valuenow="{{ $count }}" aria-valuemin="0" aria-valuemax="{{ $totalOrders }}"></div>
                            </div>
                          </div>
                        </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow mb-4">
                    <div class="card-body">
                      <div class="card-title">
                        <strong>Payment Overview</strong>
                      </div>
                      <div class="row items-align-center">
                        <div class="col-4 text-center">
                          <p class="text-muted mb-1">Pending</p>
                          <h6 class="mb-1">{{ $pendingPayments }}</h6>
                        </div>
                        <div class="col-4 text-center">
                          <p class="text-muted mb-1">Failed</p>
                          <h6 class="mb-1">{{ $failedPayments }}</h6>
                        </div>
                        <div class="col-4 text-center">
                          <p class="text-muted mb-1">Processing</p>
                          <h6 class="mb-1">{{ $processingOrders }}</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow mb-4">
                    <div class="card-body">
                      <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">Today</strong></p>
                      <h3 class="mb-0">${{ number_format($monthlyRevenue, 2) }}</h3>
                      <p class="text-muted">Revenue this month</p>
                      <div class="row">
                        <div class="col-4 text-center mt-3">
                          <p class="mb-1 text-muted">Delivered</p>
                          <h6 class="mb-0">{{ $deliveredOrders }}</h6>
                          <span class="fe fe-check-circle text-success fe-12"></span>
                        </div>
                        <div class="col-4 text-center mt-3">
                          <p class="mb-1 text-muted">Processing</p>
                          <h6 class="mb-0">{{ $processingOrders }}</h6>
                          <span class="fe fe-refresh-ccw text-info fe-12"></span>
                        </div>
                        <div class="col-4 text-center mt-3">
                          <p class="mb-1 text-muted">Cancelled</p>
                          <h6 class="mb-0">{{ $cancelledOrders }}</h6>
                          <span class="fe fe-x-circle text-danger fe-12"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h6 class="mb-3">Recent Orders</h6>
                  <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                      <thead>
                        <tr role="row">
                          <th>ID</th>
                          <th>Date</th>
                          <th>Customer</th>
                          <th>Items</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                          <th scope="row">#{{ $order->id }}</th>
                          <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                          <td>{{ $order->user?->name ?? 'N/A' }}</td>
                          <td>{{ $order->items->count() }}</td>
                          <td>${{ number_format($order->total_price, 2) }}</td>
                          <td>
                            <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                              {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                          </td>
                          <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                              View
                            </a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7" class="text-center">No orders yet.</td>
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

@push('scripts')
<script>
  @if($revenueChartData->isNotEmpty())
  var revenueData = @json($revenueChartData);
  var dates = revenueData.map(function(item) { return item.date; });
  var amounts = revenueData.map(function(item) { return parseFloat(item.total); });
  @endif
</script>
@endpush
