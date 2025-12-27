@extends('layout')

@section('title', 'Kullanıcı Bilgileri')

@section('content')
<style>
    .reserve-wrapper {
        margin-left: 280px;
        padding: 40px;
        width: calc(100% - 280px);
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
    }
    .custom-check .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .profile-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

<div class="reserve-wrapper">
    <div class="container-fluid">
        <div class="col-xl-10 mx-auto">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px; height:50px;">
                    <i class="fas fa-user-graduate fa-lg"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">Profil Bilgilerim</h2>
                    <p class="text-muted mb-0">Akademik bilgilerinizi buradan güncelleyebilirsiniz.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="card profile-card overflow-hidden">
                <div class="card-header bg-dark py-3 border-0">
                    <h5 class="card-title mb-0 text-white fw-bold small text-uppercase" style="letter-spacing: 1px;">
                        Sistem Kayıt Bilgileri
                    </h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('student.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Ad Soyad</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 py-2" value="{{ $student->name }}" readonly>
                                </div>
                                <small class="text-muted mt-1 d-block">Ad soyad değişikliği için öğrenci işlerine başvurunuz.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">E-posta Adresi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control bg-light border-0 py-2" value="{{ $student->email }}" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-2 opacity-25">
                                <h6 class="fw-bold text-danger mb-3">Güncellenebilir Akademik Bilgiler</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Fakülte</label>
                                <select name="faculty_id" class="form-select py-2" required>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" {{ $student->faculty_id == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Bölüm / Program</label>
                                <input type="text" name="department" class="form-control py-2" 
                                       placeholder="Örn: Yazılım Mühendisliği" value="{{ $student->department }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Sınıf</label>
                                <select name="class_level" class="form-select py-2">
                                    <option value="" disabled {{ !$student->class_level ? 'selected' : '' }}>Sınıf Seçiniz</option>
                                    <option value="1" {{ $student->class_level == 1 ? 'selected' : '' }}>1. Sınıf</option>
                                    <option value="2" {{ $student->class_level == 2 ? 'selected' : '' }}>2. Sınıf</option>
                                    <option value="3" {{ $student->class_level == 3 ? 'selected' : '' }}>3. Sınıf</option>
                                    <option value="4" {{ $student->class_level == 4 ? 'selected' : '' }}>4. Sınıf</option>
                                    <option value="5" {{ $student->class_level > 4 ? 'selected' : '' }}>Lisansüstü</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Eğitim Dili</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check custom-check">
                                        <input class="form-check-input" type="radio" name="language" id="langTr" value="Türkçe" {{ $student->language == 'Türkçe' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="langTr">Türkçe</label>
                                    </div>
                                    <div class="form-check custom-check">
                                        <input class="form-check-input" type="radio" name="language" id="langEn" value="İngilizce" {{ $student->language == 'İngilizce' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="langEn">İngilizce</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-danger rounded-pill px-5 py-2 fw-bold shadow">
                                <i class="fas fa-check me-2"></i>Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection