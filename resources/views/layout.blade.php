<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { 
            --main-blue: #1e3a8a; 
            --dark-blue: #1e1b4b; 
            --active-accent: #38bdf8; 
        }
        body { background-color: #f3f4f6; font-family: 'Segoe UI', sans-serif; }
        
        .sidebar { 
            width: 280px; height: 100vh; 
            background-color: var(--main-blue); 
            color: white; padding: 20px; 
            position: fixed; left: 0; top: 0; 
            z-index: 1000; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .profile-area { text-align: center; padding-bottom: 20px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .profile-image-placeholder { 
            width: 65px; height: 65px; border-radius: 50%; 
            background-color: var(--active-accent); 
            border: 3px solid white; margin: 0 auto 10px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.5em; color: var(--main-blue); font-weight: bold;
        }

        .nav-button { 
            display: flex; align-items: center; 
            padding: 12px 18px; margin-bottom: 10px; 
            text-decoration: none; color: rgba(255,255,255,0.8); 
            border-radius: 12px; transition: 0.3s all; 
            position: relative;
        }
        .nav-button i { width: 25px; font-size: 1.1em; }
        .nav-button:hover { background-color: rgba(255,255,255,0.1); color: white; transform: translateX(5px); }
        .nav-button.active { 
            background-color: white; 
            color: var(--main-blue); 
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .badge-count {
            position: absolute; right: 15px;
            background-color: #ef4444; color: white;
            font-size: 0.75em; padding: 2px 8px; border-radius: 10px;
        }

        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }
        .logout-area { position: absolute; bottom: 20px; width: calc(100% - 40px); }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="profile-area">
        <div class="profile-image-placeholder">
            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
        </div>
        <h5 class="mb-0 text-white">{{ Auth::user()->name }}</h5>
        <p class="mb-0 text-white-50" style="font-size: 0.85rem;">{{ Auth::user()->email }}</p>
    </div>
    
    <div class="menu-area">
        <a href="{{ route('home') }}" class="nav-button {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        
        <a href="{{ route('student.notifications') }}" class="nav-button {{ request()->routeIs('student.notifications') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notifications
            @php
                $unreadCount = \App\Models\Appointment::where('student_id', Auth::id())->where('is_read_student', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="badge-count">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('reservations') }}" class="nav-button {{ request()->routeIs('reservations') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Approved Appointments
        </a>

        <a href="{{ route('createreservations') }}" class="nav-button {{ request()->routeIs('createreservations') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Book Appointment
        </a>

        <a href="{{ route('informations') }}" class="nav-button {{ request()->routeIs('informations') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i> My Profile
        </a>
    </div>

    <div class="logout-area">
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 border-0 text-start">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>