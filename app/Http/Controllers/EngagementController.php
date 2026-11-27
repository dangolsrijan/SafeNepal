<?php

namespace App\Http\Controllers;

use App\Models\AgencyProfile;
use App\Models\Destination;
use App\Models\GuideProfile;
use App\Models\Inquiry;
use App\Models\InquiryMessage;
use App\Models\Package;
use App\Models\Review;
use App\Models\SavedItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EngagementController extends Controller
{
    public function toggleSavedItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:destination,package,guide,agency'],
            'id' => ['required', 'integer'],
        ]);

        $map = [
            'destination' => Destination::class,
            'package' => Package::class,
            'guide' => GuideProfile::class,
            'agency' => AgencyProfile::class,
        ];

        $modelClass = $map[$validated['type']];
        $model = $modelClass::findOrFail($validated['id']);

        $existing = SavedItem::where('user_id', $request->user()->id)
            ->where('saveable_type', $modelClass)
            ->where('saveable_id', $model->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Removed from your saved items.');
        }

        SavedItem::create([
            'user_id' => $request->user()->id,
            'saveable_type' => $modelClass,
            'saveable_id' => $model->id,
        ]);

        return back()->with('success', 'Saved to your SafeNepal collection.');
    }

    public function storeReview(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:destination,package,guide,agency'],
            'id' => ['required', 'integer'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:150'],
            'comment' => ['required', 'string', 'min:8', 'max:1500'],
        ]);

        $map = [
            'destination' => Destination::class,
            'package' => Package::class,
            'guide' => GuideProfile::class,
            'agency' => AgencyProfile::class,
        ];

        $modelClass = $map[$validated['type']];
        $model = $modelClass::findOrFail($validated['id']);

        $duplicate = Review::where('user_id', $request->user()->id)
            ->where('reviewable_type', $modelClass)
            ->where('reviewable_id', $model->id)
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'You have already submitted a review for this item.');
        }

        Review::create([
            'user_id' => $request->user()->id,
            'reviewable_type' => $modelClass,
            'reviewable_id' => $model->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);

        $stats = Review::where('reviewable_type', $modelClass)
            ->where('reviewable_id', $model->id)
            ->where('is_approved', true)
            ->selectRaw('COUNT(*) as cnt, AVG(rating) as avg_rating')
            ->first();

        $model->update([
            'rating_avg' => round((float) ($stats->avg_rating ?? 0), 2),
            'reviews_count' => (int) ($stats->cnt ?? 0),
        ]);

        return back()->with('success', 'Thank you! Your review has been published.');
    }

    public function storeInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'agency_id' => ['nullable', 'exists:agency_profiles,id'],
            'guide_id' => ['nullable', 'exists:guide_profiles,id'],
            'destination_id' => ['nullable', 'exists:destinations,id'],
            'subject' => ['required', 'string', 'max:160'],
            'travel_date' => ['nullable', 'date'],
            'travelers_count' => ['required', 'integer', 'min:1', 'max:50'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        if (empty($validated['agency_id']) && empty($validated['guide_id'])) {
            return back()->with('error', 'Please select a valid agency or guide.');
        }

        // If inquiring about a guide belonging to an agency, link agency too so agency can view/respond
        $agencyId = $validated['agency_id'] ?? null;
        if (! $agencyId && ! empty($validated['guide_id'])) {
            $guide = GuideProfile::find($validated['guide_id']);
            $agencyId = $guide?->agency_id;
        }

        $inquiry = Inquiry::create([
            'user_id' => $request->user()->id,
            'agency_id' => $agencyId,
            'guide_id' => $validated['guide_id'] ?? null,
            'destination_id' => $validated['destination_id'] ?? null,
            'subject' => $validated['subject'],
            'travel_date' => $validated['travel_date'] ?? null,
            'travelers_count' => $validated['travelers_count'],
            'status' => 'open',
        ]);

        InquiryMessage::create([
            'inquiry_id' => $inquiry->id,
            'sender_id' => $request->user()->id,
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Your inquiry has been sent! Track replies in your dashboard.');
    }

    public function replyInquiry(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $user = $request->user();
        $isOwner = $inquiry->user_id === $user->id;
        $isAssignedAgency = $user->isAgency() && $user->agencyProfile && $inquiry->agency_id === $user->agencyProfile->id;
        $isAdmin = $user->isAdmin();

        abort_unless($isOwner || $isAssignedAgency || $isAdmin, 403);

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
            'status' => ['nullable', 'in:open,responded,closed'],
        ]);

        InquiryMessage::create([
            'inquiry_id' => $inquiry->id,
            'sender_id' => $user->id,
            'message' => $validated['message'],
        ]);

        if ($isAssignedAgency && ! isset($validated['status'])) {
            $inquiry->update(['status' => 'responded']);
        } elseif (isset($validated['status']) && ($isAssignedAgency || $isAdmin)) {
            $inquiry->update(['status' => $validated['status']]);
        }

        return back()->with('success', 'Reply sent.');
    }
}
