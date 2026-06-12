<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CurhatKampus</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header-bar font-poppins">
        <nav class="navbar">
            <a href="{{ route('admin.dashboard') }}" class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="logo-text"><b>Curhat</b>Kampus Admin</span>
            </a>

            <div class="nav-right">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-nav-kirim" style="background-color: #ff4757; color: white; border: none; cursor: pointer;">Logout</button>
                </form>
            </div>
        </nav>
    </header>

    <section class="hero-section">
        <div class="main-container" style="display:block; max-width:1200px; margin:0 auto; padding:40px 20px;">
            <div class="form-card font-opensans" style="width:100%;">
                <h2 class="form-header-title">Dashboard Admin</h2>

                @if(session('success'))
                    <div style="color: #155724; background:#d4edda; border:1px solid #c3e6cb; padding:10px; border-radius:8px; font-size:13px; margin-bottom:15px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="color: #721c24; background:#f8d7da; border:1px solid #f5c6cb; padding:10px; border-radius:8px; font-size:13px; margin-bottom:15px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; background:white;">
                        <thead>
                            <tr style="background:#f1f5f9;">
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Kode</th>
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Mahasiswa</th>
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Pengaduan</th>
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Lampiran</th>
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Status</th>
                                <th style="border:1px solid #ddd; padding:10px; text-align:left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($curhats as $curhat)
                                <tr>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top; white-space:nowrap;">
                                        <strong>{{ $curhat->kode_curhat }}</strong><br>
                                        <small>{{ $curhat->created_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top;">
                                        <strong>{{ $curhat->nama_lengkap }}</strong><br>
                                        NIM: {{ $curhat->nim }}<br>
                                        Email: {{ $curhat->email }}<br>
                                        HP: {{ $curhat->nomor_hp }}
                                    </td>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top; min-width:260px;">
                                        <strong>{{ $curhat->judul }}</strong><br>
                                        <small>{{ $curhat->kategori }} • {{ $curhat->lokasi }}</small>
                                        <p style="white-space:pre-line;">{{ $curhat->detail }}</p>
                                    </td>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top;">
                                        @if($curhat->lampiran_path)
                                            <a href="{{ asset('storage/' . $curhat->lampiran_path) }}" target="_blank">Buka Lampiran</a>
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top;">
                                        <strong>{{ $curhat->status }}</strong>
                                        @if($curhat->catatan_admin)
                                            <br><small>{{ $curhat->catatan_admin }}</small>
                                        @endif
                                    </td>
                                    <td style="border:1px solid #ddd; padding:10px; vertical-align:top; min-width:230px;">
                                        <form action="{{ route('admin.curhat.updateStatus', $curhat) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <select name="status" required style="width:100%; margin-bottom:8px;">
                                                <option value="Menunggu" {{ $curhat->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="Diproses" {{ $curhat->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="Selesai" {{ $curhat->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Ditolak" {{ $curhat->status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>

                                            <textarea name="catatan_admin" rows="3" placeholder="Catatan admin" style="width:100%; margin-bottom:8px;">{{ old('catatan_admin', $curhat->catatan_admin) }}</textarea>

                                            <button type="submit" class="btn-login" style="width:100%;">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="border:1px solid #ddd; padding:20px; text-align:center; color:#666;">Belum ada curhatan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>