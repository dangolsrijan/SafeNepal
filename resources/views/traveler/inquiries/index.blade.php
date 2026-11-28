@extends('layouts.dashboard')

@section('title', 'My Inquiries — SafeNepal')
@section('page_title', 'Inquiries & Messages')
@section('sidebar') @include('traveler._sidebar') @endsection

@section('content')
<h2 class="sn-h2 sn-mb-3">My Agency & Guide Inquiries</h2>

@forelse($inquiries as $inq)
    <div class="sn-card sn-mb-3" style="padding:1.5rem;" data-inquiry-thread>
        <div class="sn-flex-between sn-mb-2">
            <div>
                <h3 class="sn-h3" style="margin:0;">{{ $inq->subject }}</h3>
                <div class="sn-muted" style="font-size:0.84rem;">
                    To: <strong>{{ $inq->recipient_name }}</strong>
                    @if($inq->destination_name) • {{ $inq->destination_name }} @endif
                    @if($inq->travel_date_label) • {{ $inq->travel_date_label }} @endif
                    • {{ $inq->travelers_count }} traveler(s)
                </div>
            </div>
            <x-status-badge :status="$inq->status" />
        </div>

        <div style="background:var(--sn-bg);border-radius:10px;padding:1rem;margin-bottom:1rem;" data-inquiry-messages>
            @foreach($inq->messages as $msg)
                <div style="margin-bottom:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--sn-border);">
                    <strong style="font-size:0.85rem;color:var(--sn-forest);">{{ $msg->sender_name }}</strong>
                    <span class="sn-muted" style="font-size:0.76rem;margin-left:0.5rem;">{{ $msg->time_label }}</span>
                    <p style="margin:0.25rem 0 0;font-size:0.9rem;">{{ $msg->message }}</p>
                </div>
            @endforeach
        </div>

        <form data-demo-reply-form data-sender-name="{{ $demoUser->name }}" class="sn-flex">
            <input type="text" name="message" class="sn-input" placeholder="Write a follow-up message (demo preview)..." required>
            <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Send Reply</button>
        </form>
    </div>
@empty
    <x-empty-state title="No inquiries yet" message="Visit any Guide or Agency profile to ask questions about custom itineraries or availability." actionText="Browse Agencies" :actionUrl="route('agencies.index')" />
@endforelse
@endsection
