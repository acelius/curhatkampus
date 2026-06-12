<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - CurhatKampus</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>
    @include('partials.navbar')

    <section class="hero-section">
        <div class="main-container">
            <img src="{{ asset('images/karakter.png') }}" alt="Karakter Mahasiswa" class="karakter-img">

            <div class="left-section">
                <div class="hero-text">
                    <h1 class="font-roboto">Jangan Dipendam,<br>Spill Aja Di Sini!</h1>
                    <p class="font-poppins">
                        Fasilitas ngadat atau ada masalah akademik yang bikin pusing?
                        Laporin keluh kesahmu dengan aman, gampang, dan pantau prosesnya secara real-time.
                    </p>

                    <div class="hero-buttons font-poppins">
                        <a href="{{ route('login') }}#login-card" class="btn-kirim">
                            Kirim Curhatan
                        </a>
                        <a href="#cara-curhat" class="btn-cara">
                            Cara Kirim Curhatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="right-section font-opensans">
                <div class="login-card" id="register-card">
                    <div class="login-header">
                        <h2>Daftar Akun</h2>
                        <div class="login-role">
                            Mahasiswa
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nim">Nomor Induk Mahasiswa</label>
                                <input
                                    type="text"
                                    id="nim"
                                    name="nim"
                                    value="{{ old('nim') }}"
                                    placeholder="Masukkan NIM"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="email@example.com"
                                required
                            >
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn-login">
                            Daftar
                        </button>
                    </form>

                    <div class="register-link">
                        Sudah punya akun? <a href="{{ route('login') }}">Login Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-curhat" class="info-section font-poppins">
        <h2 class="info-title">Cara Curhat</h2>

        <div class="cara-curhat-wrapper">
            <div class="cara-card">
                <h3>1. Login Akun</h3>
                <p>Masuk menggunakan Nomor Induk Mahasiswa dan password yang sudah terdaftar.</p>
            </div>

            <div class="cara-card">
                <h3>2. Isi Form Curhatan</h3>
                <p>Tulis kategori, lokasi, judul, dan detail pengaduan secara jelas.</p>
            </div>

            <div class="cara-card">
                <h3>3. Unggah Bukti</h3>
                <p>Tambahkan foto, video, atau dokumen pendukung jika tersedia.</p>
            </div>

            <div class="cara-card">
                <h3>4. Pantau Status</h3>
                <p>Cek perkembangan curhatan melalui menu Cek Curhatan.</p>
            </div>
        </div>
    </section>
</body>
</html>