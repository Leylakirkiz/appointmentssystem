<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --main-red: #c82333; --dark-red: #9f1c2b; --active-accent: #ffaa55; }
        body { background-color: #f8f9fa; }
        .sidebar { width: 280px; height: 100vh; background-color: var(--main-red); color: white; padding: 20px; position: fixed; left: 0; top: 0; z-index: 1000; }
        .profile-area { text-align: center; padding-bottom: 20px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.3); }
        .profile-image-placeholder { width: 70px; height: 70px; border-radius: 50%; background-color: var(--active-accent); border: 3px solid white; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 1.8em; color: var(--main-red); }
        .nav-button { display: flex; align-items: center; padding: 12px 15px; margin-bottom: 8px; text-decoration: none; color: white; border-radius: 8px; transition: 0.3s; }
        .nav-button:hover { background-color: var(--dark-red); color: white; }
        .nav-button.active { background-color: var(--dark-red); border-left: 4px solid var(--active-accent); }
        .main-content { margin-left: 280px; padding: 40px; }
        .card { border-radius: 15px; }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="profile-area">
        <div class="profile-image-placeholder">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <h4>{{ Auth::user()->name }}</h4>
        <p>{{ Auth::user()->email }}</p>
    </div>
    
<div class="menu-area" style="flex-grow: 1;">
    <a href="{{ route('hometh') }}" class="nav-button {{ request()->routeIs('hometh') ? 'active' : '' }}">
        <i class="fas fa-home me-2"></i> Dashboard
    </a>
    <a href="{{ route('teacher.notifications') }}" class="nav-button {{ request()->routeIs('teacher.notifications') ? 'active' : '' }}">
        <i class="fas fa-bell me-2"></i> Gelen İstekler
    </a>
    
    <a href="{{ route('teacher.reservations.list') }}" class="nav-button {{ request()->routeIs('teacher.reservations.list') ? 'active' : '' }}">
        <i class="fas fa-calendar-check me-2"></i> Rezervasyon Programım
    </a>

    <a href="{{ route('teacher.schedule') }}" class="nav-button {{ request()->routeIs('teacher.schedule') ? 'active' : '' }}">
        <i class="fas fa-calendar-alt me-2"></i> Haftalık Programım
    </a>
    <a href="{{ route('teacher.profile.edit') }}" class="nav-button {{ request()->routeIs('teacher.profile.edit') ? 'active' : '' }}">
        <i class="fas fa-user-cog me-2"></i> Profil Ayarları
    </a>
</div>

    <div class="logout-area" style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 20px;">
        <form action="{{ route('teacher.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">Çıkış Yap</button>
        </form>
    </div>
</nav>

<div class="main-content">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>