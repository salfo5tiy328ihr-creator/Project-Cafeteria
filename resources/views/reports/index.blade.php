@extends('layouts.admin')

@section('title', 'Reports & Statistics')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chart-line" style="color: #6366f1;"></i> Reports & Statistics
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Overview of your cafeteria's performance.</p>
    </div>

    {{-- KPI Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="background: linear-gradient(135deg, #6366f1, #4338ca); color: white; padding: 22px;">
            <div style="font-size: 0.9rem; opacity: 0.9;">Total Sales</div>
            <div style="font-size: 1.8rem; font-weight: 800; margin-top: 5px;">{{ number_format($totalSales, 2) }} EGP</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #10b981, #047857); color: white; padding: 22px;">
            <div style="font-size: 0.9rem; opacity: 0.9;">Total Orders</div>
            <div style="font-size: 1.8rem; font-weight: 800; margin-top: 5px;">{{ $totalOrders }}</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #f59e0b, #b45309); color: white; padding: 22px;">
            <div style="font-size: 0.9rem; opacity: 0.9;">Total Customers</div>
            <div style="font-size: 1.8rem; font-weight: 800; margin-top: 5px;">{{ $totalCustomers }}</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #ec4899, #be185d); color: white; padding: 22px;">
            <div style="font-size: 0.9rem; opacity: 0.9;">Total Products</div>
            <div style="font-size: 1.8rem; font-weight: 800; margin-top: 5px;">{{ $totalProducts }}</div>
        </div>
    </div>

    {{-- Today's Stats --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="color: #6b7280; font-size: 0.85rem;">Today's Orders</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #1f2937;">{{ $todayOrders }}</div>
                </div>
                <i class="fas fa-receipt" style="font-size: 2rem; color: #c7d2fe;"></i>
            </div>
        </div>
        <div class="card" style="padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="color: #6b7280; font-size: 0.85rem;">Today's Sales</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #6366f1;">{{ number_format($todaySales, 2) }} EGP</div>
                </div>
                <i class="fas fa-money-bill-wave" style="font-size: 2rem; color: #a7f3d0;"></i>
            </div>
        </div>
    </div>

    {{-- Order Status Breakdown --}}
    <div class="card" style="margin-bottom: 30px;">
        <div class="card-header">
            <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-tasks"></i> Orders Status Breakdown
            </h4>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; text-align: center;">
                <div style="padding: 15px; background: #fef3c7; border-radius: 12px;">
                    <div style="color: #92400e; font-weight: 600; font-size: 0.85rem;">Pending</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #92400e;">{{ $pendingOrders }}</div>
                </div>
                <div style="padding: 15px; background: #dbeafe; border-radius: 12px;">
                    <div style="color: #1e40af; font-weight: 600; font-size: 0.85rem;">Preparing</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #1e40af;">{{ $preparingOrders }}</div>
                </div>
                <div style="padding: 15px; background: #ede9fe; border-radius: 12px;">
                    <div style="color: #5b21b6; font-weight: 600; font-size: 0.85rem;">Ready</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #5b21b6;">{{ $readyOrders }}</div>
                </div>
                <div style="padding: 15px; background: #d1fae5; border-radius: 12px;">
                    <div style="color: #065f46; font-weight: 600; font-size: 0.85rem;">Completed</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #065f46;">{{ $completedOrders }}</div>
                </div>
                <div style="padding: 15px; background: #fee2e2; border-radius: 12px;">
                    <div style="color: #991b1b; font-weight: 600; font-size: 0.85rem;">Cancelled</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #991b1b;">{{ $cancelledOrders }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Selling & Low Stock --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        
        {{-- Top Selling --}}
        <div class="card">
            <div class="card-header">
                <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-fire"></i> Top Selling Products
                </h4>
            </div>
            <div class="card-body">
                @if($topProducts->isEmpty())
                    <p style="color: #6b7280; text-align: center;">No sales data yet.</p>
                @else
                    @foreach($topProducts as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="font-weight: 600; color: #1f2937;">{{ $item->product->name ?? 'N/A' }}</span>
                            <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                                {{ $item->total_sold }} sold
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #ef4444, #b91c1c);">
                <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
                </h4>
            </div>
            <div class="card-body">
                @if($lowStockProducts->isEmpty())
                    <p style="color: #6b7280; text-align: center;">All products have enough stock.</p>
                @else
                    @foreach($lowStockProducts as $product)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="font-weight: 600; color: #1f2937;">{{ $product->name }}</span>
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                                {{ $product->quantity }} left
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-header">
            <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clock"></i> Recent Orders
            </h4>
        </div>
        <div class="card-body">
            @if($recentOrders->isEmpty())
                <p style="color: #6b7280; text-align: center;">No orders yet.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                            <th style="padding: 12px; color: #6b7280;">Order #</th>
                            <th style="padding: 12px; color: #6b7280;">Customer</th>
                            <th style="padding: 12px; color: #6b7280;">Date</th>
                            <th style="padding: 12px; color: #6b7280;">Total</th>
                            <th style="padding: 12px; color: #6b7280;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px; font-weight: 700;">#{{ $order->id }}</td>
                                <td style="padding: 12px;">{{ $order->user->name ?? 'Guest' }}</td>
                                <td style="padding: 12px; font-size: 0.9rem;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td style="padding: 12px; font-weight: 700; color: #6366f1;">{{ number_format($order->total_price, 2) }} EGP</td>
                                <td style="padding: 12px;">
                                    <span style="background: #e0e7ff; color: #3730a3; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection