@extends('layouts.dashboard')

@section('title', 'Moderate Reviews — Admin')
@section('page_title', 'Review Management')
@section('sidebar') @include('admin._sidebar') @endsection

@section('content')
<div class="sn-table-wrap">
    <table class="sn-table">
        <thead>
            <tr>
                <th>Traveler</th>
                <th>Target</th>
                <th>Rating & Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $r)
                <tr>
                    <td><strong>{{ $r->user?->name }}</strong></td>
                    <td>{{ $r->reviewable?->title ?? $r->reviewable?->name ?? 'Item' }}</td>
                    <td><strong>★ {{ $r->rating }}/5</strong> — {{ \Illuminate\Support\Str::limit($r->comment, 100) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}" onsubmit="return confirm('Remove this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sn-btn sn-btn-ghost sn-btn-sm" style="color:var(--sn-high-fg);">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
