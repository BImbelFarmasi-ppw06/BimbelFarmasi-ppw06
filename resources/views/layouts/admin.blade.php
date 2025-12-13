<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard - Bimbel Farmasi">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') · Admin
        @else
            Admin Dashboard
        @endif
         · Bimbel Farmasi
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#2D3C8C',
                            'sidebar': '#1e293b',
                        },
                        fontFamily: {
                            sans: ['Poppins', 'ui-sans-serif', 'system-ui'],
                        },
                    }
                }
            }
        </script>
        <style>
            body {
                font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
                -webkit-font-smoothing: antialiased;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endif
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1e293b] text-white transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex h-full flex-col">
                <!-- Logo -->
                <div class="flex h-16 items-center gap-3 border-b border-slate-700 px-6">
                    <span class="text-xl font-bold">🎓 Bimbel Farmasi</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                    <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="@if(request()->routeIs('admin.students.*')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Peserta
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="@if(request()->routeIs('admin.classes.*') || request()->routeIs('admin.programs.*') || request()->routeIs('admin.questions.*')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Kelas
                    </a>
                    <a href="{{ route('admin.joki.index') }}" class="@if(request()->routeIs('admin.joki.*')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Daftar Penjoki
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="@if(request()->routeIs('admin.payments.*')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Pembayaran
                    </a>
                    <a href="{{ route('admin.statistics') }}" class="@if(request()->routeIs('admin.statistics')) bg-[#2D3C8C] @endif flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Laporan & Statistik
                    </a>
                </nav>

                <!-- Logout -->
                <div class="border-t border-slate-700 p-3">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition hover:bg-slate-700 hover:text-red-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6">
                <button id="sidebar-toggle" class="rounded-lg p-2 text-gray-600 hover:bg-gray-100 lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">Admin Dashboard</span>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="relative rounded-lg p-2 text-gray-600 hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notification-badge" class="absolute right-1 top-1 hidden">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                            </span>
                            <span id="notification-count" class="absolute -right-1 -top-1 hidden h-5 w-5 rounded-full bg-red-500 text-xs text-white flex items-center justify-center font-semibold"></span>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-96 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                             style="display: none;">
                            <div class="p-4 border-b flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                                <button onclick="markAllAsRead()" class="text-xs text-[#2D3C8C] hover:underline">
                                    Tandai Semua Dibaca
                                </button>
                            </div>
                            <div id="notification-list" class="max-h-96 overflow-y-auto">
                                <!-- Notifications will be loaded here -->
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    Loading...
                                </div>
                            </div>
                            <div class="p-3 border-t text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-sm text-[#2D3C8C] hover:underline font-medium">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2D3C8C&color=fff" alt="Admin" class="h-8 w-8 rounded-full">
                        <div class="hidden text-sm lg:block">
                            <p class="font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden"></div>

    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            }

            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);

            // Load notifications
            loadNotifications();
            setInterval(loadNotifications, 30000); // Refresh every 30 seconds
        });

        function loadNotifications() {
            fetch('{{ route("admin.notifications.recent") }}')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.length);
                    renderNotifications(data);
                })
                .catch(error => console.error('Error loading notifications:', error));
        }

        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            const countEl = document.getElementById('notification-count');
            
            if (count > 0) {
                badge.classList.remove('hidden');
                countEl.classList.remove('hidden');
                countEl.textContent = count > 9 ? '9+' : count;
            } else {
                badge.classList.add('hidden');
                countEl.classList.add('hidden');
            }
        }

        function renderNotifications(notifications) {
            const list = document.getElementById('notification-list');
            
            if (notifications.length === 0) {
                list.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-sm">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }

            list.innerHTML = notifications.map(notif => `
                <div class="border-b hover:bg-gray-50 transition ${!notif.is_read ? 'bg-blue-50' : ''}">
                    <a href="${notif.link || '#'}" onclick="markAsRead(${notif.id})" class="block p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg ${getNotificationColor(notif.type)}">
                                ${getNotificationIcon(notif.type)}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900">${notif.title}</p>
                                <p class="text-xs text-gray-600 mt-1">${notif.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${formatTime(notif.created_at)}</p>
                            </div>
                            ${!notif.is_read ? '<span class="w-2 h-2 bg-blue-500 rounded-full"></span>' : ''}
                        </div>
                    </a>
                </div>
            `).join('');
        }

        function getNotificationColor(type) {
            const colors = {
                'payment': 'bg-green-100',
                'order': 'bg-blue-100',
                'registration': 'bg-purple-100',
                'assignment': 'bg-orange-100'
            };
            return colors[type] || 'bg-gray-100';
        }

        function getNotificationIcon(type) {
            const icons = {
                'payment': '<svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'order': '<svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>',
                'registration': '<svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>',
                'assignment': '<svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
            };
            return icons[type] || '<svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>';
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000);

            if (diff < 60) return 'Baru saja';
            if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
            if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
            if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
            
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        }

        function markAsRead(id) {
            fetch(`/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(() => loadNotifications());
        }

        function markAllAsRead() {
            fetch('/admin/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(() => {
                loadNotifications();
                window.location.reload();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
