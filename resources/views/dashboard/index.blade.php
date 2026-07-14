<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixly – Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #F5F1EA; color: #1f2937; display: flex; min-height: 100vh; }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 90; }
        .sidebar-overlay.active { display: block; }

        /* ── Sidebar ── */
        .sidebar { width: 240px; height: 100vh; background: #16302A; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; transition: transform 0.2s ease; overflow: hidden; }
        .sidebar.collapsed { transform: translateX(-176px); } /* Show only 64px of sidebar */
        .sidebar.collapsed-mobile { transform: translateX(-100%); }
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
        .logout-btn { display: flex; align-items: center; gap: 8px; margin-top: 10px; padding: 8px 12px; border-radius: 8px; background: rgba(232,130,60,0.12); color: #E8823C; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: none; width: 100%; }
        .sidebar.collapsed .logout-btn span { display: none; }

        /* ── Main ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; transition: margin-left 0.2s ease; }
        .main.expanded { margin-left: 64px; }

        /* ── Topbar ── */
        .topbar { background: #fff; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ece8df; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .toggle-btn { background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .hamburger-btn { display: none; background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .search-box { display: flex; align-items: center; gap: 8px; background: #f5f1ea; border-radius: 10px; padding: 8px 14px; width: 260px; }
        .search-box input { background: none; border: none; outline: none; font-size: 0.85rem; color: #374151; width: 100%; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .notif-btn { position: relative; background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .notif-dot { position: absolute; top: 2px; right: 2px; width: 8px; height: 8px; border-radius: 50%; background: #E8823C; border: 2px solid #fff; }
        .admin-topbar { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .admin-topbar img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        .admin-topbar .tname { font-size: 0.85rem; font-weight: 600; color: #111827; }
        .admin-topbar .trole { font-size: 0.72rem; color: #9ca3af; }

        /* ── Content ── */
        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 1.4rem; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .page-sub { font-size: 0.82rem; color: #9ca3af; margin-bottom: 24px; }

        /* ── KPI Cards ── */
        .kpi-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 28px; }
        .kpi-card { background: #fff; border-radius: 14px; padding: 20px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
        .kpi-icon { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .kpi-badge { font-size: 0.7rem; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
        .badge-up { background: #dcfce7; color: #16a34a; }
        .badge-down { background: #fee2e2; color: #dc2626; }
        .kpi-value { font-size: 1.6rem; font-weight: 800; color: #111827; line-height: 1; margin-bottom: 4px; }
        .kpi-label { font-size: 0.75rem; color: #9ca3af; }

        /* ── Charts ── */
        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
        .chart-card { background: #fff; border-radius: 14px; padding: 24px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .card-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
        .card-sub { font-size: 0.75rem; color: #9ca3af; margin-bottom: 18px; }

        /* ── Tables ── */
        .table-card { background: #fff; border-radius: 14px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 28px; overflow-x: auto; }
        .table-header { padding: 20px 24px 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .view-all { font-size: 0.8rem; font-weight: 600; color: #E8823C; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        th { padding: 10px 16px; text-align: left; font-size: 0.72rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; background: #faf9f6; border-bottom: 1px solid #ece8df; }
        td { padding: 12px 16px; font-size: 0.82rem; color: #374151; border-bottom: 1px solid #f5f1ea; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf9f6; }

        /* ── Badges ── */
        .status-badge { padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
        .s-completed { background: #dcfce7; color: #15803d; }
        .s-progress  { background: #fff7ed; color: #c2410c; }
        .s-pending   { background: #f3f4f6; color: #6b7280; }
        .s-cancelled { background: #fee2e2; color: #b91c1c; }
        .trade-tag { padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }

        /* ── Bottom grid ── */
        .bottom-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 28px; }

        /* ── Reviews ── */
        .review-card { background: #faf9f6; border-radius: 12px; padding: 16px; margin-bottom: 12px; border: 1px solid #ece8df; }
        .review-stars { display: flex; gap: 2px; margin-bottom: 8px; }
        .review-text { font-size: 0.8rem; color: #374151; line-height: 1.6; margin-bottom: 10px; }
        .review-author { display: flex; align-items: center; gap: 8px; }
        .review-author img { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; }
        .review-author .rname { font-size: 0.78rem; font-weight: 600; color: #111827; }
        .review-author .rservice { font-size: 0.7rem; color: #9ca3af; }

        /* ── Top Professionals ── */
        .pro-mini { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0ede6; }
        .pro-mini:last-child { border-bottom: none; }
        .pro-mini img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .pro-mini .pname { font-size: 0.85rem; font-weight: 600; color: #111827; }
        .pro-mini .ptrade { font-size: 0.72rem; color: #9ca3af; }
        .pro-mini-right { margin-left: auto; text-align: right; }
        .pro-mini-right .prating { font-size: 0.78rem; font-weight: 700; color: #D9A441; }
        .pro-mini-right .pjobs { font-size: 0.7rem; color: #9ca3af; }

        /* ── Tickets ── */
        .ticket-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0ede6; }
        .ticket-item:last-child { border-bottom: none; }
        .priority-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
        .p-high { background: #ef4444; }
        .p-med  { background: #f59e0b; }
        .p-low  { background: #10b981; }
        .ticket-title { font-size: 0.82rem; font-weight: 600; color: #111827; margin-bottom: 2px; }
        .ticket-meta { font-size: 0.72rem; color: #9ca3af; }
        .priority-tag { font-size: 0.65rem; font-weight: 700; padding: 2px 7px; border-radius: 10px; margin-left: auto; flex-shrink: 0; }
        .pt-high { background: #fee2e2; color: #b91c1c; }
        .pt-med  { background: #fef9c3; color: #a16207; }
        .pt-low  { background: #dcfce7; color: #15803d; }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 1024px) {
            .bottom-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-176px); }
            .sidebar.collapsed { transform: translateX(0); }
            .sidebar .nav-item span, .sidebar .nav-label, .sidebar .sidebar-logo span,
            .sidebar .admin-info, .sidebar .logout-btn span { display: none; }
            .main { margin-left: 64px; }
            .charts-grid { grid-template-columns: 1fr; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
            .hamburger-btn { display: none; }
            .toggle-btn { display: block; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.collapsed-mobile { transform: translateX(-100%); }
            .sidebar.collapsed { transform: translateX(0); }
            .sidebar .nav-item span, .sidebar .nav-label, .sidebar .sidebar-logo span,
            .sidebar .admin-info, .sidebar .logout-btn span { display: flex; }
            .main { margin-left: 0; }
            .hamburger-btn { display: block; }
            .toggle-btn { display: none; }
        }
        @media (max-width: 600px) {
            .kpi-grid { grid-template-columns: 1fr 1fr; }
            .search-box { width: 100%; margin-top: 12px; }
            .topbar { flex-wrap: wrap; }
            .topbar-left { width: 100%; justify-content: space-between; }
            .content { padding: 16px; }
        }
        @media (max-width: 480px) {
            .kpi-grid { grid-template-columns: 1fr; }
            .kpi-value { font-size: 1.25rem !important; }
            .page-title { font-size: 1.1rem; }
            .table-card { overflow-x: auto; }
            table { min-width: 500px; }
            .chart-card canvas { max-width: 100%; height: auto !important; }
        }
    </style>
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
        </svg>
        <span>Fix<em>ly</em> <span style="font-size:0.65rem;color:#4a7a6a;font-weight:500;">Admin</span></span>
    </div>

    <nav class="nav-section">
        <div class="nav-label">Main</div>
        <a href="#" class="nav-item active">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <span>Dashboard Overview</span>
        </a>
        <a href="{{ route('admin.professionals') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Professionals</span>
        </a>
        <a href="{{ route('admin.customers') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Customers</span>
        </a>
        <a href="{{ route('admin.jobs') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>Jobs / Bookings</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>Categories / Trades</span>
        </a>

        <div class="nav-label">Finance</div>
        <a href="{{ route('admin.payments') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Payments & Payouts</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v10m-6 0a2 2 0 002 2h2a2 2 0 012-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h2a2 2 0 01-2-2z"/></svg>
            <span>Reports / Analytics</span>
        </a>

        <div class="nav-label">Content</div>
        <a href="{{ route('admin.cms') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><circle cx="4" cy="4" r="1.5" fill="currentColor" stroke="none"/></svg>
            <span>Website Content</span>
        </a>

        <div class="nav-label">Quality</div>
        <a href="{{ route('admin.reviews') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span>Reviews & Ratings</span>
        </a>
        <a href="{{ route('admin.tickets') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Support Tickets</span>
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.065 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
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
            <button type="submit" class="logout-btn" style="width:100%;display:flex;align-items:center;gap:8px;background:rgba(232,130,60,0.12);color:#E8823C;border:none;padding:8px 12px;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<div class="main" id="main">
    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="hamburger-btn" onclick="toggleMobileSidebar()">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <form method="GET" action="{{ route('admin.dashboard') }}" class="search-box" style="display:flex;align-items:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search jobs, users, professionals..." style="background:transparent;border:none;outline:none;width:100%;">
            </form>
        </div>
        <div class="topbar-right">
            <div class="flex items-center gap-2">
                @include('partials.notification-bell')
            </div>
            <div class="admin-topbar">
                <img src="https://randomuser.me/api/portraits/men/10.jpg" alt="Admin">
                <div>
                    <div class="tname">{{ Auth::user()->name }}</div>
                    <div class="trole">Super Admin</div>
                </div>
                <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" style="margin-left:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-title">Dashboard Overview</div>
        <div class="page-sub">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}. Here's what's happening today – {{ now()->format('M d, Y') }}.</div>

        @if($searchResults)
            <div class="table-card" style="margin-top:20px;">
                <div class="table-header">
                    <div>
                        <div class="card-title">Search Results for "{{ request('q') }}"</div>
                    </div>
                </div>
                @if($searchResults['users']->count() > 0)
                    <h4 style="padding:10px 20px;margin:0;background:#faf9f6;color:#111827;">Users</h4>
                    <table>
                        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($searchResults['users'] as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ ucfirst($user->verification_status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if($searchResults['jobs']->count() > 0)
                    <h4 style="padding:10px 20px;margin:0;background:#faf9f6;color:#111827;">Jobs</h4>
                    <table>
                        <thead><tr><th>Job ID</th><th>Customer</th><th>Professional</th><th>Trade</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($searchResults['jobs'] as $job)
                                <tr>
                                    <td>#JB-{{ $job->id }}</td>
                                    <td>{{ $job->customer ? $job->customer->name : 'N/A' }}</td>
                                    <td>{{ $job->assignedPro ? $job->assignedPro->name : 'N/A' }}</td>
                                    <td>{{ $job->trade_category ?: 'N/A' }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $job->status)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if($searchResults['users']->count() == 0 && $searchResults['jobs']->count() == 0)
                    <div style="padding:20px;text-align:center;color:#9ca3af;">No results found</div>
                @endif
            </div>
        @endif

        <!-- KPI Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon" style="background:#e8f4f1;"><svg width="22" height="22" fill="none" stroke="#16302A" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                </div>
                <div class="kpi-value">{{ number_format($verifiedPros) }}</div>
                <div class="kpi-label">Verified Professionals</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon" style="background:#fff8e6;"><svg width="22" height="22" fill="none" stroke="#D9A441" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                </div>
                <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
                <div class="kpi-label">Total Customers</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon" style="background:#fff0e8;"><svg width="22" height="22" fill="none" stroke="#E8823C" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                </div>
                <div class="kpi-value">{{ number_format($jobsThisMonth) }}</div>
                <div class="kpi-label">Jobs This Month</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon" style="background:#eef6fb;"><svg width="22" height="22" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                </div>
                <div class="kpi-value">Rs. {{ number_format($platformRevenue, 2) }}</div>
                <div class="kpi-label">Platform Revenue</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon" style="background:#fef3ee;"><svg width="22" height="22" fill="#D9A441" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
                    @if($pendingProsCount > 0)
                        <span class="kpi-badge badge-up">{{ $pendingProsCount }}</span>
                    @endif
                </div>
                <div class="kpi-value">{{ round($avgRating ?: 0, 1) }}</div>
                <div class="kpi-label">Avg Rating / Pending: {{ $pendingProsCount }}</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-card">
                <div class="card-title">Jobs & Revenue Trend</div>
                <div class="card-sub">Last 12 months – jobs completed vs platform earnings</div>
                <canvas id="lineChart" height="200"></canvas>
            </div>
            <div class="chart-card">
                <div class="card-title">Bookings by Trade</div>
                <div class="card-sub">Distribution across service categories this month</div>
                <canvas id="barChart" height="200"></canvas>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="table-card">
            <div class="table-header">
                <div>
                    <div class="card-title">Pending Approvals</div>
                    <div class="card-sub" style="margin-bottom:0;">New professionals awaiting verification</div>
                </div>
                <a href="#" class="view-all">View all →</a>
            </div>
            <table>
                <thead><tr>
                    <th>Professional</th><th>Trade</th><th>Submitted</th><th>Actions</th>
                </tr></thead>
                <tbody>
                    @if($pendingPros->count() > 0)
                        @foreach($pendingPros as $pro)
                            <tr>
                                <td><div style="display:flex;align-items:center;gap:10px;"><div style="width:34px;height:34px;border-radius:50%;background:#E8823C;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;">{{ substr($pro->name, 0, 1) }}</div><div><div style="font-weight:600;color:#111827;">{{ $pro->name }}</div><div style="font-size:0.72rem;color:#9ca3af;">{{ $pro->email }}</div></div></div></td>
                                <td><span class="trade-tag" style="background:#fff8e6;color:#a16207;">{{ $pro->trade }}</span></td>
                                <td>{{ $pro->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.pro.approve', $pro->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:#E8823C;color:#fff;border:none;padding:6px 14px;border-radius:7px;font-size:0.78rem;font-weight:600;cursor:pointer;margin-right:6px;">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pro.reject', $pro->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:#fff;color:#6b7280;border:1.5px solid #e5e7eb;padding:6px 14px;border-radius:7px;font-weight:600;cursor:pointer;">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" style="text-align:center;padding:30px;color:#9ca3af;">No pending approvals right now!</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Recent Jobs -->
        <div class="table-card">
            <div class="table-header">
                <div>
                    <div class="card-title">Recent Jobs / Bookings</div>
                    <div class="card-sub" style="margin-bottom:0;">Latest job activity across the platform</div>
                </div>
                <a href="#" class="view-all">View all →</a>
            </div>
            <table>
                <thead><tr>
                    <th>Job ID</th><th>Customer</th><th>Professional</th><th>Trade</th><th>Status</th><th>Amount</th><th>Date</th>
                </tr></thead>
                <tbody>
                    @if($recentJobs->count() > 0)
                        @foreach($recentJobs as $job)
                            @php
                                $statusBadgeClass = 's-pending';
                                switch($job->status) {
                                    case 'completed': $statusBadgeClass = 's-completed'; break;
                                    case 'in_progress': $statusBadgeClass = 's-progress'; break;
                                    case 'cancelled': $statusBadgeClass = 's-cancelled'; break;
                                    case 'scheduled': $statusBadgeClass = 's-progress'; break;
                                    case 'quotes_received': $statusBadgeClass = 's-pending'; break;
                                    case 'pending_match': $statusBadgeClass = 's-pending'; break;
                                }
                            @endphp
                            <tr>
                                <td style="font-weight:600;color:#E8823C;">#JB-{{ $job->id }}</td>
                                <td>{{ $job->customer ? $job->customer->name : 'N/A' }}</td>
                                <td>{{ $job->assignedPro ? $job->assignedPro->name : 'N/A' }}</td>
                                <td><span class="trade-tag" style="background:#e8f4f1;color:#16302A;">{{ $job->trade_category ?: 'N/A' }}</span></td>
                                <td><span class="status-badge {{ $statusBadgeClass }}">{{ ucwords(str_replace('_', ' ', $job->status)) }}</span></td>
                                <td style="font-weight:600;">Rs. {{ number_format($job->amount_paid ?: 0, 2) }}</td>
                                <td>{{ $job->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:20px;">No jobs yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Bottom 3-Column Grid -->
        <div class="bottom-grid">
            <!-- Recent Reviews -->
            <div class="chart-card" style="height:fit-content;">
                <div class="card-title">Recent Reviews</div>
                <div class="card-sub">Latest customer feedback</div>
                @if($recentReviews->count() > 0)
                    @foreach($recentReviews as $review)
                        <div class="review-card">
                            <div style="font-size:2rem;color:#D9A441;line-height:1;margin-bottom:4px;font-family:Georgia;">&ldquo;</div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#D9A441"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @else
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#D9A441" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <div class="review-text">{{ $review->comment }}</div>
                            <div class="review-author">
                                <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" alt="">
                                <div>
                                    <div class="rname">{{ $review->customer ? $review->customer->name : 'N/A' }}</div>
                                    <div class="rservice">→ {{ $review->pro ? $review->pro->name : 'N/A' }} · {{ $review->job ? $review->job->trade_category : 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="padding:20px;color:#9ca3af;text-align:center;">No reviews yet</div>
                @endif
            </div>

            <!-- Top Professionals -->
            <div class="chart-card" style="height:fit-content;">
                <div class="card-title">Top Professionals</div>
                <div class="card-sub">Leaderboard by jobs & rating</div>
                @if($topPros->count() > 0)
                    @foreach($topPros as $pro)
                        <div class="pro-mini">
                            <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" alt="">
                            <div>
                                <div class="pname">{{ $pro->name }}</div>
                                <div class="ptrade">{{ $pro->trade ?: 'N/A' }}</div>
                            </div>
                            <div class="pro-mini-right">
                                <div class="prating">★ {{ number_format($pro->avg_rating ?: 0, 1) }}</div>
                                <div class="pjobs">{{ $pro->jobs_completed ?: 0 }} jobs</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="padding:20px;color:#9ca3af;text-align:center;">No pros yet</div>
                @endif
            </div>

            <!-- Support Tickets -->
            <div class="chart-card" style="height:fit-content;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                    <div class="card-title">Support Tickets</div>
                    <span style="background:#fee2e2;color:#b91c1c;font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:20px;">5 Open</span>
                </div>
                <div class="card-sub">Latest unresolved tickets</div>
                <div class="ticket-item">
                    <div class="priority-dot p-high"></div>
                    <div><div class="ticket-title">Payment not received after job</div><div class="ticket-meta">Ali Hassan · #TK-201 · 2h ago</div></div>
                    <span class="priority-tag pt-high">High</span>
                </div>
                <div class="ticket-item">
                    <div class="priority-dot p-high"></div>
                    <div><div class="ticket-title">Professional no-show on booking</div><div class="ticket-meta">Sana Mirza · #TK-200 · 5h ago</div></div>
                    <span class="priority-tag pt-high">High</span>
                </div>
                <div class="ticket-item">
                    <div class="priority-dot p-med"></div>
                    <div><div class="ticket-title">Cannot upload verification docs</div><div class="ticket-meta">Kamran Malik · #TK-199 · 1d ago</div></div>
                    <span class="priority-tag pt-med">Medium</span>
                </div>
                <div class="ticket-item">
                    <div class="priority-dot p-low"></div>
                    <div><div class="ticket-title">Profile photo not updating</div><div class="ticket-meta">Omar Sheikh · #TK-198 · 2d ago</div></div>
                    <span class="priority-tag pt-low">Low</span>
                </div>
                <a href="#" style="display:block;text-align:center;margin-top:14px;font-size:0.8rem;font-weight:600;color:#E8823C;text-decoration:none;">View all tickets →</a>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<script>
// Sidebar toggle (desktop)
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    sb.classList.toggle('collapsed');
    main.classList.toggle('expanded');
}

// Sidebar toggle (mobile)
function toggleMobileSidebar() {
    const sb = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sb.classList.toggle('collapsed');
    overlay.classList.toggle('active');
}

// Line Chart – Jobs & Revenue
const lCtx = document.getElementById('lineChart').getContext('2d');
const last12Months = @json($last12Months);
new Chart(lCtx, {
    type: 'line',
    data: {
        labels: last12Months.map(m => m.month),
        datasets: [
            {
                label: 'Jobs Completed',
                data: last12Months.map(m => m.jobs),
                borderColor: '#16302A', backgroundColor: 'rgba(22,48,42,0.08)',
                borderWidth: 2.5, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: '#16302A'
            },
            {
                label: 'Revenue (Rs.)',
                data: last12Months.map(m => m.revenue),
                borderColor: '#E8823C', backgroundColor: 'rgba(232,130,60,0.08)',
                borderWidth: 2.5, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: '#E8823C'
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { position: 'top', labels: { font: { size: 11 }, boxWidth: 12 } } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: '#f0ede6' }, ticks: { font: { size: 11 } } }
        }
    }
});

// Bar Chart – Bookings by Trade
const bCtx = document.getElementById('barChart').getContext('2d');
const tradesBookings = @json($tradesBookings);
const tradeLabels = Object.keys(tradesBookings);
const tradeData = Object.values(tradesBookings);
const colors = [
    { bg: '#e8f4f1', border: '#16302A' },
    { bg: '#fff8e6', border: '#D9A441' },
    { bg: '#fff0e8', border: '#E8823C' },
    { bg: '#fef0f0', border: '#ef4444' },
    { bg: '#eef6fb', border: '#3b82f6' },
    { bg: '#e8f4f1', border: '#16302A' },
    { bg: '#f0eef8', border: '#7c3aed' },
    { bg: '#faf3e8', border: '#92400e' }
];
new Chart(bCtx, {
    type: 'bar',
    data: {
        labels: tradeLabels.length ? tradeLabels : ['No Data'],
        datasets: [{
            label: 'Bookings',
            data: tradeData.length ? tradeData : [0],
            backgroundColor: tradeLabels.map((_, i) => colors[i % colors.length].bg),
            borderColor: tradeLabels.map((_, i) => colors[i % colors.length].border),
            borderWidth: 1.5, borderRadius: 6
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: { grid: { color: '#f0ede6' }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
</body>
</html>
