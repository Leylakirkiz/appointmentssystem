<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Panel | Appointment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { 
            --primary-blue: #1e3a8a; 
            --hover-blue: #1e40af; 
            --accent-gold: #f59e0b; 
        }
        
        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; }

        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background-color: var(--primary-blue); 
            color: white; 
            padding: 25px; 
            position: fixed; 
            left: 0; 
            top: 0; 
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .profile-area { 
            text-align: center; 
            padding-bottom: 25px; 
            margin-bottom: 25px; 
            border-bottom: 1px solid rgba(255,255,255,0.1); 
        }

        .profile-avatar { 
            width: 65px; height: 65px; 
            border-radius: 50%; 
            background-color: white; 
            color: var(--primary-blue);
            margin: 0 auto 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.5rem; 
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-button { 
            display: flex; 
            align-items: center; 
            padding: 12px 18px; 
            margin-bottom: 5px; 
            text-decoration: none; 
            color: rgba(255,255,255,0.8); 
            border-radius: 10px; 
            transition: all 0.2s ease; 
        }

        .nav-button:hover { 
            background-color: rgba(255,255,255,0.1); 
            color: white; 
        }

        .nav-button.active { 
            background-color: rgba(255,255,255,0.15); 
            color: white; 
            font-weight: 600;
        }

        .nav-button i { width: 25px; font-size: 1.1rem; }

        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh;
        }

        .logout-btn {
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            padding: 10px;
            color: white;
            transition: 0.3s;
        }
        .badge-count {
            position: absolute; right: 15px;
            background-color: #ef4444; color: white;
            font-size: 0.75em; padding: 2px 8px; border-radius: 10px;
        }

        .logout-btn:hover {
            background-color: #ef4444;
            border-color: #ef4444;
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="profile-area">
        <div class="profile-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <h6 class="mb-1 fw-bold">{{ Auth::user()->name }}</h6>
        <p class="small mb-0 opacity-75">{{ Auth::user()->email }}</p>
    </div>
    
    <div class="menu-area flex-grow-1">
        <a href="{{ route('hometh') }}" class="nav-button {{ request()->routeIs('hometh') ? 'active' : '' }}">
            <i class="fas fa-th-large me-2"></i> Dashboard
        </a>
        
        <a href="{{ route('teacher.notifications') }}" class="nav-button {{ request()->routeIs('teacher.notifications') ? 'active' : '' }}">
            <i class="fas fa-inbox me-2"></i> Pending Requests
            @php
                $unreadCount = \App\Models\Appointment::where('teacher_id', Auth::id())->where('is_read_teacher', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="badge-count">{{ $unreadCount }}</span>
            @endif
        </a>
        
        
        <a href="{{ route('teacher.reservations.list') }}" class="nav-button {{ request()->routeIs('teacher.reservations.list') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i> Approved Schedule
        </a>

        <a href="{{ route('teacher.schedule') }}" class="nav-button {{ request()->routeIs('teacher.schedule') ? 'active' : '' }}">
            <i class="fas fa-clock me-2"></i> Weekly Availability
        </a>

        <a href="{{ route('teacher.profile.edit') }}" class="nav-button {{ request()->routeIs('teacher.profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-cog me-2"></i> Profile Settings
        </a>
    </div>

    <div class="logout-area mt-auto pt-3 border-top border-white border-opacity-10">
        <form action="{{ route('teacher.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn logout-btn w-100 d-flex align-items-center justify-content-center">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</nav>

<main class="main-content">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>