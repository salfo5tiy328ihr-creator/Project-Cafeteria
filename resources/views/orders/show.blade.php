@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-receipt" style="color: #6366f1;"></i> Order #{{ $order->id }}
            </h2>
            <p style="color: #6b7280; margin-top: 5px;">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" style="background: #f3f4f6; color: #1f2937; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        
        <div class="card">
            <div class="card-header">
                <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-list"></i> Order Items
                </h4>
            </div>
            <div class="card-body">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                            <th style="padding: 12px; color: #6b7280;">Product</th>
                            <th style="padding: 12px; color: #6b7280;">Qty</th>
                            <th style="padding: 12px; color: #6b7280;">Price</th>
                            <th style="padding: 12px; color: #6b7280;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px; font-weight: 600;">{{ $item->product->name ?? 'N/A' }}</td>
                                <td style="padding: 12px;">{{ $item->quantity }}</td>
                                <td style="padding: 12px;">{{ $item->price }} EGP</td>
                                <td style="padding: 12px; font-weight: 700; color: #6366f1;">{{ $item->price * $item->quantity }} EGP</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="padding: 20px; text-align: right; font-weight: 700; font-size: 1.1rem;">Total:</td>
                            <td style="padding: 20px; font-weight: 700; font-size: 1.1rem; color: #6366f1;">{{ $order->total_price }} EGP</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user"></i> Customer Info
                    </h4>
                </div>
                <div class="card-body">
                    <p style="margin-bottom: 10px;"><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p style="margin-bottom: 10px;"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p style="margin-bottom: 10px;"><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-info-circle"></i> Update Status
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Order Status</label>
                            <select name="status" class="form-control" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo';">
                                <option value="pending"   {{ $order->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="ready"     {{ $order->status == 'ready'     ? 'selected' : '' }}>Ready</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- ✅ كارت Payment Status --}}
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981, #047857);">
                    <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-money-bill-wave"></i> Payment Status
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Payment</label>
                            <select name="payment_status" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo';">
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid"   {{ $order->payment_status == 'paid'   ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #10b981, #047857);">
                            <i class="fas fa-save"></i> Update Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection