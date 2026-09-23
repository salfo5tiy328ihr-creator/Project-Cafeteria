@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-receipt" style="color: #6366f1;"></i> My Orders
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Track your previous orders and their status.</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @forelse($orders as $order)
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; font-size: 1.1rem;">
                    <i class="fas fa-hashtag"></i> Order #{{ $order->id }}
                </span>
                @php
                    $colors = [
                        'pending' => '#f59e0b',
                        'preparing' => '#3b82f6',
                        'ready' => '#8b5cf6',
                        'completed' => '#10b981',
                        'cancelled' => '#ef4444',
                    ];
                    $color = $colors[$order->status] ?? '#6b7280';
                @endphp
                <span style="background: {{ $color }}20; color: {{ $color }}; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; text-transform: uppercase; font-weight: 700;">
                    {{ $order->status }}
                </span>
            </div>
            <div class="card-body">
                <p style="color: #6b7280; margin-bottom: 15px; font-size: 0.9rem;">
                    <i class="fas fa-calendar-alt"></i> {{ $order->created_at->format('d M Y, h:i A') }}
                </p>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                            <th style="padding: 10px; color: #6b7280; font-size: 0.9rem;">Product</th>
                            <th style="padding: 10px; color: #6b7280; font-size: 0.9rem;">Quantity</th>
                            <th style="padding: 10px; color: #6b7280; font-size: 0.9rem;">Price</th>
                            <th style="padding: 10px; color: #6b7280; font-size: 0.9rem;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 10px; font-weight: 600; color: #1f2937;">{{ $item->product->name ?? 'N/A' }}</td>
                                <td style="padding: 10px;">{{ $item->quantity }}</td>
                                <td style="padding: 10px;">{{ $item->price }} EGP</td>
                                <td style="padding: 10px; font-weight: 600; color: #6366f1;">{{ $item->price * $item->quantity }} EGP</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px; text-align: right; font-weight: 700; color: #1f2937; font-size: 1.1rem;">
                    Total: <span style="color: #6366f1;">{{ $order->total_price }} EGP</span>
                </div>

                @if($order->status == 'pending')
                    <div style="margin-top: 15px; text-align: right;">
                        <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 8px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Cairo'; transition: 0.3s;" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
                                <i class="fas fa-times-circle"></i> Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 50px;">
                <i class="fas fa-receipt fa-4x" style="color: #d1d5db; margin-bottom: 20px;"></i>
                <h4 style="color: #6b7280; font-weight: 600;">You have no orders yet.</h4>
                <p style="color: #9ca3af; margin-bottom: 20px;">Start ordering your favorite food and beverages.</p>
                <a href="{{ route('menu') }}" class="btn-submit" style="width: auto; padding: 12px 30px; display: inline-flex; text-decoration: none;">
                    <i class="fas fa-utensils"></i> Browse Menu
                </a>
            </div>
        </div>
    @endforelse
@endsection