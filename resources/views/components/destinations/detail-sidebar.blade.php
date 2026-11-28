<aside>
    @if($destination->safetyInformation)
        <div class="sn-card sn-mb-3" style="padding:1.5rem;">
            <div class="sn-flex-between sn-mb-2">
                <h3 class="sn-h3" style="margin:0;">Safety Profile</h3>
                <span class="sn-badge sn-badge-demo">DEMO DATA</span>
            </div>
            <div class="sn-mb-2">
                <x-risk-indicator :level="$destination->safetyInformation->risk_level" />
            </div>
            <p class="sn-muted" style="font-size:0.9rem;">{{ $destination->safetyInformation->safety_description }}</p>

            @if(!empty($destination->safetyInformation->risk_factors))
                <h4 style="font-size:0.9rem;margin:1rem 0 0.4rem;">Key Risk Factors</h4>
                <ul style="margin:0;padding-left:1.2rem;font-size:0.86rem;color:var(--sn-slate);">
                    @foreach($destination->safetyInformation->risk_factors as $factor)
                        <li>{{ $factor }}</li>
                    @endforeach
                </ul>
            @endif

            @if(!empty($destination->safetyInformation->recommended_preparation))
                <h4 style="font-size:0.9rem;margin:1rem 0 0.4rem;">Recommended Preparation</h4>
                <ul style="margin:0;padding-left:1.2rem;font-size:0.86rem;color:var(--sn-slate);">
                    @foreach($destination->safetyInformation->recommended_preparation as $prep)
                        <li>{{ $prep }}</li>
                    @endforeach
                </ul>
            @endif

            @if($destination->safetyInformation->altitude_awareness)
                <div class="sn-alert sn-alert-warning sn-mt-2" style="margin-bottom:0;font-size:0.84rem;">
                    <strong>Altitude Note:</strong> {{ $destination->safetyInformation->altitude_awareness }}
                </div>
            @endif
        </div>

        @if(!empty($destination->safetyInformation->weather_demo_data))
            <div class="sn-card sn-mb-3" style="padding:1.5rem;background:var(--sn-mountain-blue);border-color:#BAE6FD;">
                <div class="sn-flex-between sn-mb-1">
                    <h3 class="sn-h3" style="margin:0;font-size:1rem;">Sample Weather</h3>
                    <span class="sn-badge sn-badge-demo">DEMO DATA</span>
                </div>
                <div style="font-size:2rem;font-weight:800;color:var(--sn-forest);">{{ $destination->safetyInformation->weather_demo_data['temp_c'] ?? 18 }}°C</div>
                <div style="font-weight:600;color:var(--sn-ink);">{{ $destination->safetyInformation->weather_demo_data['condition'] ?? 'Clear' }}</div>
                <div class="sn-muted" style="font-size:0.84rem;margin-top:0.5rem;">
                    Wind: {{ $destination->safetyInformation->weather_demo_data['wind_kph'] ?? 10 }} km/h • Precipitation: {{ $destination->safetyInformation->weather_demo_data['precipitation_pct'] ?? 10 }}%
                </div>
                @if(!empty($destination->safetyInformation->weather_demo_data['warning']))
                    <div style="margin-top:0.65rem;font-size:0.82rem;font-weight:700;color:var(--sn-high-fg);">⚠ {{ $destination->safetyInformation->weather_demo_data['warning'] }}</div>
                @endif
            </div>
        @endif
    @endif

    @if($destination->nearbyServices->isNotEmpty())
        <div class="sn-card sn-mb-3" style="padding:1.5rem;">
            <div class="sn-flex-between sn-mb-2">
                <h3 class="sn-h3" style="margin:0;font-size:1rem;">Nearby Essential Services</h3>
                <span class="sn-badge sn-badge-demo">DEMO</span>
            </div>
            @foreach($destination->nearbyServices as $svc)
                <div style="padding:0.65rem 0;border-bottom:1px solid var(--sn-border);">
                    <strong style="font-size:0.9rem;">{{ $svc->name }}</strong>
                    <div class="sn-muted" style="font-size:0.82rem;">{{ ucfirst($svc->category) }} • {{ $svc->address }}</div>
                    <div style="font-size:0.82rem;font-weight:600;color:var(--sn-forest);">☎ {{ $svc->phone }}</div>
                </div>
            @endforeach
            <a href="{{ route('safety.help-near-me', ['region' => $destination->name]) }}" class="sn-btn sn-btn-outline sn-btn-sm sn-mt-2" style="width:100%;">Open Help Near Me</a>
        </div>
    @endif
</aside>
