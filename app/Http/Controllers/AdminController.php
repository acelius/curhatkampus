<?php

namespace App\Http\Controllers;

use App\Models\Curhat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $this->ensureAdmin();

        $curhats = Curhat::with('user')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('curhats'));
    }

    public function updateStatus(Request $request, Curhat $curhat): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'status' => ['required', 'in:Menunggu,Diproses,Selesai,Ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $curhat->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        return back()->with('success', 'Status curhatan berhasil diperbarui.');
    }

    private function ensureAdmin(): void
    {
        abort_if(! Auth::check() || ! Auth::user()->isAdmin(), 403, 'Akses hanya untuk admin.');
    }
}