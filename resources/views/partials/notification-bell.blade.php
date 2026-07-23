<!-- Notification Bell -->
<div class="relative notification-bell" x-data="{ open: false }">
    <button id="notificationBellBtn" onclick="toggleNotificationDropdown()" class="relative p-2 text-gray-600 hover:bg-black/5 rounded-lg transition">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span id="notificationBadge" class="absolute -top-1 -right-1 bg-[#E8823C] text-white text-xs font-bold px-2 py-0.5 rounded-full hidden">0</span>
    </button>

    <!-- Dropdown -->
    <div id="notificationDropdown" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-[#16302A] text-sm">Notifications</h3>
            <button id="markAllReadBtn" onclick="markAllNotificationsRead()" class="text-xs text-[#E8823C] font-semibold hover:underline hidden">Mark all as read</button>
        </div>
        <div id="notificationList" class="max-h-80 overflow-y-auto">
            <div class="p-6 text-center text-sm text-gray-400">Loading...</div>
        </div>
        <a href="{{ route('notifications.index') }}" class="block p-3 text-center text-sm text-[#E8823C] font-semibold border-t border-gray-100 hover:bg-gray-50">
            View all notifications
        </a>
    </div>
</div>

<script>
let notificationPollInterval = null;

function toggleNotificationDropdown() {
    var dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('hidden');
    if (!dropdown.classList.contains('hidden')) {
        fetchRecentNotifications();
    }
}

function fetchRecentNotifications() {
    fetch('{{ route("notifications.recent") }}')
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('notificationList');
            const markAllBtn = document.getElementById('markAllReadBtn');

            if (data.notifications.length === 0) {
                list.innerHTML = '<div class="p-6 text-center text-sm text-gray-400">No notifications yet</div>';
                markAllBtn.classList.add('hidden');
                return;
            }

            if (data.unread_count > 0) {
                markAllBtn.classList.remove('hidden');
            } else {
                markAllBtn.classList.add('hidden');
            }

            list.innerHTML = data.notifications.map(n => `
                <a href="/notifications/${n.id}/read" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 ${n.is_read ? '' : 'bg-orange-50/50'}">
                    ${!n.is_read ? '<span class="w-2 h-2 bg-[#E8823C] rounded-full flex-shrink-0 mt-1.5"></span>' : '<span class="w-2 h-2 flex-shrink-0 mt-1.5"></span>'}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#16302A] truncate">${escapeHtml(n.title)}</p>
                        <p class="text-xs text-gray-500 truncate">${escapeHtml(n.message)}</p>
                        <p class="text-xs text-gray-400 mt-0.5">${n.time_ago}</p>
                    </div>
                </a>
            `).join('');
        })
        .catch(() => {
            document.getElementById('notificationList').innerHTML = '<div class="p-6 text-center text-sm text-red-400">Failed to load</div>';
        });
}

function markAllNotificationsRead() {
    fetch('{{ route("notifications.read-all") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(() => {
        fetchRecentNotifications();
        updateNotificationBadge();
        document.getElementById('markAllReadBtn').classList.add('hidden');
    });
}

function updateNotificationBadge() {
    fetch('{{ route("notifications.unread-count") }}')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const container = document.querySelector('.notification-bell');
    const dropdown = document.getElementById('notificationDropdown');
    if (container && dropdown && !container.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

// Poll every 15 seconds
document.addEventListener('DOMContentLoaded', function() {
    updateNotificationBadge();
    notificationPollInterval = setInterval(updateNotificationBadge, 15000);
});
</script>
