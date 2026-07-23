<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixly – Payments & Payouts</title>
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
        .stat-card { background: #fff; border-radius: 14px; padding: 20px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .stat-value { font-size: 1.8rem; font-weight: 800; }
        .stat-label { font-size: 0.78rem; color: #6b7280; margin-top: 2px; }
        .table-wrap { background: #fff; border-radius: 14px; border: 1px solid #ece8df; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 28px; }
        .table-wrap h2 { font-size: 1.05rem; font-weight: 700; color: #111827; padding: 18px 20px 0; }
        .table-wrap table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .table-wrap th { text-align: left; padding: 14px 16px; font-size: 0.7rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; background: #faf9f6; border-bottom: 1px solid #ece8df; }
        .table-wrap td { padding: 12px 16px; border-bottom: 1px solid #f3f0ea; color: #374151; }
        .table-wrap tbody tr:hover { background: #faf8f5; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-failed { background: #fee2e2; color: #991b1b; }
        .badge-approved { background: #dbeafe; color: #1e40af; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .btn-sm { padding: 4px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 600; border: none; cursor: pointer; }
        .section-toggle { display: none; }
        .section-toggle-label { cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; color: #16302A; padding: 8px 16px; background: #fff; border-radius: 10px; border: 1px solid #ece8df; margin-bottom: 16px; }
        .section-toggle-label:hover { background: #faf8f5; }
        @media (max-width: 768px) { .content { padding: 20px 16px; } .topbar { padding: 12px 16px; } .stat-card { padding: 16px; } .stat-value { font-size: 1.4rem; } .table-wrap { overflow-x: auto; } }
    </style>
</head>
<body>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H15v-5h-6v5H4a1 1 0 01-1-1V9.5z" fill="#E8823C"/></svg>
        <span>Fix<em>ly</em> <span style="font-size:0.65rem;color:#4a7a6a;font-weight:500;">Admin</span></span>
    </div>
    <nav class="nav-section">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg><span>Dashboard Overview</span></a>
        <a href="{{ route('admin.professionals') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span>Professionals</span></a>
        <a href="{{ route('admin.customers') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span>Customers</span></a>
        <a href="{{ route('admin.jobs') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg><span>Jobs / Bookings</span></a>
        <a href="{{ route('admin.categories') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg><span>Categories / Trades</span></a>
        <div class="nav-label">Finance</div>
        <a href="{{ route('admin.payments') }}" class="nav-item active"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Payments & Payouts</span></a>
        <a href="{{ route('admin.reports') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 0 002 2h2a2 2 0 002 2v10m-6 0a2 2 0 002 2h2a2 2 0 012 2v14a2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg><span>Reports / Analytics</span></a>
        <div class="nav-label">Content</div>
        <a href="{{ route('admin.cms') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/></svg><span>Website Content</span></a>
        <div class="nav-label">Quality</div>
        <a href="{{ route('admin.reviews') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg><span>Reviews & Ratings</span></a>
        <a href="{{ route('admin.tickets') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg><span>Contact Messages</span></a>
        <a href="{{ route('admin.settings') }}" class="nav-item"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573 1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.572c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg><span>Settings</span></a>
    </nav>
    <div class="sidebar-bottom">
        <div class="admin-profile">
            <img src="https://randomuser.me/api/portraits/men/10.jpg" class="admin-avatar" alt="Admin">
            <div class="admin-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
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
        <div class="page-title">Payments & Payouts</div>
        <div class="page-sub">Manage payments and payouts on the platform</div>

        @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;padding:10px 16px;border-radius:10px;font-size:0.85rem;font-weight:500;margin-bottom:20px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#fee2e2;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.85rem;font-weight:500;margin-bottom:20px;">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div style="background:#dbeafe;color:#1e40af;padding:10px 16px;border-radius:10px;font-size:0.85rem;font-weight:500;margin-bottom:20px;">{{ session('info') }}</div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stat-card"><div class="stat-value text-[#16302A]">Rs. {{ number_format($stats['total_revenue']) }}</div><div class="stat-label">Platform Revenue (fees)</div></div>
            <div class="stat-card"><div class="stat-value text-[#D9A441]">{{ $stats['total_processed'] }}</div><div class="stat-label">Payments Processed</div></div>
            <div class="stat-card"><div class="stat-value text-[#E8823C]">{{ $stats['pending_payments'] }}</div><div class="stat-label">Pending Payments</div></div>
            <div class="stat-card"><div class="stat-value text-[#E8823C]">{{ $stats['pending_payouts'] }}</div><div class="stat-label">Pending Payouts</div></div>
        </div>

        <!-- Payments Table -->
        <div class="table-wrap">
            <h2>All Payments</h2>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Professional</th>
                            <th>Job</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Payout</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $p)
                        <tr>
                            <td class="font-mono text-xs">#{{ $p->id }}</td>
                            <td class="font-medium">{{ $p->customer->name ?? '—' }}</td>
                            <td class="font-medium">{{ $p->professional->name ?? '—' }}</td>
                            <td>{{ $p->job->trade_category ?? '—' }}</td>
                            <td class="font-semibold">Rs. {{ number_format($p->amount) }}</td>
                            <td class="text-gray-500">Rs. {{ number_format($p->platform_fee) }}</td>
                            <td class="font-semibold text-[#16302A]">Rs. {{ number_format($p->professional_payout_amount) }}</td>
                            <td class="text-xs text-gray-500">{{ $p->payment_method ? ucwords(str_replace('_', ' ', $p->payment_method)) : '—' }}</td>
                            <td>
                                @if($p->status === 'paid')
                                    <span class="badge badge-paid">Paid</span>
                                @elseif($p->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($p->status === 'failed')
                                    <span class="badge badge-failed">Failed</span>
                                @else
                                    <span class="badge badge-pending">{{ ucfirst($p->status) }}</span>
                                @endif
                            </td>
                            <td class="text-xs text-gray-500">{{ $p->paid_at ? $p->paid_at->format('M j, Y') : ($p->created_at->format('M j, Y')) }}</td>
                            <td>
                                @if($p->status === 'pending')
                                <form method="POST" action="{{ route('admin.payments.mark-paid', $p) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-sm bg-[#16302A] text-white hover:bg-[#1e4238]">Mark Paid</button>
                                </form>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center py-12 text-gray-400 text-sm">No payments recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="padding:12px 16px;border-top:1px solid #ece8df;font-size:0.8rem;color:#6b7280;">
                {{ $payments->links() }}
            </div>
        </div>

        <!-- Payout Requests -->
        <div class="table-wrap">
            <h2>Payout Requests</h2>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Professional</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Requested</th>
                            <th>Processed</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payoutRequests as $pr)
                        <tr>
                            <td class="font-mono text-xs">#{{ $pr->id }}</td>
                            <td class="font-medium">{{ $pr->professional->name ?? '—' }}</td>
                            <td class="font-semibold text-[#16302A]">Rs. {{ number_format($pr->amount) }}</td>
                            <td>
                                @if($pr->status === 'paid')
                                    <span class="badge badge-paid">Paid</span>
                                @elseif($pr->status === 'approved')
                                    <span class="badge badge-approved">Approved</span>
                                @elseif($pr->status === 'rejected')
                                    <span class="badge badge-rejected">Rejected</span>
                                @else
                                    <span class="badge badge-pending">Pending</span>
                                @endif
                            </td>
                            <td class="text-xs">{{ $pr->created_at->format('M j, Y') }}</td>
                            <td class="text-xs">{{ $pr->processed_at ? $pr->processed_at->format('M j, Y') : '—' }}</td>
                            <td class="text-xs text-gray-500 max-w-[120px] truncate">{{ $pr->admin_notes ?? '—' }}</td>
                            <td>
                                @if($pr->status === 'pending' || $pr->status === 'approved')
                                <div class="flex gap-1 flex-wrap">
                                    <form method="POST" action="{{ route('admin.payout-requests.process', $pr) }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn-sm bg-blue-100 text-blue-700 hover:bg-blue-200">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.payout-requests.process', $pr) }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="pay">
                                        <button type="submit" class="btn-sm bg-green-100 text-green-700 hover:bg-green-200">Mark Paid</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.payout-requests.process', $pr) }}" style="display:inline;" onsubmit="return prompt('Rejection reason (optional):')">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn-sm bg-red-100 text-red-700 hover:bg-red-200">Reject</button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-12 text-gray-400 text-sm">No payout requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <p class="text-xs text-gray-400 mt-4">Manual tracking — no live payment gateway connected. Payments and payouts are recorded and processed manually.</p>
    </div>
</div>
<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const main = document.getElementById('main');
    sb.classList.toggle('collapsed');
    main.classList.toggle('expanded');
}
</script>
<script src="/js/theme-toggle.js"></script>
</body>
</html>
