@extends('layouts.dashboard')

@section('title', 'Manage Users — Admin')
@section('page_title', 'User Management')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<form method="GET" action="{{ route('admin.users.index') }}" class="sn-card sn-mb-3" style="padding:1rem;">
    <div class="sn-flex" style="flex-wrap:wrap;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or email..." class="sn-input" style="max-width:280px;">
        <select name="role" class="sn-select" style="max-width:180px;">
            <option value="">All Roles</option>
            @foreach(['traveler', 'agency', 'admin'] as $r)
                <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Filter</button>
        <a href="{{ route('admin.users.index') }}" class="sn-btn sn-btn-outline sn-btn-sm">Clear</a>
    </div>
</form>

<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="sn-badge sn-badge-sage">{{ ucfirst($user->role) }}</span></td>
                    <td><x-status-badge :status="$user->is_active ? 'active' : 'suspended'" /></td>
                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="sn-btn sn-btn-outline sn-btn-sm">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        @else
                            <span class="sn-muted">Current Admin</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->links('components.pagination') }}
@endsection
