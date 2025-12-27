<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --main-red: #c82333;
            --dark-red: #9f1c2b;
            --text-color: #333333;
            --active-accent: #ffaa55;
        }

        /* Sidebar Sabitleme */
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
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2); 
        }

        .profile-image-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--active-accent);
            border: 3px solid white;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--main-red);
        }

        .profile-area h3 { margin: 10px 0 2px; font-size: 1.1em; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .profile-area p { margin: 0; font-size: 0.85em; opacity: 0.8; word-break: break-all; line-height: 1.2; }

        .menu-area { flex-grow: 1; width: 100%; overflow-y: auto; }

        .nav-button {
            display: flex; 
            align-items: center;
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 8px;
            text-decoration: none;
            color: white;
            font-size: 0.95em;
            border-radius: 8px;
            transition: all 0.2s;
            position: relative;
        }

        .nav-button i { margin-right: 15px; width: 20px; text-align: center; }
        .nav-button:hover { background-color: var(--dark-red); transform: translateX(5px); color: white; }

        .nav-button.active {
            background-color: var(--active-accent); 
            font-weight: bold;
            color: var(--text-color); 
        }

        .badge-count {
            position: absolute;
            right: 15px;
            background-color: white;
            color: var(--main-red);
            font-size: 0.75em;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 10px;
        }

        .logout-area {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 20px;
            margin-top: auto;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: white;
            color: var(--main-red);
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="profile-area">
            <div class="profile-image-placeholder">
                {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
            </div>
            <h3>{{ Auth::user()->name }}</h3>
            <p>{{ Auth::user()->email }}</p>
        </div>
        
        <div class="menu-area">
            <a href="{{ route('createreservations') }}" class="nav-button {{ request()->routeIs('createreservations') ? 'active' : '' }}">
                <i class="fas fa-calendar-plus"></i> Rezervasyon Oluştur
            </a>
            
            <a href="{{ route('reservations') }}" class="nav-button {{ request()->routeIs('reservations') ? 'active' : '' }}">
                <i class="fas fa-list-alt"></i> Rezervasyonlarım
            </a>

            <a href="{{ route('student.notifications') }}" class="nav-button {{ request()->routeIs('student.notifications') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Bildirimlerim
                @php
                    $unreadCount = \App\Models\Appointment::where('student_id', Auth::id())
                                    ->where('is_read_student', false)
                                    ->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="badge-count">{{ $unreadCount }}</span>
                @endif
            </a>
            
            <a href="{{ route('informations') }}" class="nav-button {{ request()->routeIs('informations') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Bilgilerim
            </a>
        </div>

        <div class="logout-area">
            <form action="{{ route('student.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                </button>
            </form>
        </div>
    </nav>

    <div style="margin-left: 280px; padding: 20px;">
        @yield('content')
    </div>

</body>
</html>