@extends('layouts.dashboard')

@section('title', 'Agency Inquiries — SafeNepal')
@section('page_title', 'Inquiry Management')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">Traveler Inquiries</h2>

@forelse($inquiries as $inq)
    <div class="sn-card sn-mb-3" style="padding:1.5rem;">
        <div class="sn-flex-between sn-mb-2">
            <div>
                <h3 class="sn-h3" style="margin:0;">{{ $inq->subject }}</h3>
                <div class="sn-muted" style="font-size:0.84rem;">
                    From: <strong>{{ $inq->user?->name }}</strong> ({{ $inq->user?->email }}) • {{ $inq->travelers_count }} traveler(s)
                    @if($inq->travel_date) • Date: {{ $inq->travel_date->format('M d, Y') }} @endif
                </div>
            </div>
            <x-status-badge :status="$inq->status" />
        </div>

        <div style="background:var(--sn-bg);border-radius:10px;padding:1rem;margin-bottom:1rem;">
            @foreach($inq->messages as $msg)
                <div style="margin-bottom:0.65rem;padding-bottom:0.65rem;border-bottom:1px solid var(--sn-border);">
                    <strong style="font-size:0.84rem;color:var(--sn-forest);">{{ $msg->sender?->name }}</strong>
                    <span class="sn-muted" style="font-size:0.75rem;margin-left:0.4rem;">{{ $msg->created_at->format('M d, H:i') }}</span>
                    <p style="margin:0.2rem 0 0;font-size:0.9rem;">{{ $msg->message }}</p>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('inquiries.reply', $inq) }}" class="sn-flex" style="flex-wrap:wrap;">
            @csrf
            <input type="text" name="message" class="sn-input" style="flex:1;min-width:220px;" placeholder="Write your agency response..." required>
            <select name="status" class="sn-select" style="width:140px;">
                <option value="responded" {{ $inq->status === 'responded' ? 'selected' : '' }}>Responded</option>
                <option value="open" {{ $inq->status === 'open' ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ $inq->status === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Send Reply</button>
        </form>
    </div>
@empty
    <x-empty-state title="No inquiries yet" message="Traveler messages sent to your agency or team guides will appear here." />
@endforelse
@endsection
