@switch($icon ?? 'handyman')
    @case('plumbing')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M8 28V16M8 16C8 10 14 8 18 12M18 12V6M18 12C22 8 28 10 28 16M28 16V28" stroke="{{ $color ?? '#1b3a30' }}" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="8" cy="29" r="2" fill="{{ $color ?? '#1b3a30' }}"/>
            <circle cx="28" cy="29" r="2" fill="{{ $color ?? '#1b3a30' }}"/>
        </svg>
        @break
    @case('electrical')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M21 4L11 20h9l-5 12L25 16h-9L21 4z" fill="{{ $color ?? '#d4900a' }}" stroke="{{ $color ?? '#d4900a' }}" stroke-width="0.5" stroke-linejoin="round"/>
        </svg>
        @break
    @case('carpentry')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M8 28L28 8M12 8h-4v4M24 28h4v-4" stroke="{{ $color ?? '#e07b39' }}" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8 28L4 32M28 8l4-4" stroke="{{ $color ?? '#e07b39' }}" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break
    @case('painting')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <rect x="14" y="4" width="8" height="14" rx="3" stroke="{{ $color ?? '#e07b39' }}" stroke-width="2"/>
            <path d="M18 18v6" stroke="{{ $color ?? '#e07b39' }}" stroke-width="2" stroke-linecap="round"/>
            <rect x="10" y="24" width="16" height="8" rx="2" stroke="{{ $color ?? '#e07b39' }}" stroke-width="2"/>
        </svg>
        @break
    @case('ac')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <rect x="4" y="10" width="28" height="14" rx="3" stroke="{{ $color ?? '#3b82f6' }}" stroke-width="2"/>
            <path d="M10 24v4M26 24v4" stroke="{{ $color ?? '#3b82f6' }}" stroke-width="2" stroke-linecap="round"/>
            <path d="M10 17h4M10 20h8" stroke="{{ $color ?? '#3b82f6' }}" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
        @break
    @case('cleaning')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M18 6v16M14 10l4-4 4 4" stroke="{{ $color ?? '#1b3a30' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 22c0 0 2 4 8 4s8-4 8-4" stroke="{{ $color ?? '#1b3a30' }}" stroke-width="2" stroke-linecap="round"/>
            <path d="M8 28h20" stroke="{{ $color ?? '#1b3a30' }}" stroke-width="2" stroke-linecap="round"/>
        </svg>
        @break
    @case('appliance')
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <rect x="6" y="6" width="24" height="24" rx="4" stroke="{{ $color ?? '#7c3aed' }}" stroke-width="2"/>
            <circle cx="18" cy="18" r="5" stroke="{{ $color ?? '#7c3aed' }}" stroke-width="2"/>
            <circle cx="18" cy="18" r="2" fill="{{ $color ?? '#7c3aed' }}"/>
            <path d="M10 10h3M10 13h2" stroke="{{ $color ?? '#7c3aed' }}" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        @break
    @case('handyman')
    @default
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
            <path d="M10 26L22 14M22 14l2-4 4 4-4 2M22 14l2 2" stroke="{{ $color ?? '#92400e' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="10" cy="27" r="3" stroke="{{ $color ?? '#92400e' }}" stroke-width="2"/>
        </svg>
@endswitch
