<aside>
    <div class="sn-card" style="padding:1.5rem;">
        <h3 class="sn-h3">Send Inquiry to {{ $guide->name }}</h3>
        <form data-demo-form data-demo-message="Demo inquiry sent to {{ $guide->name }}. No message was stored in a backend database.">
            <div class="sn-form-group">
                <label class="sn-label">Subject</label>
                <input type="text" name="subject" class="sn-input" required placeholder="e.g., Private guide availability">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Destination</label>
                <select name="destination" class="sn-select">
                    <option value="">Select destination</option>
                    @foreach($destinations as $d)
                        <option value="{{ $d->slug }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sn-grid sn-grid-2">
                <div class="sn-form-group">
                    <label class="sn-label">Travel Date</label>
                    <input type="date" name="travel_date" class="sn-input">
                </div>
                <div class="sn-form-group">
                    <label class="sn-label">Travelers</label>
                    <input type="number" name="travelers_count" value="2" min="1" max="30" class="sn-input" required>
                </div>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Message</label>
                <textarea name="message" rows="4" class="sn-textarea" required minlength="10" placeholder="Share your preferred route, pace, and questions..."></textarea>
            </div>
            <button type="submit" class="sn-btn sn-btn-primary" style="width:100%;">Send Demo Inquiry</button>
        </form>
    </div>
</aside>
