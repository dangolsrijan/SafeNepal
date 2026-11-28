<div class="sn-card" style="padding:1.75rem;">
    <h2 class="sn-h3">Traveler Reviews (<span data-review-count>{{ $package->reviews->count() }}</span>)</h2>
    <div data-review-list>
        @forelse($package->reviews as $review)
            <div class="sn-mb-2"><x-review-card :review="$review" /></div>
        @empty
            <p class="sn-muted" data-review-empty>No reviews yet for this package.</p>
        @endforelse
    </div>

    <form data-demo-review-form data-author-name="{{ $demoUser->name }}" class="sn-mt-3" style="border-top:1px solid var(--sn-border);padding-top:1.25rem;">
        <h3 class="sn-h3" style="font-size:1rem;">Leave a Review (Demo Preview)</h3>
        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Rating</label>
                <select name="rating" class="sn-select" required>
                    <option value="5">5 — Exceptional</option>
                    <option value="4">4 — Great</option>
                    <option value="3">3 — Good</option>
                    <option value="2">2 — Fair</option>
                    <option value="1">1 — Poor</option>
                </select>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Title</label>
                <input type="text" name="title" class="sn-input" placeholder="Highlight of your trip">
            </div>
        </div>
        <div class="sn-form-group">
            <label class="sn-label">Comment</label>
            <textarea name="comment" rows="3" class="sn-textarea" required minlength="8" placeholder="Share your thoughts on this package..."></textarea>
        </div>
        <button type="submit" class="sn-btn sn-btn-primary sn-btn-sm">Preview Review</button>
    </form>
</div>
