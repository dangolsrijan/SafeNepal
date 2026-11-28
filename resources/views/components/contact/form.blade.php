<div class="sn-card" style="padding:2rem;">
    <h2 class="sn-h3 sn-mb-2">Send Us a Message</h2>

    <form method="POST" action="{{ route('contact.submit') }}">
        @csrf
        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Your Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="sn-input" required>
            </div>
        </div>
        <div class="sn-form-group">
            <label class="sn-label">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="sn-input" required>
        </div>
        <div class="sn-form-group">
            <label class="sn-label">Message</label>
            <textarea name="message" rows="5" class="sn-textarea" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="sn-btn sn-btn-primary">Send Message</button>
    </form>
</div>
