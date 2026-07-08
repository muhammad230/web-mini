<section class="home-testimonials" style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">

        {{-- Title --}}
        <div style="text-align:center; margin-bottom:36px;">
            <h2 class="section-heading" style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">
                {{ $testimonials['title'] ?? 'What Our Customers Say' }}
            </h2>
            <div style="width:48px; height:3px; background:#E8823C; border-radius:2px; margin:0 auto;"></div>
        </div>

        @php $reviews = $testimonials['reviews'] ?? collect(); @endphp

        @if($reviews->isEmpty())
            <p style="text-align:center; color:#9ca3af; font-size:0.875rem; padding:32px 0;">No reviews yet.</p>
        @else
        <div class="home-testimonials-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            @foreach($reviews->take(4) as $review)
            @php
                $customerName = $review->customer->name ?? 'Customer';
                $proName      = $review->professional->name ?? '';
                $proTrade     = $review->professional->trade ?? '';
            @endphp
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:28px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">

                {{-- Quote mark --}}
                <div style="font-size:3.5rem; line-height:1; color:#D9A441; font-family:Georgia,serif; margin-bottom:6px; opacity:0.85;">&ldquo;</div>

                {{-- Stars --}}
                <div style="display:flex; gap:3px; margin-bottom:12px;">
                    @for($i = 1; $i <= 5; $i++)
                        <svg width="16" height="16" viewBox="0 0 24 24"
                             fill="{{ $i <= $review->rating ? '#D9A441' : 'none' }}"
                             stroke="#D9A441" stroke-width="1.5">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endfor
                </div>

                {{-- Comment --}}
                <p style="font-size:0.88rem; color:#374151; line-height:1.7; margin:0 0 20px;">
                    "{{ $review->comment ?? 'Great service!' }}"
                </p>

                {{-- Reviewer --}}
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:40px; height:40px; border-radius:50%; background:#E8823C;
                                display:flex; align-items:center; justify-content:center;
                                color:#fff; font-weight:700; font-size:0.9rem; flex-shrink:0;">
                        {{ strtoupper(substr($customerName, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.85rem; font-weight:600; color:#111827;">{{ $customerName }}</div>
                        <div style="font-size:0.75rem; color:#9ca3af;">
                            {{ $proTrade ? $proTrade . ' Service' : 'FixIt Customer' }}
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>
