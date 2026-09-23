@extends('layouts.customer')

@section('title', 'Purchase Cart')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-shopping-basket" style="color: #6366f1;"></i> Purchase Cart
        </h2>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($items->isEmpty())
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-shopping-basket fa-3x" style="color: #d1d5db; margin-bottom: 15px;"></i>
                    <h4 style="color: #6b7280;">Your cart is empty</h4>
                    <a href="{{ route('menu') }}" style="display: inline-block; margin-top: 15px; padding: 10px 25px; background: #6366f1; color: white; text-decoration: none; border-radius: 10px;">Browse Menu</a>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                            <th style="padding: 15px; color: #6b7280;">Product</th>
                            <th style="padding: 15px; color: #6b7280;">Price</th>
                            <th style="padding: 15px; color: #6b7280;">Quantity</th>
                            <th style="padding: 15px; color: #6b7280;">Subtotal</th>
                            <th style="padding: 15px; color: #6b7280;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($items as $item)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 15px; font-weight: 600;">{{ $item->product->name }}</td>
                                <td style="padding: 15px;">{{ $item->product->price }} EGP</td>
                                <td style="padding: 15px;">{{ $item->quantity }}</td>
                                <td style="padding: 15px; font-weight: 700; color: #6366f1;">{{ $item->product->price * $item->quantity }} EGP</td>
                                <td style="padding: 15px;">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: 600;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @php $total += $item->product->price * $item->quantity; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="padding: 20px; text-align: right; font-weight: 700; font-size: 1.2rem;">Total:</td>
                            <td colspan="2" style="padding: 20px; font-weight: 700; font-size: 1.2rem; color: #6366f1;">{{ $total }} EGP</td>
                        </tr>
                    </tfoot>
                </table>
                
                <div style="margin-top: 25px; text-align: right;">
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-submit" style="width: auto; padding: 15px 40px; display: inline-flex;">
                            <i class="fas fa-check-circle"></i> Proceed to Checkout
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection