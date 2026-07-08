<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FixIt – Website Content</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; display: flex; min-height: 100vh; }

        .sidebar { width: 240px; height: 100vh; background: #16302A; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; transition: width 0.2s; overflow: hidden; }
        .sidebar.collapsed { width: 64px; }
        .sidebar-logo { padding: 20px 20px 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #1e4238; }
        .sidebar-logo span { font-size: 1.2rem; font-weight: 800; color: #fff; white-space: nowrap; }
        .sidebar-logo span em { color: #E8823C; font-style: normal; }
        .sidebar.collapsed .sidebar-logo span { display: none; }
        .nav-section { padding: 12px 0; flex: 1; overflow-y: auto; min-height: 0; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 10px 18px; cursor: pointer; color: #8aaa9e; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: all 0.15s; white-space: nowrap; position: relative; border-left: 3px solid transparent; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-item.active { color: #fff; background: rgba(232,130,60,0.12); border-left-color: #E8823C; }
        .nav-item svg { flex-shrink: 0; }
        .sidebar.collapsed .nav-item span { display: none; }
        .nav-label { font-size: 0.65rem; font-weight: 700; color: #4a7a6a; text-transform: uppercase; letter-spacing: 0.08em; padding: 16px 20px 4px; }
        .sidebar.collapsed .nav-label { display: none; }
        .sidebar-bottom { padding: 16px; border-top: 1px solid #1e4238; margin-top: auto; }
        .admin-profile { display: flex; align-items: center; gap: 10px; }
        .admin-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
        .admin-info { overflow: hidden; }
        .admin-info .name { font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; }
        .admin-info .role { font-size: 0.72rem; color: #8aaa9e; }
        .sidebar.collapsed .admin-info { display: none; }

        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; transition: margin-left 0.2s; }
        .main.expanded { margin-left: 64px; }
        .topbar { background: #fff; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ece8df; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .toggle-btn { background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .admin-topbar { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .admin-topbar img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        .admin-topbar .tname { font-size: 0.85rem; font-weight: 600; color: #111827; }
        .admin-topbar .trole { font-size: 0.72rem; color: #9ca3af; }

        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 1.4rem; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .page-sub { font-size: 0.82rem; color: #9ca3af; margin-bottom: 24px; }

        .section-card { background: #fff; border-radius: 14px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 16px; overflow: hidden; }
        .section-header { padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; user-select: none; }
        .section-header:hover { background: #faf9f6; }
        .section-header h3 { font-size: 1rem; font-weight: 700; color: #111827; }
        .section-body { padding: 0 24px 24px; display: none; }
        .section-body.open { display: block; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; color: #374151; outline: none; background: #fff; transition: border 0.15s; font-family: 'Inter', sans-serif; }
        .form-control:focus { border-color: #E8823C; box-shadow: 0 0 0 3px rgba(232,130,60,0.1); }
        textarea.form-control { min-height: 80px; resize: vertical; }

        .btn { padding: 10px 22px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.15s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: #E8823C; color: #fff; }
        .btn-primary:hover { background: #c96a2a; }
        .btn-secondary { background: #fff; color: #6b7280; border: 1.5px solid #e5e7eb; }
        .btn-secondary:hover { border-color: #d1d5db; background: #faf9f6; }
        .btn-danger { background: #fff; color: #dc2626; border: 1.5px solid #fca5a5; }
        .btn-danger:hover { background: #fef2f2; }

        .flash-message { padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500; }
        .flash-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .flash-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        .last-updated { font-size: 0.72rem; color: #9ca3af; display: flex; align-items: center; gap: 4px; }
        .inline-flex { display: inline-flex; align-items: center; gap: 8px; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .items-center { align-items: center; }
        .mt-2 { margin-top: 8px; }
        .mb-2 { margin-bottom: 8px; }
        .stat-card-edit { background: #faf9f6; border: 1px solid #ece8df; border-radius: 12px; padding: 16px; }
        .trade-card-edit { background: #faf9f6; border: 1px solid #ece8df; border-radius: 12px; padding: 16px; position: relative; }
        .step-card-edit { background: #faf9f6; border: 1px solid #ece8df; border-radius: 12px; padding: 16px; }

        .icon-select { display: flex; flex-wrap: wrap; gap: 6px; }
        .icon-select label { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.15s; }
        .icon-select label:hover { border-color: #d1d5db; background: #faf9f6; }
        .icon-select input[type="radio"]:checked + label { border-color: #E8823C; background: rgba(232,130,60,0.1); }
        .icon-select input[type="radio"] { display: none; }

        .color-picker-wrapper { display: flex; align-items: center; gap: 8px; }
        .color-picker-wrapper input[type="color"] { width: 40px; height: 40px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; padding: 2px; }
        .color-picker-wrapper input[type="text"] { flex: 1; }

        .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #d1d5db; transition: .3s; border-radius: 24px; }
        .toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .toggle-switch input:checked + .toggle-slider { background-color: #E8823C; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

        .link-group-card { background: #faf9f6; border: 1px solid #ece8df; border-radius: 12px; padding: 16px; margin-bottom: 12px; }
        .link-row { display: flex; gap: 8px; margin-bottom: 8px; align-items: center; }
        .link-row input { flex: 1; }

        .btn-sm { padding: 6px 14px; font-size: 0.78rem; border-radius: 8px; }

        .image-upload-wrapper { display: flex; align-items: center; gap: 16px; }
        .image-preview { width: 120px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #ece8df; background: #faf9f6; }
        .image-upload-btn { position: relative; overflow: hidden; }
        .image-upload-btn input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }

        @media (max-width: 900px) {
            .sidebar { width: 64px; }
            .sidebar .nav-item span, .sidebar .nav-label, .sidebar .sidebar-logo span,
            .sidebar .admin-info { display: none; }
            .main { margin-left: 64px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
        </svg>
        <span>Fix<em>It</em> <span style="font-size:0.65rem;color:#4a7a6a;font-weight:500;">Admin</span></span>
    </div>

    <nav class="nav-section">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <span>Dashboard Overview</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Professionals</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Customers</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>Jobs / Bookings</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>Categories / Trades</span>
        </a>

        <div class="nav-label">Finance</div>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Payments & Payouts</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>Reports / Analytics</span>
        </a>

        <div class="nav-label">Content</div>
        <a href="{{ route('admin.cms') }}" class="nav-item active">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><circle cx="4" cy="4" r="1.5" fill="currentColor" stroke="none"/></svg>
            <span>Website Content</span>
        </a>

        <div class="nav-label">Quality</div>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span>Reviews & Ratings</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Support Tickets</span>
        </a>
        <a href="#" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            <span>Settings</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="admin-profile">
            <img src="https://randomuser.me/api/portraits/men/10.jpg" class="admin-avatar" alt="Admin">
            <div class="admin-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:10px;">
            @csrf
            <button type="submit" style="width:100%;display:flex;align-items:center;gap:8px;background:rgba(232,130,60,0.12);color:#E8823C;border:none;padding:8px 12px;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<div class="main" id="main">
    <div class="topbar">
        <div class="topbar-left">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <div class="topbar-right">
            <div class="admin-topbar">
                <img src="https://randomuser.me/api/portraits/men/10.jpg" alt="Admin">
                <div>
                    <div class="tname">{{ Auth::user()->name }}</div>
                    <div class="trole">Super Admin</div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="page-title">Website Content</div>
        <div class="page-sub">Manage the content displayed on your public homepage. Changes reflect immediately after saving.</div>

        @if(session('success'))
            <div class="flash-message flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-message flash-error">{{ session('error') }}</div>
        @endif

        @php
            $iconLibrary = [
                'shield' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                'lightning' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                'briefcase' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>',
                'star' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
                'users' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                'clock' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
                'check' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'thumbsup' => '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>',
            ];
        @endphp

        {{-- 1. HERO SECTION --}}
        @php $hero = $sections->get('hero'); @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>1. Hero Section</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($hero)
                        <span class="last-updated">Last updated {{ $hero->updated_at->diffForHumans() }} by {{ $hero->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-hero">
                <form method="POST" action="{{ route('admin.cms.update', 'hero') }}">
                    @csrf
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Heading Prefix (before highlight)</label>
                            <input type="text" name="heading_prefix" class="form-control" value="{{ old('heading_prefix', $hero?->content['heading_prefix'] ?? 'Get Your Home<br>Jobs Done&nbsp;') }}">
                        </div>
                        <div class="form-group">
                            <label>Highlight Word (orange)</label>
                            <input type="text" name="highlight_word" class="form-control" value="{{ old('highlight_word', $hero?->content['highlight_word'] ?? "Fast &amp;<br>Reliably") }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subheading</label>
                        <textarea name="subheading" class="form-control" rows="3">{{ old('subheading', $hero?->content['subheading'] ?? 'Connect with vetted local professionals for plumbing,<br>electrical, carpentry, and more. Book in minutes,<br>get the job done right.') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hero Image</label>
                        <div class="image-upload-wrapper">
                            <img src="{{ asset(old('hero_image', $hero?->content['hero_image'] ?? 'images/ChatGPT Image Jul 5, 2026, 05_16_55 PM.png')) }}" class="image-preview" id="hero-preview">
                            <input type="hidden" name="hero_image" value="{{ old('hero_image', $hero?->content['hero_image'] ?? 'images/ChatGPT Image Jul 5, 2026, 05_16_55 PM.png') }}" id="hero_image_input">
                            <div class="image-upload-btn">
                                <button type="button" class="btn btn-secondary btn-sm">Upload New</button>
                                <input type="file" accept="image/*" onchange="uploadImage(this, 'hero_image_input', 'hero-preview')">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search Placeholder Text</label>
                        <input type="text" name="search_placeholder" class="form-control" value="{{ old('search_placeholder', $hero?->content['search_placeholder'] ?? 'Enter your city or zip code') }}">
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'hero') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 2. STATS BAR --}}
        @php $stats = $sections->get('stats_bar'); $statsContent = $stats?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>2. Stats Bar</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($stats)
                        <span class="last-updated">Last updated {{ $stats->updated_at->diffForHumans() }} by {{ $stats->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-stats">
                <form method="POST" action="{{ route('admin.cms.update', 'stats_bar') }}">
                    @csrf
                    <div class="form-group">
                        <div class="inline-flex items-center gap-3" style="display:flex;align-items:center;gap:12px;">
                            <label style="margin:0;">Data Mode</label>
                            <label class="toggle-switch">
                                <input type="checkbox" name="auto_calculate" value="1" {{ (old('auto_calculate', $statsContent['auto_calculate'] ?? true) ? 'checked' : '') }} onchange="toggleStatsMode(this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <span style="font-size:0.82rem;color:#6b7280;" id="stats-mode-label">{{ ($statsContent['auto_calculate'] ?? true) ? 'Auto-calculate from real data' : 'Manual override' }}</span>
                        </div>
                    </div>
                    <div id="stats-manual-fields">
                        <div class="grid-4">
                            @foreach (old('stats', $statsContent['stats'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['stats_bar']['stats']) as $i => $stat)
                            <div class="stat-card-edit">
                                <div style="font-weight:600;font-size:0.8rem;color:#6b7280;margin-bottom:10px;">Stat {{ $i + 1 }}</div>
                                <div class="form-group">
                                    <label>Icon</label>
                                    <div class="icon-select">
                                        @foreach(['shield','lightning','briefcase','star','users','clock','check','thumbsup'] as $ic)
                                        <label>
                                            <input type="radio" name="stats[{{ $i }}][icon]" value="{{ $ic }}" {{ ($stat['icon'] ?? '') === $ic ? 'checked' : '' }}>
                                            <label for="stats_{{ $i }}_icon_{{ $ic }}" style="border-color:{{ ($stat['icon'] ?? '') === $ic ? '#E8823C' : '#e2e8f0' }};background:{{ ($stat['icon'] ?? '') === $ic ? 'rgba(232,130,60,0.1)' : 'transparent' }};">
                                                {!! $iconLibrary[$ic] !!}
                                            </label>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Number</label>
                                    <input type="text" name="stats[{{ $i }}][number]" class="form-control" value="{{ $stat['number'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Label</label>
                                    <input type="text" name="stats[{{ $i }}][label]" class="form-control" value="{{ $stat['label'] ?? '' }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'stats_bar') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 3. BROWSE BY TRADE --}}
        @php $trades = $sections->get('browse_trades'); $tradesContent = $trades?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>3. Browse by Trade</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($trades)
                        <span class="last-updated">Last updated {{ $trades->updated_at->diffForHumans() }} by {{ $trades->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-trades">
                <form method="POST" action="{{ route('admin.cms.update', 'browse_trades') }}" id="trades-form">
                    @csrf
                    <div id="trades-container">
                        @foreach (old('trades', $tradesContent['trades'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['browse_trades']['trades']) as $i => $trade)
                        <div class="trade-card-edit mb-2" data-index="{{ $i }}">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <div class="inline-flex items-center gap-2">
                                    <span style="font-weight:600;font-size:0.8rem;color:#6b7280;">Trade #{{ $i + 1 }}</span>
                                    <label class="toggle-switch" style="transform:scale(0.8);">
                                        <input type="checkbox" name="trades[{{ $i }}][active]" value="1" {{ ($trade['active'] ?? true) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <span style="font-size:0.75rem;color:#9ca3af;">{{ ($trade['active'] ?? true) ? 'Visible' : 'Hidden' }}</span>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.trade-card-edit').remove()">Remove</button>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label>Trade Name</label>
                                    <input type="text" name="trades[{{ $i }}][name]" class="form-control" value="{{ $trade['name'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="trades[{{ $i }}][description]" class="form-control" value="{{ $trade['description'] ?? '' }}">
                                </div>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label>Icon</label>
                                    <div class="icon-select">
                                        @foreach(['plumbing','electrical','carpentry','painting','ac','cleaning','appliance','handyman'] as $ic)
                                        <label>
                                            <input type="radio" name="trades[{{ $i }}][icon]" value="{{ $ic }}" {{ ($trade['icon'] ?? '') === $ic ? 'checked' : '' }}>
                                            <label for="trades_{{ $i }}_icon_{{ $ic }}" style="border-color:{{ ($trade['icon'] ?? '') === $ic ? '#E8823C' : '#e2e8f0' }};background:{{ ($trade['icon'] ?? '') === $ic ? 'rgba(232,130,60,0.1)' : 'transparent' }};">
                                                <span style="font-size:0.7rem;">{{ ucfirst($ic) }}</span>
                                            </label>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Card Background Color</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" name="trades[{{ $i }}][bg]" value="{{ $trade['bg'] ?? '#faf9f6' }}">
                                        <input type="text" name="trades[{{ $i }}][color]" class="form-control" value="{{ $trade['color'] ?? '#111827' }}" placeholder="Text color hex">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addTrade()">+ Add Trade</button>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'browse_trades') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 4. HOW IT WORKS --}}
        @php $hiw = $sections->get('how_it_works'); $hiwContent = $hiw?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>4. How It Works</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($hiw)
                        <span class="last-updated">Last updated {{ $hiw->updated_at->diffForHumans() }} by {{ $hiw->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-hiw">
                <form method="POST" action="{{ route('admin.cms.update', 'how_it_works') }}" id="hiw-form">
                    @csrf
                    <div id="steps-container">
                        @foreach (old('steps', $hiwContent['steps'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['how_it_works']['steps']) as $i => $step)
                        <div class="step-card-edit mb-2" data-index="{{ $i }}">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <span style="font-weight:600;font-size:0.8rem;color:#6b7280;">Step #{{ $i + 1 }}</span>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.step-card-edit').remove()">Remove</button>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="steps[{{ $i }}][title]" class="form-control" value="{{ $step['title'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>Icon</label>
                                    <select name="steps[{{ $i }}][icon]" class="form-control">
                                        <option value="post" {{ ($step['icon'] ?? '') === 'post' ? 'selected' : '' }}>Clipboard (Post)</option>
                                        <option value="match" {{ ($step['icon'] ?? '') === 'match' ? 'selected' : '' }}>Users (Match)</option>
                                        <option value="book" {{ ($step['icon'] ?? '') === 'book' ? 'selected' : '' }}>Calendar (Book)</option>
                                        <option value="star" {{ ($step['icon'] ?? '') === 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="shield" {{ ($step['icon'] ?? '') === 'shield' ? 'selected' : '' }}>Shield</option>
                                        <option value="lightning" {{ ($step['icon'] ?? '') === 'lightning' ? 'selected' : '' }}>Lightning</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="steps[{{ $i }}][description]" class="form-control" rows="2">{{ $step['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addStep()">+ Add Step</button>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'how_it_works') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 5. FEATURED PROFESSIONALS --}}
        @php $fpros = $sections->get('featured_pros'); $fprosContent = $fpros?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>5. Featured Professionals</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($fpros)
                        <span class="last-updated">Last updated {{ $fpros->updated_at->diffForHumans() }} by {{ $fpros->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-pros">
                <form method="POST" action="{{ route('admin.cms.update', 'featured_pros') }}">
                    @csrf
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $fprosContent['title'] ?? 'Featured Professionals') }}">
                    </div>
                    <div class="form-group">
                        <label>Selection Mode</label>
                        <div style="display:flex;gap:20px;margin-top:6px;">
                            <label class="inline-flex items-center gap-2" style="display:inline-flex;align-items:center;gap:8px;">
                                <input type="radio" name="mode" value="auto" {{ (old('mode', $fprosContent['mode'] ?? 'auto') === 'auto') ? 'checked' : '' }} onchange="toggleProMode()">
                                <span style="font-size:0.85rem;">Auto-select top-rated pros</span>
                            </label>
                            <label class="inline-flex items-center gap-2" style="display:inline-flex;align-items:center;gap:8px;">
                                <input type="radio" name="mode" value="manual" {{ (old('mode', $fprosContent['mode'] ?? '') === 'manual') ? 'checked' : '' }} onchange="toggleProMode()">
                                <span style="font-size:0.85rem;">Manually pin specific professionals</span>
                            </label>
                        </div>
                    </div>
                    <div id="manual-pros-field" style="display:none;">
                        <div class="form-group">
                            <label>Featured Professional IDs (comma-separated user IDs)</label>
                            <input type="text" name="featured_ids" class="form-control" value="{{ old('featured_ids', isset($fprosContent['featured_ids']) ? implode(',', $fprosContent['featured_ids']) : '') }}" placeholder="e.g. 3, 5, 7">
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'featured_pros') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 6. TESTIMONIALS --}}
        @php $test = $sections->get('testimonials'); $testContent = $test?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>6. Testimonials</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($test)
                        <span class="last-updated">Last updated {{ $test->updated_at->diffForHumans() }} by {{ $test->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-testimonials">
                <form method="POST" action="{{ route('admin.cms.update', 'testimonials') }}">
                    @csrf
                    <div class="form-group">
                        <label>Section Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $testContent['title'] ?? "What Our Customers Say") }}">
                    </div>
                    <div class="form-group">
                        <label>Selection Mode</label>
                        <div style="display:flex;gap:20px;margin-top:6px;">
                            <label class="inline-flex items-center gap-2" style="display:inline-flex;align-items:center;gap:8px;">
                                <input type="radio" name="mode" value="auto" {{ (old('mode', $testContent['mode'] ?? 'auto') === 'auto') ? 'checked' : '' }}>
                                <span style="font-size:0.85rem;">Auto-show top reviews</span>
                            </label>
                            <label class="inline-flex items-center gap-2" style="display:inline-flex;align-items:center;gap:8px;">
                                <input type="radio" name="mode" value="manual" {{ (old('mode', $testContent['mode'] ?? '') === 'manual') ? 'checked' : '' }}>
                                <span style="font-size:0.85rem;">Manually curate</span>
                            </label>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'testimonials') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 7. CTA BANNER --}}
        @php $cta = $sections->get('cta_banner'); $ctaContent = $cta?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>7. "Join as a Professional" Banner</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($cta)
                        <span class="last-updated">Last updated {{ $cta->updated_at->diffForHumans() }} by {{ $cta->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-cta">
                <form method="POST" action="{{ route('admin.cms.update', 'cta_banner') }}">
                    @csrf
                    <div class="form-group">
                        <label>Heading</label>
                        <input type="text" name="heading" class="form-control" value="{{ old('heading', $ctaContent['heading'] ?? 'Are You a Home Service Professional?') }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $ctaContent['description'] ?? 'Join FixIt and get access to hundreds of local job leads every month.') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $ctaContent['button_text'] ?? 'Join as a professional') }}">
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'cta_banner') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 8. FOOTER --}}
        @php $footer = $sections->get('footer'); $footerContent = $footer?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>8. Footer</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($footer)
                        <span class="last-updated">Last updated {{ $footer->updated_at->diffForHumans() }} by {{ $footer->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-footer">
                <form method="POST" action="{{ route('admin.cms.update', 'footer') }}">
                    @csrf
                    <div class="form-group">
                        <label>Company Description</label>
                        <textarea name="company_description" class="form-control" rows="3">{{ old('company_description', $footerContent['company_description'] ?? 'Connecting homeowners with reliable local professionals for all their home service needs.') }}</textarea>
                    </div>
                    <div style="font-weight:600;font-size:0.82rem;color:#374151;margin-bottom:12px;">Social Media Links</div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Facebook URL</label>
                            <input type="url" name="social[facebook]" class="form-control" value="{{ old('social.facebook', $footerContent['social']['facebook'] ?? '#') }}">
                        </div>
                        <div class="form-group">
                            <label>Instagram URL</label>
                            <input type="url" name="social[instagram]" class="form-control" value="{{ old('social.instagram', $footerContent['social']['instagram'] ?? '#') }}">
                        </div>
                        <div class="form-group">
                            <label>Twitter URL</label>
                            <input type="url" name="social[twitter]" class="form-control" value="{{ old('social.twitter', $footerContent['social']['twitter'] ?? '#') }}">
                        </div>
                        <div class="form-group">
                            <label>YouTube URL</label>
                            <input type="url" name="social[youtube]" class="form-control" value="{{ old('social.youtube', $footerContent['social']['youtube'] ?? '#') }}">
                        </div>
                    </div>
                    <div style="font-weight:600;font-size:0.82rem;color:#374151;margin-bottom:12px;">Footer Link Groups</div>
                    <div id="link-groups-container">
                        @foreach (old('link_groups', $footerContent['link_groups'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['footer']['link_groups']) as $gi => $group)
                        <div class="link-group-card" data-index="{{ $gi }}">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <span style="font-weight:600;font-size:0.8rem;">{{ $group['title'] ?? 'Group' }}</span>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.link-group-card').remove()">Remove Group</button>
                            </div>
                            <input type="hidden" name="link_groups[{{ $gi }}][title]" value="{{ $group['title'] ?? '' }}">
                            <div class="form-group">
                                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                                    <label style="font-size:0.75rem;color:#6b7280;">Links</label>
                                    <button type="button" class="btn btn-secondary btn-sm" style="padding:2px 10px;font-size:0.7rem;" onclick="addLinkToGroup(this)">+ Add Link</button>
                                </div>
                                @foreach ($group['links'] ?? [] as $li => $link)
                                <div class="link-row">
                                    <input type="text" name="link_groups[{{ $gi }}][links][{{ $li }}][label]" class="form-control" value="{{ $link['label'] ?? '' }}" placeholder="Label">
                                    <input type="text" name="link_groups[{{ $gi }}][links][{{ $li }}][url]" class="form-control" value="{{ $link['url'] ?? '' }}" placeholder="URL">
                                    <button type="button" class="btn btn-danger btn-sm" style="padding:2px 8px;font-size:0.7rem;" onclick="this.parentElement.remove()">X</button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>Copyright Text (year stays auto-dynamic)</label>
                        <input type="text" name="copyright" class="form-control" value="{{ old('copyright', $footerContent['copyright'] ?? 'FixIt. All rights reserved.') }}">
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'footer') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 9. NAVIGATION --}}
        @php $nav = $sections->get('navigation'); $navContent = $nav?->content ?? []; @endphp
        <div class="section-card">
            <div class="section-header" onclick="toggleSection(this)">
                <h3>9. Navigation Menu</h3>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($nav)
                        <span class="last-updated">Last updated {{ $nav->updated_at->diffForHumans() }} by {{ $nav->updater?->name ?? 'Unknown' }}</span>
                    @endif
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div class="section-body" id="section-nav">
                <form method="POST" action="{{ route('admin.cms.update', 'navigation') }}">
                    @csrf
                    <div id="nav-links-container">
                        @foreach (old('links', $navContent['links'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['navigation']['links']) as $i => $link)
                        <div class="link-row mb-2">
                            <input type="text" name="links[{{ $i }}][label]" class="form-control" value="{{ $link['label'] ?? '' }}" placeholder="Label">
                            <input type="text" name="links[{{ $i }}][url]" class="form-control" value="{{ $link['url'] ?? '' }}" placeholder="URL (e.g. #how-it-works)">
                            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remove</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addNavLink()">+ Add Link</button>
                    <div style="display:flex;gap:8px;justify-content:flex-end;padding-top:12px;border-top:1px solid #ece8df;">
                        <a href="{{ route('admin.cms.reset', 'navigation') }}" class="btn btn-danger btn-sm" onclick="return confirm('Reset this section to defaults?')">Reset to Default</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('main').classList.toggle('expanded');
}

function toggleSection(header) {
    const body = header.nextElementSibling;
    body.classList.toggle('open');
    const arrow = header.querySelector('svg:last-child');
    if (arrow) {
        arrow.style.transform = body.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
}

function uploadImage(input, hiddenId, previewId) {
    const file = input.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');
    fetch('{{ route('admin.cms.upload') }}', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.url) {
            document.getElementById(hiddenId).value = 'storage/' + data.path;
            document.getElementById(previewId).src = '/storage/' + data.path;
        }
    })
    .catch(e => alert('Upload failed'));
}

function toggleStatsMode(cb) {
    const label = document.getElementById('stats-mode-label');
    const fields = document.getElementById('stats-manual-fields');
    label.textContent = cb.checked ? 'Auto-calculate from real data' : 'Manual override';
    fields.style.display = cb.checked ? 'none' : 'block';
}
(function() {
    const cb = document.querySelector('input[name="auto_calculate"]');
    if (cb) toggleStatsMode(cb);
})();

function toggleProMode() {
    const manual = document.getElementById('manual-pros-field');
    manual.style.display = document.querySelector('input[name="mode"]:checked')?.value === 'manual' ? 'block' : 'none';
}
toggleProMode();

let tradeIndex = {{ count(old('trades', $tradesContent['trades'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['browse_trades']['trades'])) }};
function addTrade() {
    const i = tradeIndex++;
    const html = `<div class="trade-card-edit mb-2" data-index="${i}">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <div class="inline-flex items-center gap-2">
                <span style="font-weight:600;font-size:0.8rem;color:#6b7280;">Trade #${i + 1}</span>
                <label class="toggle-switch" style="transform:scale(0.8);">
                    <input type="checkbox" name="trades[${i}][active]" value="1" checked>
                    <span class="toggle-slider"></span>
                </label>
                <span style="font-size:0.75rem;color:#9ca3af;">Visible</span>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.trade-card-edit').remove()">Remove</button>
        </div>
        <div class="grid-2">
            <div class="form-group"><label>Trade Name</label><input type="text" name="trades[${i}][name]" class="form-control"></div>
            <div class="form-group"><label>Description</label><input type="text" name="trades[${i}][description]" class="form-control"></div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label>Icon</label>
                <select name="trades[${i}][icon]" class="form-control">
                    <option value="plumbing">Plumbing</option>
                    <option value="electrical">Electrical</option>
                    <option value="carpentry">Carpentry</option>
                    <option value="painting">Painting</option>
                    <option value="ac">AC Repair</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="appliance">Appliance Repair</option>
                    <option value="handyman">Handyman</option>
                </select>
            </div>
            <div class="form-group">
                <label>Card Background Color</label>
                <div class="color-picker-wrapper">
                    <input type="color" name="trades[${i}][bg]" value="#faf9f6">
                    <input type="text" name="trades[${i}][color]" class="form-control" value="#111827" placeholder="Text color hex">
                </div>
            </div>
        </div>
    </div>`;
    document.getElementById('trades-container').insertAdjacentHTML('beforeend', html);
}

let stepIndex = {{ count(old('steps', $hiwContent['steps'] ?? \App\Http\Controllers\Admin\SiteContentController::DEFAULTS['how_it_works']['steps'])) }};
function addStep() {
    const i = stepIndex++;
    const html = `<div class="step-card-edit mb-2">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-weight:600;font-size:0.8rem;color:#6b7280;">Step #${i + 1}</span>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.step-card-edit').remove()">Remove</button>
        </div>
        <div class="grid-2">
            <div class="form-group"><label>Title</label><input type="text" name="steps[${i}][title]" class="form-control"></div>
            <div class="form-group"><label>Icon</label>
                <select name="steps[${i}][icon]" class="form-control">
                    <option value="post">Clipboard (Post)</option>
                    <option value="match">Users (Match)</option>
                    <option value="book">Calendar (Book)</option>
                    <option value="star">Star</option>
                    <option value="shield">Shield</option>
                    <option value="lightning">Lightning</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label>Description</label><textarea name="steps[${i}][description]" class="form-control" rows="2"></textarea></div>
    </div>`;
    document.getElementById('steps-container').insertAdjacentHTML('beforeend', html);
}

function addLinkToGroup(btn) {
    const group = btn.closest('.link-group-card');
    const gi = group.dataset.index;
    const linkRows = group.querySelectorAll('.link-row').length;
    const html = `<div class="link-row">
        <input type="text" name="link_groups[${gi}][links][${linkRows}][label]" class="form-control" placeholder="Label">
        <input type="text" name="link_groups[${gi}][links][${linkRows}][url]" class="form-control" placeholder="URL">
        <button type="button" class="btn btn-danger btn-sm" style="padding:2px 8px;font-size:0.7rem;" onclick="this.parentElement.remove()">X</button>
    </div>`;
    group.querySelector('.form-group').insertAdjacentHTML('beforeend', html);
}

function addNavLink() {
    const container = document.getElementById('nav-links-container');
    const i = container.children.length;
    const html = `<div class="link-row mb-2">
        <input type="text" name="links[${i}][label]" class="form-control" placeholder="Label">
        <input type="text" name="links[${i}][url]" class="form-control" placeholder="URL (e.g. #how-it-works)">
        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remove</button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

document.querySelectorAll('.section-body:first-child').forEach(el => el.classList.add('open'));
</script>

</body>
</html>
