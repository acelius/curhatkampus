<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CurhatKampus - Website Pengaduan Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>
    @php
        try {
            $totalPengaduan = \App\Models\Curhat::count();
            $dalamProses = \App\Models\Curhat::whereIn('status', ['Menunggu', 'Diproses'])->count();
            $selesai = \App\Models\Curhat::where('status', 'Selesai')->count();
            $userTerdaftar = \App\Models\User::where('role', 'mahasiswa')->count();
        } catch (\Throwable $e) {
            $totalPengaduan = 0;
            $dalamProses = 0;
            $selesai = 0;
            $userTerdaftar = 0;
        }
    @endphp

    @include('partials.navbar')

    @guest
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
                            <a href="#login-card" class="btn-kirim login-required-trigger">
                                Kirim Curhatan
                            </a>

                            <a href="#cara-curhat" class="btn-cara">
                                Cara Kirim Curhatan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="right-section font-opensans">
                    <div class="login-card" id="login-card">
                        <div class="login-required-alert" id="login-required-alert">
                            Silakan login terlebih dahulu untuk mengirim curhatan.
                        </div>

                        <div class="login-header">
                            <h2>Login Curhatan</h2>
                            <div class="login-role">
                                <span id="tab-mahasiswa" class="active">Mahasiswa</span> |
                                <span id="tab-admin">Admin</span>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert-error">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div id="form-mahasiswa">
                            <form action="{{ route('login.process') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="nim">Nomor Induk Mahasiswa</label>
                                    <input
                                        type="text"
                                        id="nim"
                                        name="nim"
                                        value="{{ old('nim') }}"
                                        placeholder="Masukkan Nomor Induk Mahasiswa"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Masukkan Password"
                                        required
                                    >
                                </div>

                                <div class="form-options">
                                    <label>
                                        <input type="checkbox" name="remember" value="1">
                                        Ingat saya
                                    </label>
                                    <a href="#">Lupa Password?</a>
                                </div>

                                <button type="submit" class="btn-login">Login</button>
                            </form>

                            <div class="register-link">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                            </div>
                        </div>

                        <div id="form-admin" style="display: none;">
                            <form action="{{ route('admin.login.process') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="id_admin">ID Admin</label>
                                    <input
                                        type="text"
                                        id="id_admin"
                                        name="id_admin"
                                        value="{{ old('id_admin') }}"
                                        placeholder="Masukkan ID Admin"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="password_admin">Password</label>
                                    <input
                                        type="password"
                                        id="password_admin"
                                        name="password_admin"
                                        placeholder="Masukkan Password"
                                        required
                                    >
                                </div>

                                <button type="submit" class="btn-login" style="margin-top: 30px;">
                                    Login Admin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endguest

    @auth
        <section class="hero-section auth-curhat-section">
            <div class="main-container auth-curhat-container">
                <div class="auth-curhat-character">
                    <img src="{{ asset('images/buble.png') }}" alt="Bubble Chat" class="auth-bubble-img">
                    <img src="{{ asset('images/karakter.png') }}" alt="Karakter Mahasiswa" class="auth-karakter-img">
                </div>

                <div class="auth-form-board font-opensans" id="form-curhat">
                    <h2 class="auth-form-title">Curhatin Aja</h2>

                    @if(session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('curhat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nim_curhat">Nomor Induk Mahasiswa</label>
                                <input
                                    type="text"
                                    id="nim_curhat"
                                    name="nim"
                                    value="{{ Auth::user()->nim }}"
                                    readonly
                                    class="readonly-input"
                                >
                            </div>

                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="nama_lengkap"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', Auth::user()->name) }}"
                                    placeholder="Masukkan Nama Lengkap"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    placeholder="email@example.com"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="nomor_hp">Nomor Handphone</label>
                                <input
                                    type="text"
                                    id="nomor_hp"
                                    name="nomor_hp"
                                    value="{{ old('nomor_hp') }}"
                                    placeholder="0888xxxxxxxx"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="kategori">Kategori Pengaduan</label>
                                <select id="kategori" name="kategori" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>
                                        Pilih Kategori
                                    </option>
                                    <option value="Fasilitas" {{ old('kategori') === 'Fasilitas' ? 'selected' : '' }}>
                                        Fasilitas Kampus
                                    </option>
                                    <option value="Akademik" {{ old('kategori') === 'Akademik' ? 'selected' : '' }}>
                                        Akademik
                                    </option>
                                    <option value="Pelayanan" {{ old('kategori') === 'Pelayanan' ? 'selected' : '' }}>
                                        Pelayanan
                                    </option>
                                    <option value="Lainnya" {{ old('kategori') === 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="lokasi">Lokasi Kejadian</label>
                                <input
                                    type="text"
                                    id="lokasi"
                                    name="lokasi"
                                    value="{{ old('lokasi') }}"
                                    placeholder="Masukkan Lokasi Kejadian"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="judul">Judul Pengaduan</label>
                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Ringkasan Pengaduan Anda"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="detail">Detail Pengaduan</label>
                            <textarea
                                id="detail"
                                name="detail"
                                placeholder="Jelaskan kronologi dan detail pengaduan"
                                required
                            >{{ old('detail') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="file-upload">Lampiran Bukti</label>

                            <div class="file-upload-wrapper">
                                <label for="file-upload" class="file-upload-btn">
                                    Choose Files
                                </label>

                                <span class="file-upload-text" id="file-name">
                                    No File Chosen
                                </span>

                                <input
                                    type="file"
                                    id="file-upload"
                                    name="lampiran"
                                    accept="image/*,video/*,.pdf,.doc,.docx"
                                >
                            </div>

                            <span class="file-hint">
                                Unggah foto, video, atau dokumen. Maksimal 100 MB.
                            </span>
                        </div>

                        <label class="checkbox-group">
                            <input
                                type="checkbox"
                                name="pernyataan"
                                value="1"
                                required
                                {{ old('pernyataan') ? 'checked' : '' }}
                            >
                            <span>Saya menyatakan bahwa informasi yang diberikan adalah benar.</span>
                        </label>

                        <button type="submit" class="btn-submit-curhat font-poppins">
                            <img src="{{ asset('images/pesawat.png') }}" alt="Kirim">
                            Kirim Curhatan
                        </button>
                    </form>
                </div>
            </div>
        </section>
    @endauth

    <section class="home-lower-section">
        <div class="home-lower-container">
            <div class="cara-section" id="cara-curhat">
                <h2 class="cara-title">Alur Pengaduan</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M6 2h8l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm7 1.5V8h4.5L13 3.5zM8 12h8v1.8H8V12zm0 3.5h8v1.8H8v-1.8zm0-7h4v1.8H8V8.5z"/>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $totalPengaduan }}">0</div>
                    <p class="stat-label">Total Pengaduan</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <svg width="28" height="28" viewBox="0 0 50 50" fill="none" aria-hidden="true">
                            <circle cx="25" cy="8" r="3.5" fill="currentColor"/>
                            <circle cx="34.5" cy="12" r="3.5" fill="currentColor" opacity="0.95"/>
                            <circle cx="40.5" cy="20" r="3.5" fill="currentColor" opacity="0.9"/>
                            <circle cx="40.5" cy="30" r="3.5" fill="currentColor" opacity="0.8"/>
                            <circle cx="34.5" cy="38" r="3.5" fill="currentColor" opacity="0.7"/>
                            <circle cx="25" cy="42" r="3.5" fill="currentColor" opacity="0.6"/>
                            <circle cx="15.5" cy="38" r="3.5" fill="currentColor" opacity="0.5"/>
                            <circle cx="9.5" cy="30" r="3.5" fill="currentColor" opacity="0.4"/>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $dalamProses }}">0</div>
                    <p class="stat-label">Dalam Proses</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" fill="currentColor"/>
                            <path d="M8 12.2l2.6 2.6L16.5 9" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $selesai }}">0</div>
                    <p class="stat-label">Selesai</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon cyan">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <div class="stat-number" data-target="{{ $userTerdaftar }}">0</div>
                    <p class="stat-label">User Terdaftar</p>
                </div>
            </div>

            <div class="cara-section">
                <h2 class="cara-title">Cara Mengirim Curhatan</h2>
                <p class="cara-description">
                    Sampaikan keluhan atau pengaduan kampus dengan alur yang sederhana, aman, dan mudah dipantau.
                    Ikuti empat langkah berikut agar curhatanmu dapat diproses dengan baik.
                </p>

                <div class="cara-steps-grid">
                    <div class="cara-step-card">
                        <div class="step-number">1</div>
                        <h3>Login Akun</h3>
                        <p>Masuk menggunakan NIM dan password agar identitas pengaduan tercatat dengan jelas.</p>
                    </div>

                    <div class="cara-step-card">
                        <div class="step-number">2</div>
                        <h3>Isi Formulir</h3>
                        <p>Lengkapi kategori, lokasi, judul, dan detail kronologi pengaduan secara ringkas.</p>
                    </div>

                    <div class="cara-step-card">
                        <div class="step-number">3</div>
                        <h3>Unggah Bukti</h3>
                        <p>Tambahkan foto, video, atau dokumen pendukung agar pengaduan lebih kuat.</p>
                    </div>

                    <div class="cara-step-card">
                        <div class="step-number">4</div>
                        <h3>Kirim & Pantau</h3>
                        <p>Kirim curhatanmu, lalu cek perkembangan status melalui menu Cek Curhatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @guest
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabMahasiswa = document.getElementById('tab-mahasiswa');
                const tabAdmin = document.getElementById('tab-admin');
                const formMahasiswa = document.getElementById('form-mahasiswa');
                const formAdmin = document.getElementById('form-admin');

                if (tabMahasiswa && tabAdmin && formMahasiswa && formAdmin) {
                    tabMahasiswa.addEventListener('click', function () {
                        tabMahasiswa.classList.add('active');
                        tabAdmin.classList.remove('active');
                        formMahasiswa.style.display = 'block';
                        formAdmin.style.display = 'none';
                    });

                    tabAdmin.addEventListener('click', function () {
                        tabAdmin.classList.add('active');
                        tabMahasiswa.classList.remove('active');
                        formAdmin.style.display = 'block';
                        formMahasiswa.style.display = 'none';
                    });
                }

                const loginCard = document.getElementById('login-card');
                const loginAlert = document.getElementById('login-required-alert');
                const loginRequiredLinks = document.querySelectorAll(
                    'a[href*="#login-card"], a[href*="login_required=1"]'
                );

                let alertTimeout = null;

                function showLoginRequiredEffect() {
                    if (!loginCard) return;

                    loginCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    if (loginAlert) {
                        loginAlert.classList.add('show');

                        if (alertTimeout) {
                            clearTimeout(alertTimeout);
                        }

                        alertTimeout = setTimeout(function () {
                            loginAlert.classList.remove('show');
                        }, 3500);
                    }

                    loginCard.classList.remove('login-attention');
                    void loginCard.offsetWidth;
                    loginCard.classList.add('login-attention');

                    setTimeout(function () {
                        loginCard.classList.remove('login-attention');
                    }, 950);
                }

                loginRequiredLinks.forEach(function (link) {
                    link.addEventListener('click', function (event) {
                        const targetUrl = new URL(link.href, window.location.origin);
                        const currentUrl = new URL(window.location.href);

                        if (targetUrl.pathname === currentUrl.pathname) {
                            event.preventDefault();

                            if (window.location.hash !== '#login-card') {
                                history.pushState(null, '', '#login-card');
                            }

                            showLoginRequiredEffect();
                        }
                    });
                });
            });
        </script>
    @endguest

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fileUpload = document.getElementById('file-upload');
                const fileName = document.getElementById('file-name');

                if (fileUpload && fileName) {
                    fileUpload.addEventListener('change', function () {
                        fileName.textContent = this.files[0] ? this.files[0].name : 'No File Chosen';
                    });
                }
            });
        </script>
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const counters = document.querySelectorAll('.stat-number');

            function animateCounter(counter) {
                const target = parseInt(counter.getAttribute('data-target')) || 0;
                const duration = 900;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const value = Math.floor(progress * target);

                    counter.textContent = value.toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString('id-ID');
                    }
                }

                requestAnimationFrame(updateCounter);
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries, obs) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            animateCounter(entry.target);
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.45
                });

                counters.forEach(function (counter) {
                    observer.observe(counter);
                });
            } else {
                counters.forEach(animateCounter);
            }
        });
    </script>
</body>
</html>