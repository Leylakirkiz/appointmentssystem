@extends('layoutth')

@section('content')
<div class="teacher-wrapper" style="margin-left: 280px; padding: 40px;">
    <div class="col-md-8 mx-auto">
        <h2 class="fw-bold mb-4">Profil Bilgilerim</h2>
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-danger text-white py-3 text-center rounded-top-4">
                <h5 class="mb-0">Kişisel ve Akademik Bilgiler</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('teacher.profile.update') }}" method="POST">
                    @csrf
                    {{-- Eğer route'unuz PUT bekliyorsa buraya @method('PUT') eklemeyi unutmayın --}}
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ad Soyad</label>
                        <input type="text" name="name" class="form-control shadow-sm" value="{{ $teacher->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">E-posta</label>
                        <input type="email" class="form-control bg-light" value="{{ $teacher->email }}" readonly>
                        <small class="text-muted">E-posta adresi değiştirilemez.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ofis Konumu / Oda Numarası</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-door-open text-danger"></i></span>
                            <input type="text" name="office_location" class="form-control border-start-0 shadow-sm" 
                                   placeholder="Örn: Mühendislik Fakültesi, B Blok, Oda 302" 
                                   value="{{ $teacher->office_location }}">
                        </div>
                        <small class="text-muted">Öğrenciler randevu alırken bu konumu görecektir.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Bağlı Olduğu Fakülte</label>
                        <select name="faculty_id" class="form-select shadow-sm">
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ $teacher->faculty_id == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger btn-lg rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i>Bilgileri Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection