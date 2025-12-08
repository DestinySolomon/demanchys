@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">Dashboard Overview</h1>
            <p class="text-muted">Welcome to your admin dashboard</p>
        </div>
        <div class="col-auto">
            <div class="text-end">
                <small class="text-muted">Last updated: {{ now()->format('M d, Y H:i') }}</small>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Active Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Active Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderStats['active'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pending Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderStats['pending'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderStats['completed'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canceled Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Canceled Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderStats['canceled'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row - Financial & User Stats -->
    <div class="row">
        <!-- Total Earnings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Earnings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₦{{ number_format($totalEarnings ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₦{{ number_format($totalPending ?? 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userStats['total'] ?? \App\Models\User::count() }}</div>
                            <div class="text-xs text-muted mt-1">
                                {{ $userStats['regular_users'] ?? 0 }} users • {{ $userStats['admins'] ?? 0 }} admins
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayBookings ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Trend Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Order Trends (Last 30 Days)</h6>
                    <div>
                        <select id="chartPeriod" class="form-select form-select-sm" style="width: auto;">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="orderTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row - Recent Data with Filters -->
       <!-- Third Row - Recent Data with Filters -->
    <div class="row">
        <!-- Recent Orders with Filter -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Recent Orders</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" id="orderSearch" class="form-control form-control-sm" placeholder="Search customer...">
                        </div>
                        <div class="col-md-6">
                            <input type="date" id="orderDateFilter" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                                    <td>₦{{ number_format($order->total_amount) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $order->order_status == 'completed' ? 'success' : 
                                            ($order->order_status == 'pending' ? 'warning' : 'danger') 
                                        }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">No recent orders</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users with Filter -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Recent Users</h6>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" id="userSearch" class="form-control form-control-sm" placeholder="Search name or email...">
                        </div>
                        <div class="col-md-6">
                            <select id="userRoleFilter" class="form-select form-select-sm">
                                <option value="">All Roles</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers ?? [] as $user)
                                <tr data-user-role="{{ $user->role }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $user->role == 'super_admin' ? 'danger' : 
                                            ($user->role == 'admin' ? 'warning' : 'secondary') 
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No recent users</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center py-2">
                                    <h5 class="mb-1">{{ $unreadContacts ?? 0 }}</h5>
                                    <small class="text-muted">Unread Messages</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center py-2">
                                    <h5 class="mb-1">{{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}</h5>
                                    <small class="text-muted">Upcoming Events</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fourth Row - Upcoming Events -->
    @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Upcoming Events</h6>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($upcomingEvents as $event)
                        <div class="col-md-4 mb-3">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $event->title }}</h6>
                                    <p class="card-text small text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                    </p>
                                    <p class="card-text small">{{ Str::limit($event->description, 80) }}</p>
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Table Filters
    const orderSearch = document.getElementById('orderSearch');
    const orderDateFilter = document.getElementById('orderDateFilter');
    const userSearch = document.getElementById('userSearch');
    const userRoleFilter = document.getElementById('userRoleFilter');
    const ordersTable = document.getElementById('ordersTable');
    const usersTable = document.getElementById('usersTable');

    // Filter Orders Table
    function filterOrders() {
        const searchText = orderSearch.value.toLowerCase();
        const filterDate = orderDateFilter.value;
        const rows = ordersTable.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const customerName = row.cells[1].textContent.toLowerCase();
            const orderDate = row.cells[4].textContent;
            const dateMatch = !filterDate || orderDate.includes(new Date(filterDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
            const searchMatch = !searchText || customerName.includes(searchText);
            
            row.style.display = (dateMatch && searchMatch) ? '' : 'none';
        });
    }

    // Filter Users Table
    function filterUsers() {
        const searchText = userSearch.value.toLowerCase();
        const roleFilter = userRoleFilter.value;
        
        // Fetch filtered users from server
        const params = new URLSearchParams();
        if (roleFilter) params.append('role', roleFilter);
        if (searchText) params.append('search', searchText);
        
        fetch(`{{ route('admin.dashboard.users') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const tbody = usersTable.querySelector('tbody');
                tbody.innerHTML = '';
                
                if (data.users.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">No users found</td></tr>';
                    return;
                }
                
                data.users.forEach(user => {
                    const roleColor = user.role === 'super_admin' ? 'danger' : 
                                    (user.role === 'admin' ? 'warning' : 'secondary');
                    const roleDisplay = user.role.charAt(0).toUpperCase() + user.role.slice(1).replace(/_/g, ' ');
                    
                    const row = document.createElement('tr');
                    row.setAttribute('data-user-role', user.role);
                    row.innerHTML = `
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td><span class="badge bg-${roleColor}">${roleDisplay}</span></td>
                        <td>${user.created_at}</td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                const tbody = usersTable.querySelector('tbody');
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Error loading users</td></tr>';
            });
    }

    // Add event listeners for filters
    orderSearch.addEventListener('keyup', filterOrders);
    orderDateFilter.addEventListener('change', filterOrders);
    userSearch.addEventListener('keyup', filterUsers);
    userRoleFilter.addEventListener('change', filterUsers);

    // Initialize Order Trend Chart
    const chartPeriod = document.getElementById('chartPeriod');
    let orderChart;

    function loadOrderChart(days = 30) {
        // Fetch data from server
        fetch(`/admin/dashboard/chart-data?days=${days}`)
            .then(response => response.json())
            .then(data => {
                if (orderChart) {
                    orderChart.destroy();
                }

                const ctx = document.getElementById('orderTrendChart').getContext('2d');
                orderChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Orders',
                            data: data.orders,
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Orders'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
                // Fallback to sample data if API fails
                createSampleChart();
            });
    }

    // Fallback sample chart
    function createSampleChart() {
        const ctx = document.getElementById('orderTrendChart').getContext('2d');
        const dates = [];
        for (let i = 29; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            dates.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
        }

        const orders = dates.map(() => Math.floor(Math.random() * 20) + 5);

        orderChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Orders (Sample Data)',
                    data: orders,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        },
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
    }

    // Load chart on page load
    loadOrderChart(30);

    // Update chart when period changes
    chartPeriod.addEventListener('change', function() {
        loadOrderChart(this.value);
    });
});
</script>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection