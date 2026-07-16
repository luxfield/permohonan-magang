<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\MagangApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data terbaru, 10 per halaman
        $applications = MagangApplication::latest()->paginate(10);
        $registrationOpen = \App\Models\Setting::getByKey('registration_status', 'open') === 'open';
        $registrationClosedMessage = \App\Models\Setting::getByKey('registration_closed_message', '');

        return view('admin.dashboard', compact('applications', 'registrationOpen', 'registrationClosedMessage'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'registration_status' => 'required|in:open,closed',
            'registration_closed_message' => 'required_if:registration_status,closed|nullable|string',
        ]);

        \App\Models\Setting::setByKey('registration_status', $request->registration_status);
        \App\Models\Setting::setByKey('registration_closed_message', $request->registration_closed_message);

        return redirect()->route('admin.dashboard')->with('success', 'Pengaturan pendaftaran berhasil diperbarui.');
    }

    public function show(Request $request, $id)
    {
        $application = MagangApplication::with('interns.user')->findOrFail($id);

        $query = \App\Models\MagangKinerja::where('magang_application_id', $id);
        if ($request->has('intern_id') && $request->intern_id != '') {
            $query->where('intern_id', $request->intern_id);
        }
        $kinerjas = $query->latest()->get();

        return view('admin.show', compact('application', 'kinerjas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $application = MagangApplication::findOrFail($id);

        $application->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.show', $id)->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function addIntern(Request $request, $id)
    {
        $application = MagangApplication::findOrFail($id);

        // 1. Validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nim' => 'nullable|string|max:255',
            'tgl_lahir' => 'required|date',
        ]);

        // 2. Cek kuota peserta
        if ($application->interns()->count() >= $application->jumlah_peserta) {
            return back()->with('error', 'Jumlah peserta sudah mencapai kuota maksimal.');
        }

        // 3. Gunakan transaction untuk memastikan data konsisten
        $defaultPassword = 'password';
        try {
            DB::transaction(function () use ($application, $validated, $defaultPassword) {
                // Buat Akun User baru
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($defaultPassword),
                ]);

                // Buat data Intern
                $application->interns()->create([
                    'user_id' => $user->id,
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'nim' => $validated['nim'],
                    'tgl_lahir' => $validated['tgl_lahir'],
                ]);
            });
        } catch (\Throwable $e) {
            // Jika terjadi error, kembalikan dengan pesan error
            return back()->with('error', 'Gagal membuat akun peserta. Silakan coba lagi.');
        }

        return back()->with('success', "Akun untuk {$validated['nama']} berhasil dibuat. Password default: '{$defaultPassword}'");
    }

    public function updateIntern(Request $request, $id)
    {
        $intern = Intern::findOrFail($id);
        $user = User::findOrFail($intern->user_id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            // Abaikan validasi unique untuk email milik user itu sendiri
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'nim' => 'nullable|string|max:255',
            'tgl_lahir' => 'required|date',
        ]);

        DB::transaction(function () use ($intern, $user, $validated) {
            $user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ]);
            $intern->update($validated);
        });

        return back()->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function deleteIntern($id)
    {
        $intern = Intern::findOrFail($id);
        $userId = $intern->user_id;

        DB::transaction(function () use ($intern, $userId) {
            $intern->delete(); // Hapus data magang
            User::where('id', $userId)->delete(); // Hapus akun login
        });

        return back()->with('success', 'Data peserta dan akun terkait berhasil dihapus.');
    }

    public function destroy($id)
    {
        $app = MagangApplication::with('interns')->findOrFail($id);

        DB::transaction(function () use ($app) {
            // Hapus file-file terkait
            $files = [
                $app->surat_permohonan_path, $app->ktp_path,
                $app->foto_path, $app->surat_pengantar_path,
                $app->transkrip_path, $app->proposal_path,
                $app->laporan_akhir_path,
            ];

            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Dapatkan ID user sebelum menghapus aplikasi
            $userIds = $app->interns->pluck('user_id');

            // Hapus aplikasi (akan meng-cascade ke tabel interns)
            $app->delete();

            // Hapus user yang terkait
            if ($userIds->isNotEmpty()) {
                User::whereIn('id', $userIds)->delete();
            }
        });

        return redirect()->route('admin.dashboard')->with('success', 'Data pendaftar dan akun peserta terkait berhasil dihapus.');
    }

    public function updateKinerja(Request $request, $id)
    {
        $kinerja = \App\Models\MagangKinerja::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'komentar_admin' => 'nullable|string',
        ]);

        $kinerja->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'komentar_admin' => $request->komentar_admin,
        ]);

        return back()->with('success', 'Laporan kinerja berhasil diperbarui.');
    }

    public function deleteKinerja($id)
    {
        $kinerja = \App\Models\MagangKinerja::findOrFail($id);

        if ($kinerja->file_path && Storage::disk('public')->exists($kinerja->file_path)) {
            Storage::disk('public')->delete($kinerja->file_path);
        }

        $kinerja->delete();

        return back()->with('success', 'Laporan kinerja berhasil dihapus.');
    }

    public function updateApplicationDetails(Request $request, $id)
    {
        $application = MagangApplication::findOrFail($id);

        $rules = [
            'no_hp' => 'required|string|min:10|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ];

        if ($application->status_pengajuan === 'mandiri') {
            $rules = array_merge($rules, [
                'nama' => 'required|string|max:255',
                'nik' => 'required|numeric',
                'tgl_lahir' => 'required|date',
                'pendidikan_asal' => 'nullable|string|max:255',
                'prodi' => 'nullable|string|max:255',
            ]);
        } else {
            $rules = array_merge($rules, [
                'institusi' => 'required|string|max:255',
                'fakultas' => 'required|string|max:255',
                'semester' => 'required|string|max:50',
                'pembimbing' => 'required|string|max:255',
                'kontak_pembimbing' => 'required|string|max:255',
                'jumlah_peserta' => 'required|integer',
            ]);
        }

        $messages = [
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.min' => 'Nomor HP minimal 10 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 15 karakter.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ];

        $validated = $request->validate($rules, $messages);

        $application->update($validated);

        return redirect()->route('admin.show', $id)->with('success', 'Data utama pemohon berhasil diperbarui.');
    }

    public function previewFile(Request $request)
    {
        $path = $request->query('path');

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);

        // Paksa mime type menjadi application/pdf agar browser mau menampilkan preview
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimeType = strtolower($extension) === 'pdf' ? 'application/pdf' : Storage::disk('public')->mimeType($path);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }
}
