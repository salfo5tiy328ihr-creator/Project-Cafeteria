@extends('layouts.customer')

@section('title', 'Home')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-home" style="color: #6366f1;"></i> Welcome, {{ auth()->user()->name }}!
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Browse our menu, search for items, add to cart, and get AI recommendations.</p>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center; padding: 50px;">
            <i class="fas fa-utensils fa-4x" style="color: #c7d2fe; margin-bottom: 20px;"></i>
            <h3 style="color: #1f2937; font-weight: 700;">Ready to order?</h3>
            <p style="color: #6b7280; margin-bottom: 25px;">Explore our delicious food and beverages.</p>
            
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('menu') }}" class="btn-submit" style="width: auto; padding: 15px 40px; display: inline-flex; text-decoration: none;">
                    <i class="fas fa-book-open"></i> Browse Menu
                </a>
                <a href="{{ route('customer.profile.edit') }}" class="btn-submit" style="width: auto; padding: 15px 40px; display: inline-flex; text-decoration: none; background: white; color: #6366f1; border: 2px solid #6366f1; box-shadow: none;">
                    <i class="fas fa-user-cog"></i> My Preferences
                </a>
            </div>
        </div>
    </div>
@endsection