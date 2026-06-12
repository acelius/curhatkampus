<?php

namespace App\Http\Controllers;

use App\Models\Curhat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CurhatController extends Controller
{
    public function create(): RedirectResponse
    {
        return redirect('/#form-curhat');
    }

    public function index(): View|RedirectResponse
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $curhats = Curhat::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cek-curhatan', compact('curhats'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(Auth::user()->isAdmin(), 403, 'Admin tidak dapat mengirim curhatan.');

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:30'],
            'kategori' => ['required', 'in:Fasilitas,Akademik,Pelayanan,Lainnya'],
            'lokasi' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string', 'min:10'],
            'lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,mp4,mov,doc,docx', 'max:102400'],
            'pernyataan' => ['accepted'],
        ], [
            'pernyataan.accepted' => 'Kamu harus menyetujui pernyataan kebenaran informasi.',
            'lampiran.max' => 'Ukuran lampiran maksimal 100 MB.',
            'lampiran.mimes' => 'Format lampiran harus jpg, jpeg, png, pdf, mp4, mov, doc, atau docx.',
        ]);

        $lampiranPath = null;
        $lampiranOriginalName = null;
        $lampiranMime = null;
        $lampiranSize = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $lampiranPath = $file->store('lampiran-curhat', 'public');
            $lampiranOriginalName = $file->getClientOriginalName();
            $lampiranMime = $file->getClientMimeType();
            $lampiranSize = $file->getSize();
        }

        Curhat::create([
            'kode_curhat' => $this->generateKodeCurhat(),
            'user_id' => Auth::id(),
            'nim' => Auth::user()->nim,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'nomor_hp' => $validated['nomor_hp'],
            'kategori' => $validated['kategori'],
            'lokasi' => $validated['lokasi'],
            'judul' => $validated['judul'],
            'detail' => $validated['detail'],
            'lampiran_path' => $lampiranPath,
            'lampiran_original_name' => $lampiranOriginalName,
            'lampiran_mime' => $lampiranMime,
            'lampiran_size' => $lampiranSize,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('curhat.cek')
            ->with('success', 'Curhatan berhasil dikirim. Status awal: Menunggu.');
    }

    private function generateKodeCurhat(): string
    {
        do {
            $kode = 'CK-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Curhat::where('kode_curhat', $kode)->exists());

        return $kode;
    }
}