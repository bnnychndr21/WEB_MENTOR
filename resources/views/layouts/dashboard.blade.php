<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'MentorConnect'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #0ea5e9;
            --navbar-height: 64px;
            --primary-color: #0ea5e9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f1f5f9;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            z-index: 1040;
            transition: transform .3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1rem 1.25rem;
            font-size: 1.25rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            gap: .75rem;
            min-height: var(--navbar-height);
        }

        .sidebar-brand i { font-size: 1.5rem; color: var(--sidebar-active); }

        .sidebar-menu { padding: 1rem 0; flex: 1; overflow-y: auto; }

        .sidebar-menu .menu-label {
            padding: .5rem 1.25rem;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,.4);
            font-weight: 600;
        }

        .sidebar-menu .nav-item { padding: 0 .75rem; }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .85rem;
            color: rgba(255,255,255,.65);
            border-radius: .5rem;
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .sidebar-menu .nav-link:hover { background: var(--sidebar-hover); color: #fff; }

        .sidebar-menu .nav-link.active { background: var(--sidebar-active); color: #fff; }

        .sidebar-menu .nav-link i { font-size: 1.1rem; width: 1.25rem; text-align: center; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.1);
        }

        .sidebar-footer .user-info { display: flex; align-items: center; gap: .75rem; }

        .sidebar-footer .user-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--sidebar-active);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .9rem; flex-shrink: 0;
        }

        .sidebar-footer .user-detail { flex: 1; min-width: 0; }

        .sidebar-footer .user-name {
            font-size: .85rem; font-weight: 600;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .sidebar-footer .user-role {
            font-size: .7rem; color: rgba(255,255,255,.5); text-transform: capitalize;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            padding: 0 1.5rem;
            min-height: var(--navbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
        }

        .top-navbar .page-title { font-size: 1.15rem; font-weight: 600; color: #1e293b; }

        .top-navbar .navbar-right { display: flex; align-items: center; gap: 1rem; }

        .top-navbar .btn-icon {
            width: 38px; height: 38px; border-radius: 50%;
            border: none; background: transparent; color: #64748b;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; position: relative; transition: background .2s;
        }

        .top-navbar .btn-icon:hover { background: #f1f5f9; }

        .top-navbar .dropdown-user {
            display: flex; align-items: center; gap: .5rem;
            padding: .4rem .75rem; border-radius: .5rem;
            cursor: pointer; text-decoration: none; color: #334155; transition: background .2s;
        }

        .top-navbar .dropdown-user:hover { background: #f1f5f9; }

        .top-navbar .dropdown-user .avatar-sm {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--primary-color); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .8rem;
        }

        .page-content { padding: 1.5rem; }

        .stat-card {
            border: none; border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }

        .stat-card .card-body { padding: 1.25rem 1.5rem; }

        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: .75rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }

        .stat-card .stat-label {
            font-size: .8rem; color: #64748b;
            font-weight: 500; text-transform: uppercase; letter-spacing: .5px;
        }

        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: #1e293b; line-height: 1.2; }

        .stat-card .stat-desc { font-size: .8rem; color: #94a3b8; }

        .content-card { border: none; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); }

        .content-card .card-header {
            background: transparent; border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem; font-weight: 600;
        }

        .content-card .card-body { padding: 1.5rem; }

        .badge-status { font-size: .75rem; font-weight: 600; padding: .35em .65em; border-radius: .5rem; }

        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-disetujui { background: #dbeafe; color: #1e40af; }
        .badge-ditolak { background: #fee2e2; color: #991b1b; }
        .badge-selesai { background: #d1fae5; color: #065f46; }
        .badge-dijadwalkan { background: #e0e7ff; color: #3730a3; }

        .sidebar-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: #475569; cursor: pointer; }

        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,.5); z-index: 1035; }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .page-content { padding: 1rem; }
            .stat-card .stat-value { font-size: 1.4rem; }
            .content-card .card-header { padding: .85rem 1rem; }
            .content-card .card-body { padding: 1rem; }
        }

        .welcome-section {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            border-radius: 1rem; padding: 2rem; color: #fff; margin-bottom: 1.5rem;
        }

        .welcome-section h3 { font-weight: 700; margin-bottom: .5rem; }
        .welcome-section p { opacity: .9; margin-bottom: 0; }

        .activity-item {
            display: flex; align-items: flex-start; gap: .75rem;
            padding: .85rem 0; border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child { border-bottom: none; }

        .activity-icon {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: .9rem;
        }

        .activity-content { flex: 1; }
        .activity-title { font-size: .875rem; font-weight: 500; color: #1e293b; }
        .activity-time { font-size: .75rem; color: #94a3b8; }

        .pagination { margin-bottom: 0; }
        .page-link { border-radius: .5rem !important; margin: 0 2px; border: none; color: #1e293b; font-weight: 500; }
        .page-item.active .page-link { background: #0ea5e9; color: #fff; }
        .page-item.disabled .page-link { color: #94a3b8; background: transparent; }

        .star-rating .stars input { display: none; }
        .star-rating .stars label { cursor: pointer; color: #cbd5e1; transition: color .15s; }
        .star-rating .stars label:hover,
        .star-rating .stars label:hover ~ label,
        .star-rating .stars input:checked ~ label { color: #f59e0b; }

        .jadwal-option { display: inline-block; cursor: pointer; }
        .jadwal-option input { position: absolute; opacity: 0; pointer-events: none; }
        .jadwal-time {
            display: block; padding: .45rem 1rem;
            border: 2px solid #e2e8f0; border-radius: .75rem;
            font-size: .875rem; font-weight: 500; color: #1e293b; transition: all .2s;
        }
        .jadwal-option:hover .jadwal-time { border-color: #0ea5e9; background: #f0f9ff; }
        .jadwal-option input:checked + .jadwal-time { border-color: #0ea5e9; background: #0ea5e9; color: #fff; }

        #toast-container {
            position: fixed; top: 1rem; right: 1rem; z-index: 9999;
            display: flex; flex-direction: column; gap: .5rem;
        }
        .toast-custom {
            padding: .75rem 1.25rem; border-radius: .75rem;
            color: #fff; font-weight: 500; font-size: .9rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            transform: translateX(120%); transition: transform .3s ease;
            display: flex; align-items: center; gap: .5rem;
            max-width: 400px;
        }
        .toast-custom.show { transform: translateX(0); }
        .toast-custom.toast-success { background: #059669; }
        .toast-custom.toast-error { background: #dc2626; }
        .toast-custom i { font-size: 1.2rem; }
    </style>
    @stack('styles')
</head>
<body>

    <div id="toast-container"></div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span>MentorConnect</span>
        </div>

        <nav class="sidebar-menu">
                        @if (Auth::user()->peran === 'mentor')
                <div class="menu-label">Menu Mentor</div>
                <div class="nav-item">
                    <a href="{{ route('mentor.dashboard') }}" class="nav-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('mentor.pengajuan.index') }}" class="nav-link {{ request()->routeIs('mentor.pengajuan.*') ? 'active' : '' }}">
                        <i class="bi bi-inbox-fill"></i> Pengajuan
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('mentor.jadwal.index') }}" class="nav-link {{ request()->routeIs('mentor.jadwal.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-week-fill"></i> Jadwal
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('mentor.ulasan.index') }}" class="nav-link {{ request()->routeIs('mentor.ulasan.*') ? 'active' : '' }}">
                        <i class="bi bi-star-fill"></i> Ulasan
                    </a>
                </div>
                <div class="nav-item mt-2">
                    <a href="{{ route('mentor.profil') }}" class="nav-link {{ request()->routeIs('mentor.profil') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i> Profil Saya
                    </a>
                </div>
            @else
                <div class="menu-label">Menu Mahasiswa</div>
                <div class="nav-item">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('mahasiswa.cari-mentor') }}" class="nav-link {{ request()->routeIs('mahasiswa.cari-mentor') ? 'active' : '' }}">
                        <i class="bi bi-search-heart-fill"></i> Cari Mentor
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'active' : '' }}">
                        <i class="bi bi-send-fill"></i> Pengajuan
                    </a>
                </div>
                <div class="nav-item mt-2">
                    <a href="{{ route('mahasiswa.profil') }}" class="nav-link {{ request()->routeIs('mahasiswa.profil') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i> Profil Saya
                    </a>
                </div>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                @php
                    $user = Auth::user();
                    $fotoSidebar = $user->peran === 'mentor'
                        ? $user->mentorProfil?->foto
                        : $user->mahasiswaProfil?->foto;
                @endphp
                @if ($fotoSidebar)
                    <img src="{{ asset('storage/' . $fotoSidebar) }}" class="user-avatar" style="width:38px;height:38px;border-radius:50%;object-fit:cover;">
                @else
                    <div class="user-avatar">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
                @endif
                <div class="user-detail">
                    <div class="user-name">{{ Auth::user()->nama }}</div>
                    <div class="user-role">{{ Auth::user()->peran === 'mentor' ? 'Mentor' : 'Mahasiswa' }}</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="navbar-right">
                <div class="dropdown">
                    <a href="#" class="dropdown-user dropdown-toggle" data-bs-toggle="dropdown">
                        @php
                            $fotoNavbar = $user->peran === 'mentor'
                                ? $user->mentorProfil?->foto
                                : $user->mahasiswaProfil?->foto;
                        @endphp
                        @if ($fotoNavbar)
                            <img src="{{ asset('storage/' . $fotoNavbar) }}" class="avatar-sm" style="width:34px;height:34px;border-radius:50%;object-fit:cover;">
                        @else
                            <div class="avatar-sm">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
                        @endif
                        <span class="d-none d-sm-inline">{{ Auth::user()->nama }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: .75rem; border: none; margin-top: .5rem;">
            @if (Auth::user()->peran === 'mentor')
                            <li><a class="dropdown-item" href="{{ route('mentor.profil') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('mahasiswa.profil') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="page-content">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
        });

        function showToast(message, type) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast-custom toast-' + type;
            const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
            toast.innerHTML = '<i class="bi ' + icon + '"></i> ' + message;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 50);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('{{ $error }}', 'error');
            @endforeach
        @endif

        function confirmAction(message, callback) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#64748b',
                reverseButtons: true,
                borderRadius: '1rem',
            }).then((result) => {
                if (result.isConfirmed) callback();
            });
        }

        document.querySelectorAll('[data-confirm]').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                const msg = this.dataset.confirm || 'Yakin ingin melanjutkan?';
                const form = this.closest('form');
                confirmAction(msg, () => { if (form) form.submit(); });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
