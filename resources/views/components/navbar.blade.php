<nav style="
    width: 100%;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 3.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    position: relative;
    z-index: 100;
">

    {{-- ── LOGO ── --}}
    <a href="#" style="display:flex; align-items:center; gap:0.5rem; text-decoration:none; flex-shrink:0;">
        {{-- Orange rounded square with white house icon inside — exactly as in image --}}
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            {{-- Orange rounded background --}}
            <rect width="36" height="36" rx="8" fill="#e07b39"/>
            {{-- White house shape --}}
            <path d="M18 8L7 17H10.5V28H15.5V22H20.5V28H25.5V17H29L18 8Z" fill="white"/>
        </svg>
        <span style="font-size:1.25rem; font-weight:700; color:#111827; letter-spacing:-0.3px;">
            Fix<span style="color:#e07b39;">It</span>
        </span>
    </a>

    {{-- ── NAV LINKS ── --}}
    <div style="display:flex; align-items:center; gap:2.75rem;">
        <a href="#how-it-works" style="font-size:0.875rem; font-weight:500; color:#374151; text-decoration:none;">How it works</a>
        <a href="#browse"       style="font-size:0.875rem; font-weight:500; color:#374151; text-decoration:none;">Browse services</a>
        <a href="#professionals" style="font-size:0.875rem; font-weight:500; color:#374151; text-decoration:none;">For professionals</a>
    </div>

    {{-- ── AUTH ── --}}
    <div style="display:flex; align-items:center; gap:1.75rem;">
        <a href="#" style="font-size:0.875rem; font-weight:500; color:#374151; text-decoration:none;">Log in</a>
        <a href="#" style="
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            background: #e07b39;
            padding: 0.55rem 1.4rem;
            border-radius: 0.6rem;
            text-decoration: none;
            display: inline-block;
        ">Sign up</a>
    </div>

</nav>
