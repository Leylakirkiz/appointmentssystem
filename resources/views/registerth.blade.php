<form method="POST" action="{{ route('registerth') }}">
    @csrf 
    
    {{-- 1. AD SOYAD --}}
    <div class="mb-3">
        <label for="inputName" class="form-label">Ad Soyad</label>
        <input class="form-control @error('name') is-invalid @enderror" id="inputName" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Hoca Ad Soyad" />
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    
    {{-- 2. E-POSTA (@neu.edu.tr formatında) --}}
    <div class="mb-3">
        <label for="inputEmail" class="form-label">Hoca E-posta</label>
        <input class="form-control @error('email') is-invalid @enderror" id="inputEmail" type="email" name="email" value="{{ old('email') }}" required placeholder="isim@neu.edu.tr" />
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- 3. FAKÜLTE SEÇİMİ (Dinamik) --}}
    <div class="mb-3">
        <label for="faculty_id" class="form-label">Fakülte Seçimi</label>
        <select class="form-select @error('faculty_id') is-invalid @enderror" id="faculty_id" name="faculty_id" required>
            <option value="">Lütfen fakültenizi seçin...</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                    {{ $faculty->name }}
                </option>
            @endforeach
        </select>
        @error('faculty_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- 4. ŞİFRE --}}
    <div class="mb-3">
        <label for="inputPassword" class="form-label">Şifre</label>
        <input class="form-control @error('password') is-invalid @enderror" id="inputPassword" type="password" name="password" required placeholder="En az 8 karakter" />
    </div>
    
    {{-- 5. ŞİFRE ONAYI --}}
    <div class="mb-4">
        <label for="inputPasswordConfirm" class="form-label">Şifreyi Onayla</label>
        <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation" required placeholder="Şifreyi Tekrarla" />
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-danger btn-lg">Hoca Hesabı Oluştur</button>
    </div>
</form>