<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEU | Academic Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --neu-blue: #1e3a8a;
            --neu-dark: #1e293b;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f1f5f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .welcome-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 900px;
            width: 95%;
            display: flex;
            flex-direction: row;
        }

        .brand-section {
            background: var(--neu-blue);
            padding: 60px;
            color: white;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        
        .brand-section::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            opacity: 0.1;
            background-image: radial-gradient(#ffffff 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .login-section {
            padding: 60px;
            width: 60%;
            background: white;
        }

        .neu-logo-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            z-index: 1;
        }

        .btn-portal {
            display: flex;
            align-items: center;
            padding: 24px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            border: 2px solid #f1f5f9;
        }

        .btn-student { color: #1e40af; }
        .btn-student:hover { 
            background: #eff6ff; 
            border-color: #3b82f6;
            transform: translateX(5px);
        }

        .btn-teacher { color: #065f46; }
        .btn-teacher:hover { 
            background: #f0fdf4; 
            border-color: #10b981;
            transform: translateX(5px);
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 1.6rem;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .welcome-card { flex-direction: column; }
            .brand-section, .login-section { width: 100%; padding: 40px; }
            .brand-section { padding-top: 60px; padding-bottom: 60px; }
        }
    </style>
</head>
<body>

<div class="welcome-card">
    <div class="brand-section">
        <div class="neu-logo-icon">
            <i class="fas fa-university"></i>
        </div>
        <h2 class="fw-bold m-0">NEU</h2>
        <p class="opacity-75 mt-2">Academic Appointment & Consultation System</p>
    </div>

    <div class="login-section">
        <h3 class="fw-bold text-dark mb-1">Welcome</h3>
        <p class="text-muted mb-4">Please select your portal to continue.</p>

        <a href="{{ route('login') }}" class="btn-portal btn-student">
            <div class="icon-box bg-primary text-white shadow-sm">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="fw-bold fs-5">Student Portal</div>
                <small class="text-muted">Book appointments and track your requests.</small>
            </div>
        </a>

        <a href="{{ route('loginviewth') }}" class="btn-portal btn-teacher">
            <div class="icon-box bg-success text-white shadow-sm">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <div class="fw-bold fs-5">Teacher Portal</div>
                <small class="text-muted">Manage requests and organize your schedule.</small>
            </div>
        </a>

        <div class="text-center mt-5">
            <small class="text-muted">Near East University &copy; 2025</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>