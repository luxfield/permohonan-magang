<?php

namespace App\Http\Controllers;

use App\Models\MagangApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data terbaru, 10 per halaman
        $applications = MagangApplication::latest()->paginate(10);
        return view('admin.dashboard', compact('applications'));
    }

    public function show($id)
    {
        $application = MagangApplication::findOrFail($id);
        return view('admin.show', compact('application'));
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

    public function destroy($id)
    {
        $app = MagangApplication::findOrFail($id);

        // Hapus file-file terkait
        $files = [
            $app->surat_permohonan_path, $app->ktp_path, 
            $app->foto_path, $app->surat_pengantar_path,
            $app->transkrip_path, $app->proposal_path
        ];

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $app->delete();

        return back()->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function previewFile(Request $request)
    {
        $path = $request->query('path');

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);
        
        // Paksa mime type menjadi application/pdf agar browser mau menampilkan preview
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimeType = strtolower($extension) === 'pdf' ? 'application/pdf' : Storage::disk('public')->mimeType($path);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }
}