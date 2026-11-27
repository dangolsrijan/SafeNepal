@extends('layouts.dashboard')

@section('title', ($package->exists ? 'Edit' : 'Create').' Package — SafeNepal')
@section('page_title', $package->exists ? 'Edit Package' : 'Create Package')
@section('sidebar') @include('agency._sidebar') @endsection

@section('content')
<div class="sn-card" style="padding:1.75rem;">
    <form method="POST" action="{{ $package->exists ? route('agency.packages.update', $package) : route('agency.packages.store') }}" enctype="multipart/form-data">
        @csrf
        @if($package->exists) @method('PUT') @endif

        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Package Title</label>
                <input type="text" name="title" value="{{ old('title', $package->title) }}" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Destination</label>
                <select name="destination_id" class="sn-select" required>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}" {{ (string) old('destination_id', $package->destination_id) === (string) $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="sn-grid sn-grid-4">
            <div class="sn-form-group">
                <label class="sn-label">Price (NPR)</label>
                <input type="number" name="price_npr" value="{{ old('price_npr', $package->price_npr ?: 35000) }}" min="1000" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Duration (Days)</label>
                <input type="number" name="duration_days" value="{{ old('duration_days', $package->duration_days ?: 5) }}" min="1" max="30" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Difficulty</label>
                <select name="difficulty" class="sn-select">
                    @foreach(['easy', 'moderate', 'challenging'] as $lvl)
                        <option value="{{ $lvl }}" {{ old('difficulty', $package->difficulty ?: 'moderate') === $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Package Type</label>
                <select name="package_type" class="sn-select">
                    @foreach(['trekking', 'cultural', 'wildlife', 'leisure', 'overland', 'spiritual'] as $t)
                        <option value="{{ $t }}" {{ old('package_type', $package->package_type ?: 'trekking') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="sn-grid sn-grid-3">
            <div class="sn-form-group">
                <label class="sn-label">Max Group Size</label>
                <input type="number" name="group_size_max" value="{{ old('group_size_max', $package->group_size_max ?: 10) }}" min="1" max="50" class="sn-input" required>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Availability</label>
                <select name="availability_status" class="sn-select">
                    @foreach(['available', 'limited', 'unavailable'] as $av)
                        <option value="{{ $av }}" {{ old('availability_status', $package->availability_status ?: 'available') === $av ? 'selected' : '' }}>{{ ucfirst($av) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Assigned Guide (Optional)</label>
                <select name="guide_id" class="sn-select">
                    <option value="">None</option>
                    @foreach($guides as $g)
                        <option value="{{ $g->id }}" {{ (string) old('guide_id', $package->guide_id) === (string) $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Short Description</label>
            <input type="text" name="short_description" value="{{ old('short_description', $package->short_description) }}" class="sn-input" required>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Full Overview & Description</label>
            <textarea name="description" rows="4" class="sn-textarea" required>{{ old('description', $package->description) }}</textarea>
        </div>

        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Included Services (One per line)</label>
                <textarea name="included_text" rows="4" class="sn-textarea">{{ old('included_text', implode("\n", $package->included_services ?? [])) }}</textarea>
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Excluded Services (One per line)</label>
                <textarea name="excluded_text" rows="4" class="sn-textarea">{{ old('excluded_text', implode("\n", $package->excluded_services ?? [])) }}</textarea>
            </div>
        </div>

        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Accommodation Details</label>
                <input type="text" name="accommodation_info" value="{{ old('accommodation_info', $package->accommodation_info) }}" class="sn-input">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Transportation Details</label>
                <input type="text" name="transportation_info" value="{{ old('transportation_info', $package->transportation_info) }}" class="sn-input">
            </div>
        </div>

        <div class="sn-grid sn-grid-2">
            <div class="sn-form-group">
                <label class="sn-label">Hero Image URL</label>
                <input type="url" name="hero_image_url" value="{{ old('hero_image_url', $package->hero_image) }}" class="sn-input" placeholder="https://...">
            </div>
            <div class="sn-form-group">
                <label class="sn-label">Or Upload Hero Image (Max 2MB)</label>
                <input type="file" name="hero_image_file" accept="image/*" class="sn-input">
            </div>
        </div>

        <div class="sn-form-group">
            <label class="sn-label">Travel Interests (For Smart Trip Planner Matching)</label>
            @php $selectedInts = old('interests', $package->interests ?? ['Trekking', 'Nature']); @endphp
            <div class="sn-pill-group">
                @foreach($interests as $int)
                    <label class="sn-pill-check">
                        <input type="checkbox" name="interests[]" value="{{ $int }}" {{ in_array($int, $selectedInts, true) ? 'checked' : '' }}>
                        <span>{{ $int }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="sn-form-group">
            <label style="display:flex;align-items:center;gap:0.5rem;font-weight:600;cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $package->exists ? $package->is_published : true) ? 'checked' : '' }}>
                Publish package immediately
            </label>
        </div>

        <div class="sn-flex">
            <button type="submit" class="sn-btn sn-btn-primary">{{ $package->exists ? 'Save Changes' : 'Create Package' }}</button>
            <a href="{{ route('agency.packages.index') }}" class="sn-btn sn-btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
