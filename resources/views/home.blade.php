@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Welcome, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-secondary">Would you like to schedule a new meeting today?</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm transition-hover">
                <div class="mb-3 text-primary">
                    <i class="fas fa-calendar-plus fa-3x"></i>
                </div>
                <h4 class="fw-bold">Book Appointment</h4>
                <p class="text-muted">Select a faculty and lecturer to create a new meeting request.</p>
                <a href="{{ route('createreservations') }}" class="btn btn-primary mt-auto rounded-pill px-4">
                    Start Now
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm transition-hover">
                <div class="mb-3 text-info">
                    <i class="fas fa-tasks fa-3x"></i>
                </div>
                <h4 class="fw-bold">My Requests</h4>
                <p class="text-muted">Check the status of your pending, approved, or expired requests.</p>
                <a href="{{ route('student.notifications') }}" class="btn btn-info mt-auto rounded-pill px-4 text-white">
                    View List
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-4 text-center h-100 border-0 shadow-sm transition-hover">
                <div class="mb-3 text-secondary">
                    <i class="fas fa-user-cog fa-3x"></i>
                </div>
                <h4 class="fw-bold">Profile Settings</h4>
                <p class="text-muted">Update your department, class level, or contact information.</p>
                <a href="{{ route('informations') }}" class="btn btn-outline-secondary mt-auto rounded-pill px-4">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection