<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Curhatan - CurhatKampus</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>
    @include('partials.navbar')

    <section class="page-section font-opensans">
        <div class="page-container">
            <div class="page-card">
                <h2 class="page-title">Riwayat Curhatan Saya</h2>

                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($curhats as $curhat)
                    <div class="curhat-item">
                        <div class="curhat-item-header">
                            <div>
                                <strong>{{ $curhat->kode_curhat }}</strong>
                                <h3>{{ $curhat->judul }}</h3>
                                <p>
                                    {{ $curhat->kategori }} • {{ $curhat->lokasi }} •
                                    {{ $curhat->created_at->format('d M Y H:i') }}
                                </p>
                            </div>

                            <div>
                                <span class="status-badge status-{{ strtolower($curhat->status) }}">
                                    {{ $curhat->status }}
                                </span>
                            </div>
                        </div>

                        <p class="curhat-detail">{{ $curhat->detail }}</p>

                        @if($curhat->catatan_admin)
                            <div class="admin-note">
                                <strong>Catatan Admin:</strong><br>
                                {{ $curhat->catatan_admin }}
                            </div>
                        @endif

                        @if($curhat->lampiran_path)
                            <p class="lampiran-link">
                                <a href="{{ asset('storage/' . $curhat->lampiran_path) }}" target="_blank">
                                    Lihat lampiran: {{ $curhat->lampiran_original_name }}
                                </a>
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="empty-text">
                        Belum ada curhatan yang kamu kirim.
                    </p>
                @endforelse
            </div>
        </div>
    </section>
</body>
</html>