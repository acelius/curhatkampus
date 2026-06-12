<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CurhatKampus - Isi Pengaduan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>

<body>
    <header class="header-bar font-poppins">
        <nav class="navbar">
            <a href="{{ route('login') }}" class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="logo-text"><b>Curhat</b>Kampus</span>
            </a>

            <div class="nav-right">
                <ul class="nav-links">
                    <li><a href="{{ route('login') }}">Beranda</a></li>
                    <li><a href="#">Cara Curhat</a></li>
                    <li><a href="{{ route('curhat.cek') }}">Cek Curhatan</a></li>
                </ul>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-nav-kirim" style="background-color: #ff4757; color: white; border: none; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <section class="hero-section">
        <div class="main-container">
            <div style="position: relative; flex: 1;">
                <img src="{{ asset('images/buble.png') }}" alt="Bubble Chat" class="bubble-img font-poppins">
                <img src="{{ asset('images/karakter.png') }}" alt="Karakter Mahasiswa" class="karakter-img">
            </div>

            <div style="flex: 2; z-index: 20; display: flex; justify-content: flex-end;">
                <div class="form-card font-opensans">
                    <h2 class="form-header-title">Curhatin Aja</h2>

                    @if(session('success'))
                        <div style="color: #155724; background:#d4edda; border:1px solid #c3e6cb; padding:10px; border-radius:8px; font-size:13px; margin-bottom:15px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="color: #721c24; background:#f8d7da; border:1px solid #f5c6cb; padding:10px; border-radius:8px; font-size:13px; margin-bottom:15px;">
                            <ul style="margin:0; padding-left:18px;">
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
                                <label>Nomor Induk Mahasiswa</label>
                                <input
                                    type="text"
                                    name="nim"
                                    value="{{ Auth::user() ? Auth::user()->nim : '' }}"
                                    readonly
                                    style="background-color: #eee; color: #888;"
                                >
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', Auth::user() ? Auth::user()->name : '') }}"
                                    placeholder="Masukkan Nama Lengkap"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', Auth::user() ? Auth::user()->email : '') }}"
                                    placeholder="email@example.com"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input
                                    type="text"
                                    name="nomor_hp"
                                    value="{{ old('nomor_hp') }}"
                                    placeholder="0888xxxxxxxx"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Kategori Pengaduan</label>
                                <select name="kategori" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
                                    <option value="Fasilitas" {{ old('kategori') === 'Fasilitas' ? 'selected' : '' }}>Fasilitas Kampus</option>
                                    <option value="Akademik" {{ old('kategori') === 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                    <option value="Pelayanan" {{ old('kategori') === 'Pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                    <option value="Lainnya" {{ old('kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lokasi Kejadian</label>
                                <input
                                    type="text"
                                    name="lokasi"
                                    value="{{ old('lokasi') }}"
                                    placeholder="Masukkan Lokasi Kejadian"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Judul Pengaduan</label>
                            <input
                                type="text"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Ringkasan Pengaduan Anda"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Detail Pengaduan</label>
                            <textarea
                                name="detail"
                                placeholder="Jelaskan kronologi dan detail pengaduan"
                                required
                            >{{ old('detail') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Lampiran Bukti</label>

                            <div class="file-upload-wrapper">
                                <label for="file-upload" class="file-upload-btn">Choose Files</label>
                                <span class="file-upload-text" id="file-name">No File Chosen</span>
                                <input
                                    type="file"
                                    id="file-upload"
                                    name="lampiran"
                                    accept="image/*,video/*,.pdf,.doc,.docx"
                                >
                            </div>

                            <span class="file-hint">Unggah foto, video, atau dokumen. Maksimal 100 MB.</span>
                        </div>

                        <label class="checkbox-group">
                            <input
                                type="checkbox"
                                name="pernyataan"
                                value="1"
                                required
                                {{ old('pernyataan') ? 'checked' : '' }}
                            >
                            Saya menyatakan bahwa informasi yang diberikan adalah benar
                        </label>

                        <button type="submit" class="btn-submit-curhat font-poppins">
                            <img src="{{ asset('images/pesawat.png') }}" alt="Kirim">
                            Kirim Curhatan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const fileInput = document.getElementById('file-upload');
        const fileNameText = document.getElementById('file-name');

        fileInput.addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No File Chosen';
            fileNameText.textContent = fileName;
        });
    </script>
</body>
</html>