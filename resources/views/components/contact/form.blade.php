<div class="sn-card" style="padding:2rem;">
    <span class="sn-eyebrow">Get in Touch</span>
    <h1 class="sn-h2">Contact SafeNepal</h1>
    <p class="sn-muted sn-mb-3">Questions about partnering as a local Nepali travel agency, destination safety records, or platform support?</p>

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
