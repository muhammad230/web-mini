<section id="professionals" style="background:#f2f1ec; padding:36px 56px 48px;">
    <div style="max-width:960px; margin:0 auto;">

        {{-- Title --}}
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:1.85rem; font-weight:800; color:#111827; margin:0 0 8px;">
                {{ $featuredPros['title'] ?? 'Featured Professionals' }}
            </h2>
            <div style="width:48px; height:3px; background:#E8823C; border-radius:2px; margin:0 auto;"></div>
        </div>

        @php $pros = $featuredPros['pros'] ?? collect(); @endphp

        @if($pros->isEmpty())
            <p style="text-align:center; color:#9ca3af; font-size:0.875rem;">No featured professionals yet.</p>
        @else
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
            @foreach($pros as $pro)
            @php
                $reviewCount = \Illuminate\Support\Facades\DB::table('reviews')->where('pro_id',$pro->id)->count();
                $avgRating   = (float)($pro->avg_rating ?? 0);
                $jobsDone    = \Illuminate\Support\Facades\DB::table('customer_jobs')
                                ->where('assigned_pro_id',$pro->id)->where('status','completed')->count();
            @endphp
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px 20px; box-shadow:0 2px 12px rgba(0,0,0,0.06);">

                {{-- Photo + info row --}}
                <div style="display:flex; align-items:flex-start; gap:14px; margin-bottom:14px;">
                    <div style="position:relative; flex-shrink:0;">
                        @if($pro->profile_photo)
                            <img src="{{ asset('storage/' . $pro->profile_photo) }}" alt="{{ $pro->name }}"
                                 style="width:72px; height:72px; border-radius:50%; object-fit:cover; display:block;">
                        @else
                            <div style="width:72px; height:72px; border-radius:50%; background:#E8823C; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.5rem; font-weight:700;">
                                {{ strtoupper(substr($pro->name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="position:absolute; bottom:2px; right:2px; width:20px; height:20px;
                                    border-radius:50%; background:#16302A; border:2px solid #fff;
                                    display:flex; align-items:center; justify-content:center;">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                <path d="M2 5l2.5 2.5L8 3" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div style="font-size:0.95rem; font-weight:700; color:#111827; margin-bottom:2px;">{{ $pro->name }}</div>
                        <div style="font-size:0.8rem; color:#6b7280; margin-bottom:6px;">{{ $pro->trade ?? 'Professional' }}</div>
                        {{-- Stars --}}
                        <div style="display:flex; align-items:center; gap:5px;">
                            <div style="display:flex; gap:1px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                         fill="{{ $i <= round($avgRating) ? '#D9A441' : 'none' }}"
                                         stroke="#D9A441" stroke-width="1.5">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span style="font-size:0.82rem; font-weight:600; color:#374151;">
                                {{ $avgRating > 0 ? number_format($avgRating, 1) : 'New' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Bio / description --}}
                <p style="font-size:0.78rem; color:#6b7280; line-height:1.65; margin:0 0 14px;">
                    @if($pro->bio)
                        {{ Str::limit($pro->bio, 90) }}
                    @elseif($pro->years_experience)
                        {{ $pro->years_experience }}+ years experience in {{ $pro->trade ?? 'home services' }}.
                    @else
                        Verified professional ready to help with {{ $pro->trade ?? 'home services' }}.
                    @endif
                </p>

                {{-- Starting price --}}
                <div style="font-size:0.85rem; font-weight:700; color:#E8823C;">
                    @if($pro->starting_price)
                        Starting from Rs. {{ number_format($pro->starting_price) }}
                    @else
                        Contact for pricing
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>
