@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
    <div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-users" style="color: #6366f1;"></i> Users Management
        </h2>
        <a href="{{ route('users.create') }}" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                        <th style="padding: 15px; color: #6b7280;">ID</th>
                        <th style="padding: 15px; color: #6b7280;">Name</th>
                        <th style="padding: 15px; color: #6b7280;">Email</th>
                        <th style="padding: 15px; color: #6b7280;">Role</th>
                        <th style="padding: 15px; color: #6b7280;">Phone</th>
                        <th style="padding: 15px; color: #6b7280;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 15px; font-weight: 700;">#{{ $user->id }}</td>
                            <td style="padding: 15px;">{{ $user->name }}</td>
                            <td style="padding: 15px;">{{ $user->email }}</td>
                            <td style="padding: 15px;">
                                <span style="background: {{ $user->role == 'admin' ? '#dbeafe' : '#d1fae5' }}; color: {{ $user->role == 'admin' ? '#1e40af' : '#065f46' }}; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td style="padding: 15px;">{{ $user->phone ?? '-' }}</td>
                            <td style="padding: 15px;">
                                <a href="{{ route('users.edit', $user->id) }}" style="background: #6366f1; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection