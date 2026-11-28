@php
    $tags = ['Himalayas', 'Trekking', 'Everest', 'Pokhara', 'Annapurna', 'Mustang', 'Chitwan', 'Culture', 'Expedition', 'Safety'];
@endphp

<section class="sn-section sn-section-porcelain" data-reveal>
    <div class="sn-container">
        <div class="sn-section-center">
            <span class="av-badge">Our Gallery</span>
            <h2 class="sn-h2" style="max-width:20ch;">Moments that make the journey feel personal.</h2>
        </div>

        <div class="av-marquee-wrap" aria-hidden="true">
            <div class="av-marquee-track">
                @foreach(array_merge($tags, $tags) as $tag)
                    <span class="av-marquee-pill">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        <div class="av-gallery-grid">
            <div class="av-gallery-item is-tall">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=900&q=80" alt="Everest Base Camp peaks" loading="lazy">
                <span class="av-gallery-label">Everest Region</span>
            </div>
            <div class="av-gallery-item is-wide">
                <img src="https://images.unsplash.com/photo-1585016495481-91613a3ab1bc?auto=format&fit=crop&w=1100&q=80" alt="Annapurna trails" loading="lazy">
                <span class="av-gallery-label">Annapurna Sanctuary</span>
            </div>
            <div class="av-gallery-item">
                <img src="https://images.unsplash.com/photo-1605640840605-14ac1855827b?auto=format&fit=crop&w=800&q=80" alt="Kathmandu Stupa" loading="lazy">
                <span class="av-gallery-label">Kathmandu Valley</span>
            </div>
            <div class="av-gallery-item">
                <img src="https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?auto=format&fit=crop&w=800&q=80" alt="Pokhara sunrise" loading="lazy">
                <span class="av-gallery-label">Pokhara Lakeside</span>
            </div>
            <div class="av-gallery-item is-wide">
                <img src="https://images.unsplash.com/photo-1571401835393-8c5f35328320?auto=format&fit=crop&w=1100&q=80" alt="Upper Mustang canyon" loading="lazy">
                <span class="av-gallery-label">Upper Mustang</span>
            </div>
        </div>
    </div>
</section>
