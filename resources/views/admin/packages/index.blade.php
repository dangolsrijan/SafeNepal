@extends('layouts.dashboard')

@section('title', 'Manage Packages — Admin')
@section('page_title', 'Package Moderation')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Package</th>
                <th>Agency</th>
                <th>Price</th>
                <th>Approval</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $p)
                <tr>
                    <td><strong>{{ $p->title }}</strong><div class="sn-muted" style="font-size:0.8rem;">{{ $p->destination?->name }}</div></td>
                    <td>{{ $p->agency?->name }}</td>
                    <td>NPR {{ number_format($p->price_npr) }}</td>
                    <td><x-status-badge :status="$p->approval_status" /></td>
                    <td>
                        <div class="sn-flex">
                            <form method="POST" action="{{ route('admin.packages.approval', $p) }}" class="sn-flex">
                                @csrf
                                @method('PATCH')
                                <select name="approval_status" class="sn-select" style="width:120px;padding:0.35rem;">
                                    @foreach(['pending', 'approved', 'rejected'] as $st)
                                        <option value="{{ $st }}" {{ $p->approval_status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Save</button>
                            </form>
                            <form method="POST" action="{{ route('admin.packages.destroy', $p) }}" onsubmit="return confirm('Remove package?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
