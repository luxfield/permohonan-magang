<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\MagangApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MagangStatusController extends Controller
{
    public function index()
    {
        return view('status.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // Bisa NIK atau NIM
            'tgl_lahir' => 'required|date',
        ]);

        // Cari data berdasarkan (NIK atau NIM) DAN Tanggal Lahir
        $application = MagangApplication::where(function ($query) use ($request) {
            $query->where('nik', $request->identifier)
                ->orWhere('nim', $request->identifier);
        })
            ->where('tgl_lahir', $request->tgl_lahir)
            ->orderBy('id', 'desc')
            ->first();

        $intern_user = Intern::where(function ($query) use ($request) {
            $query->Where('nim', $request->identifier);
        })->where('tgl_lahir', $request->tgl_lahir)->orderBy('id', 'desc')->first();

        if (! $application && ! $intern_user) {
            return back()->with('error', 'Data tidak ditemukan. Pastikan NIK/NIM dan Tanggal Lahir sesuai.');
        }

        // Simpan ID ke session untuk verifikasi keamanan saat upload
        session(['verified_magang_id' => $application->id || $intern_user->id]);

        // Tampilkan halaman detail status
        return view('status.show', compact('application'));
    }

    public function uploadForm($id)
    {
        // Validasi session: Pastikan user sudah cek status untuk ID ini
        if (session('verified_magang_id') != $id) {
            return redirect()->route('status.index')->with('error', 'Akses ditolak. Silakan cek status terlebih dahulu.');
        }

        $application = MagangApplication::findOrFail($id);

        // Validasi hanya boleh akses jika status diterima
        if ($application->status !== 'diterima') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('status.upload', compact('application'));
    }

    public function uploadReport(Request $request, $id)
    {
        // Validasi session: Pastikan user sudah cek status untuk ID ini
        if (session('verified_magang_id') != $id) {
            return redirect()->route('status.index')->with('error', 'Akses ditolak. Silakan cek status terlebih dahulu.');
        }

        $application = MagangApplication::findOrFail($id);

        // Validasi hanya boleh upload jika status diterima
        if ($application->status !== 'diterima') {
            abort(403, 'Anda tidak memiliki akses untuk mengunggah laporan.');
        }

        // Validasi waktu upload (H-7 selesai)
        if ($application->tgl_selesai && now()->lessThan($application->tgl_selesai->copy()->subWeek())) {
            return back()->with('error', 'Maaf, periode upload laporan belum dibuka.');
        }

        // Validasi batas waktu (H+7 selesai)
        if ($application->tgl_selesai && now()->greaterThan($application->tgl_selesai->copy()->addWeek())) {
            return back()->with('error', 'Maaf, batas waktu upload laporan telah berakhir.');
        }

        $request->validate([
            'laporan_akhir' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        // Hapus file lama jika ada
        if ($application->laporan_akhir_path && Storage::disk('public')->exists($application->laporan_akhir_path)) {
            Storage::disk('public')->delete($application->laporan_akhir_path);
        }

        $path = $request->file('laporan_akhir')->store('uploads/laporan_akhir', 'public');

        $application->update(['laporan_akhir_path' => $path]);

        return back()->with('success', 'Laporan Tugas Akhir berhasil diunggah.');
    }

    public function uploadKinerjaForm($id)
    {
        // Memastikan peserta sudah login/melewati pengecekan status
        if (session('verified_magang_id') != $id) {
            return redirect()->route('status.index')->with('error', 'Akses ditolak. Silakan cek status terlebih dahulu.');
        }

        $application = MagangApplication::findOrFail($id);

        if ($application->status !== 'diterima') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $kinerjas = \App\Models\MagangKinerja::where('magang_application_id', $id)->latest()->get();

        return view('status.kinerja', compact('application', 'kinerjas'));
    }

    public function uploadKinerja(Request $request, $id)
    {
        if (session('verified_magang_id') != $id) {
            return redirect()->route('status.index')->with('error', 'Akses ditolak. Silakan cek status terlebih dahulu.');
        }

        $application = MagangApplication::findOrFail($id);

        if ($application->status !== 'diterima') {
            abort(403, 'Anda tidak memiliki akses untuk mengunggah laporan kinerja.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_kinerja' => 'required|file|mimes:pdf,jpg,jpeg,png|max:500', // Batas Max 500KB
        ]);

        $path = $request->file('file_kinerja')->store('uploads/kinerja', 'public');

        \App\Models\MagangKinerja::create([
            'magang_application_id' => $application->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Laporan Kinerja Harian berhasil diunggah.');
    }
}
