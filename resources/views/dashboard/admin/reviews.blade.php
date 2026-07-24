<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixly – Reviews & Ratings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/dark-mode.css">
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
        .logout-btn { display: flex; align-items: center; gap: 8px; margin-top: 10px; padding: 8px 12px; border-radius: 8px; background: rgba(232,130,60,0.12); color: #E8823C; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: none; width: 100%; }
        .sidebar.collapsed .logout-btn span { display: none; }
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; transition: margin-left 0.2s; }
        .main.expanded { margin-left: 64px; }
        .topbar { background: #fff; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ece8df; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .toggle-btn { background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .hamburger-btn { display: none; background: none; border: none; cursor: pointer; padding: 4px; color: #6b7280; }
        .content { padding: 28px; flex: 1; }
        .page-title { font-size: 1.4rem; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .page-sub { font-size: 0.82rem; color: #9ca3af; margin-bottom: 24px; }
        .table-card { background: #fff; border-radius: 14px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 28px; overflow: hidden; }
        .table-header { padding: 20px 24px 16px; display: flex; align-items: center; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 10px 16px; text-align: left; font-size: 0.72rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; background: #faf9f6; border-bottom: 1px solid #ece8df; }
        td { padding: 12px 16px; font-size: 0.82rem; color: #374151; border-bottom: 1px solid #f5f1ea; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf9f6; }
        .action-btn { padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-danger { background: #fee2e2; color: #b91c1c; border: none; }
        .pagination { display: flex; justify-content: center; gap: 8px; padding: 20px; }
        .pagination a, .pagination span { padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb; text-decoration: none; color: #374151; font-size: 0.85rem; }
        .pagination .active { background: #E8823C; color: #fff; border-color: #E8823C; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        .sidebar.mobile-open { transform: translateX(0) !important; }
        @media (max-width: 1024px) {
            .table-card { overflow-x: auto; } table { min-width: 600px; }
            .sidebar { transform: translateX(-100%); width: 280px !important; transition: transform 0.3s ease; }
            .sidebar.collapsed { transform: translateX(0); }
            .sidebar .nav-item span, .sidebar .nav-label, .sidebar .sidebar-logo span, .sidebar .admin-info, .sidebar .logout-btn span { display: flex !important; }
            .main { margin-left: 0; }
            .hamburger-btn { display: block; }
            .toggle-btn { display: none; }
        }
        @media (max-width: 768px) { .content { padding: 20px 16px; } .topbar { padding: 12px 16px; } }
        @media (max-width: 600px) { h1.page-title { font-size: 1.15rem; } }
    </style>
</head>
<body>
<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/>
        </svg>
        <span>Fix<em>ly</em> <span style="font-size:0.65rem;color:#4a7a6a;font-weight:500;">Admin</span></span>
    </div>
    <nav class="nav-section">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
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
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2"/></svg>
            <span>Jobs / Bookings</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>Categories / Trades</span>
        </a>
        <div class="nav-label">Finance</div>
        <a href="{{ route('admin.payments') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Payments & Payouts</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>Reports / Analytics</span>
        </a>
        <div class="nav-label">Content</div>
        <a href="{{ route('admin.cms') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><circle cx="4" cy="4" r="1.5" fill="currentColor" stroke="none"/></svg>
            <span>Website Content</span>
        </a>
        <div class="nav-label">Quality</div>
        <a href="{{ route('admin.reviews') }}" class="nav-item active">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span>Reviews & Ratings</span>
        </a>
        <a href="{{ route('admin.tickets') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Contact Messages</span>
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-item">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
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
<div class="main" id="main">
    <div class="topbar">
        <div class="topbar-left">
            <a href="{{ route('home') }}" class="flex items-center gap-2" title="Back to Website" style="text-decoration:none; flex-shrink:0;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/></svg>
                <span style="font-weight:700; font-size:1rem; color:#111827; white-space:nowrap;">Fix<span style="color:#E8823C;">ly</span></span>
            </a>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <button class="hamburger-btn" onclick="toggleMobileSidebar()">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <div class="flex items-center gap-2">
                @include('partials.theme-toggle')
                @include('partials.notification-bell')
            </div>
    </div>
    <div class="content">
        <div class="page-title">Reviews & Ratings</div>
        <div class="page-sub">Manage all reviews on the platform</div>
        <div class="table-card">
            <div class="table-header">
                <div>
                    <div class="card-title" style="font-size:1rem;font-weight:700;color:#111827;">All Reviews</div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Professional</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($reviews->count() > 0)
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->customer ? $review->customer->name : 'N/A' }}</td>
                                <td>{{ $review->pro ? $review->pro->name : 'N/A' }}</td>
                                <td>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                                <td>{{ $review->comment ?: 'No comment' }}</td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.reviews.delete', $review->id) }}" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="6" style="text-align:center;padding:30px;color:#9ca3af;">No reviews found</td></tr>
                    @endif
                </tbody>
            </table>
            @if($reviews->hasPages())
                <div class="pagination">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    sb.classList.toggle('collapsed');
    main.classList.toggle('expanded');
}
function toggleMobileSidebar() {
    const sb = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sb.classList.toggle('collapsed');
    if (overlay) overlay.classList.toggle('active');
    document.body.style.overflow = sb.classList.contains('collapsed') ? 'hidden' : '';
}
</script>
<script src="/js/theme-toggle.js"></script>
</body>
</html>

