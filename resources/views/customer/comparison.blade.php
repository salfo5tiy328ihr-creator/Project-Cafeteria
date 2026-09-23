@extends('layouts.customer')

@section('title', 'AI Food Comparison')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-balance-scale" style="color: #6366f1;"></i> AI Food Comparison
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Compare two items side by side.</p>
    </div>

    <div class="card" style="margin-bottom: 25px;">
        <div class="card-body">
            <form action="{{ route('comparison.compare') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 15px; align-items: end;">
                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; display: block;">Item 1</label>
                        <select name="item1" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo';" required>
                            <option value="">Select...</option>
                            @foreach($products as $p)
                                <option value="{{ $p->composite_key }}" {{ isset($item1) && $item1->composite_key == $p->composite_key ? 'selected' : '' }}>{{ $p->name }} ({{ $p->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; display: block;">Item 2</label>
                        <select name="item2" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo';" required>
                            <option value="">Select...</option>
                            @foreach($products as $p)
                                <option value="{{ $p->composite_key }}" {{ isset($item2) && $item2->composite_key == $p->composite_key ? 'selected' : '' }}>{{ $p->name }} ({{ $p->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-submit" style="padding: 12px 25px; width: auto;">
                        <i class="fas fa-balance-scale"></i> Compare
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($item1) && isset($item2))
        <div class="card">
            <div class="card-body">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 15px; text-align: left; color: #6b7280;">Feature</th>
                            <th style="padding: 15px; text-align: center; color: #6366f1; font-size: 1.1rem;">{{ $item1->name }}</th>
                            <th style="padding: 15px; text-align: center; color: #6366f1; font-size: 1.1rem;">{{ $item2->name }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 600;">Type</td>
                            <td style="padding: 15px; text-align: center;">{{ $item1->type }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $item2->type }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 600;">Price</td>
                            <td style="padding: 15px; text-align: center; font-weight: 700; color: {{ $item1->price <= $item2->price ? '#10b981' : '#1f2937' }};">{{ $item1->price }} EGP</td>
                            <td style="padding: 15px; text-align: center; font-weight: 700; color: {{ $item2->price <= $item1->price ? '#10b981' : '#1f2937' }};">{{ $item2->price }} EGP</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 600;">Calories</td>
                            <td style="padding: 15px; text-align: center;">{{ $item1->calories ?? 'N/A' }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $item2->calories ?? 'N/A' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 600;">Spicy Level</td>
                            <td style="padding: 15px; text-align: center;">{{ $item1->spicy_level ?? 'N/A' }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $item2->spicy_level ?? 'N/A' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 600;">Description</td>
                            <td style="padding: 15px; text-align: center; font-size: 0.9rem;">{{ $item1->description ?? 'N/A' }}</td>
                            <td style="padding: 15px; text-align: center; font-size: 0.9rem;">{{ $item2->description ?? 'N/A' }}</td>
                        </tr>
                        <tr style="background: #f9fafb;">
                            <td style="padding: 15px; font-weight: 700;">Match % (for you)</td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="background: {{ $match1 >= 70 ? '#d1fae5' : ($match1 >= 40 ? '#fef3c7' : '#fee2e2') }}; color: {{ $match1 >= 70 ? '#065f46' : ($match1 >= 40 ? '#92400e' : '#991b1b') }}; padding: 8px 18px; border-radius: 20px; font-weight: 800;">{{ $match1 }}%</span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="background: {{ $match2 >= 70 ? '#d1fae5' : ($match2 >= 40 ? '#fef3c7' : '#fee2e2') }}; color: {{ $match2 >= 70 ? '#065f46' : ($match2 >= 40 ? '#92400e' : '#991b1b') }}; padding: 8px 18px; border-radius: 20px; font-weight: 800;">{{ $match2 }}%</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection