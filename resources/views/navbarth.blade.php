<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --main-red: #c82333; 
            --dark-red: #9f1c2b; 
            --text-color: #333333; 
            --active-accent: #ffaa55; 
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            background-color: var(--main-red);
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .profile-area {
            width: 100%;
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-image-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--active-accent);
            border: 3px solid white;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8em;
            font-weight: bold;
            color: var(--main-red);
        }

        .profile-area h4 { margin: 5px 0; font-size: 1.1em; }
        .profile-area p { margin: 0; font-size: 0.85em; opacity: 0.8; }

        .menu-area { flex-grow: 1; }

        .nav-button {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            text-decoration: none;
            color: white;
            font-size: 1em;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-button i { margin-right: 12px; width: 20px; text-align: center; }
        .nav-button:hover { background-color: var(--dark-red); transform: translateX(5px); }
        
        /* Aktif sayfa belirtici */
        .nav-button.active {
            background-color: var(--dark-red);
            border-left: 4px solid var(--active-accent);
        }

        .notification-badge {
            position: absolute;
            right: 15px;
            background-color: white;
            color: var(--main-red);
            font-size: 0.75em;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .logout-area {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            padding-top: 20px;
        }

        .logout-btn {
            background: none;
            border: 1px solid white;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-btn i { margin-right: 10px; }
        .logout-btn:hover { background: white; color: var(--main-red); }

        /* İçerik alanı için ana taşıyıcı (Main content padding için) */
        .main-content {
            margin-left: 280px;
            padding: 40px;
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="profile-area">
        <div class="profile-image-placeholder">
            {{ strtoupper(substr($teacher->name ?? 'T', 0, 1)) }}
        </div>
        @if(isset($teacher))
            <h4>{{ $teacher->name }}</h4>
            <p>{{ $teacher->email }}</p>
            <p style="font-size: 0.75em; margin-top: 5px; color: var(--active-accent);">{{ $teacher->faculty->name ?? 'Fakülte Belirtilmemiş' }}</p>
        @endif
    </div>
    
    <div class="menu-area">
        {{-- 1. Randevu İstekleri --}}
        <a href="{{ route('teacher.notifications') }}" class="nav-button {{ request()->routeIs('teacher.notifications') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Gelen İstekler
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="notification-badge">{{ $unreadCount }}</span>
            @endif
        </a>

        {{-- 2. Haftalık Program (Sadece Tablo) --}}
        <a href="{{ route('teacher.schedule') }}" class="nav-button {{ request()->routeIs('teacher.informations.view') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Haftalık Programım
        </a>

        {{-- 3. Profil Ayarları (Yeni Eklenen) --}}
        <a href="{{ route('teacher.profile.edit') }}" class="nav-button {{ request()->routeIs('teacher.profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i> Profil Ayarları
        </a>
        <a class="nav-link {{ Request::routeIs('teacher.reservations.list') ? 'active' : '' }}" 
       href="{{ route('teacher.reservations.list') }}">
        <i class="bi bi-calendar-check"></i> Rezervasyon Programım
    </a>
    </div>

    <div class="logout-area">
        <form action="{{ route('teacher.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Çıkış Yap
            </button>
        </form>
    </div>
</nav>

{{-- Buradan sonrası @yield('content') ile gelecek --}}

</body>
</html>