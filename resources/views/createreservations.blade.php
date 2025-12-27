@extends('layout')

@section('content')
<style>
    :root {
        --primary-red: #e63946;
        --soft-gray: #f8f9fa;
    }

    body { 
        background-color: #f4f7f6; 
        margin: 0; 
    }

    /* --- SIDEBAR UYUMU İÇİN ANA ALAN --- */
    .faculty-page-wrapper {
        margin-left: 280px; /* Sidebar genişliği kadar boşluk */
        padding: 50px 40px;
        min-height: 100vh;
        width: calc(100% - 280px); /* Ekranın kalan kısmını tam kapla */
        box-sizing: border-box;
    }

    /* Kartın Ana Yapısı */
    .faculty-card {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    /* Arka Plan Süsü */
    .faculty-card::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 100px;
        height: 100px;
        background: rgba(230, 57, 70, 0.05);
        border-radius: 50%;
        transition: all 0.4s ease;
        z-index: -1;
    }

    .faculty-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
    }

    .faculty-card:hover::before {
        width: 300px;
        height: 300px;
        background: rgba(230, 57, 70, 0.1);
    }

    /* İkon Alanı */
    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #e63946 0%, #b91c1c 100%);
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 10px 20px rgba(230, 57, 70, 0.3);
        margin-bottom: 25px;
    }

    .faculty-name {
        font-weight: 800;
        font-size: 1.25rem;
        color: #1a1a1a;
        line-height: 1.3;
        margin-bottom: 12px;
        min-height: 3.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .info-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .arrow-btn {
        width: 45px;
        height: 45px;
        background: #1a1a1a;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .faculty-card:hover .arrow-btn {
        background: var(--primary-red);
        transform: rotate(-45deg);
    }

    .faculty-link {
        text-decoration: none;
    }

    /* Mobil Uyumluluk */
    @media (max-width: 992px) {
        .faculty-page-wrapper {
            margin-left: 0;
            width: 100%;
            padding: 30px 15px;
        }
    }
</style>

<div class="faculty-page-wrapper">
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10 text-center">
            <span class="badge bg-danger mb-2 px-3 py-2 rounded-pill">NEU DEPARTMENTS</span>
            <h1 class="display-5 fw-bold text-dark">Explore Our Faculties</h1>
            <p class="lead text-muted">Pick a faculty to find the right lecturer for your academic success.</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($faculties as $faculty)
            <div class="col-xl-4 col-md-6">
                <a href="{{ route('faculty.teachers', $faculty->id) }}" class="faculty-link">
                    <div class="card faculty-card h-100 p-4 shadow-sm">
                        <div class="card-body p-0 d-flex flex-column">
                            <div class="icon-wrapper">
                                <span>{{ strtoupper(substr($faculty->name, 0, 1)) }}</span>
                            </div>
                            
                            <h5 class="faculty-name">{{ $faculty->name }}</h5>
                            
                            <div class="mt-auto d-flex align-items-center justify-content-between">
                                <div class="info-badge">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    {{ $faculty->teachers->count() }} Teachers
                                </div>
                                <div class="arrow-btn">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection