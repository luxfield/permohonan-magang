<?php

namespace App\Http\Controllers;

use App\Models\MagangApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SampleRegisterController extends Controller
{
    public function index()
    {
        return view('sample-register');
    }

    public function store(Request $request)
    {
        // Validasi Dasar
        $rules = [
            'statusPengajuan' => 'required|in:mandiri,institusi',
            'nama' => 'required|string|max:255',
            'kontakHp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'nik' => 'required|string|min:16',
            'tglLahir' => 'required|date|before_or_equal:-17 years',
            'alamat' => 'required|string',
            'tglMulai' => 'required|date',
            // Logika durasi bisa ditambahkan di custom rule jika perlu
            'tglSelesai' => 'required|date|after:tglMulai',
            'tujuan' => 'required|string',
            'pernyataan' => 'required|accepted',
        ];

        // Validasi Tambahan Berdasarkan Jalur
        if ($request->statusPengajuan === 'mandiri') {
            $rules = array_merge($rules, [
                'suratMandiri' => 'required|file|mimes:pdf|max:10240',
                'ktpMandiri' => 'required|file|mimes:jpg,jpeg,png|max:10240',
                'fotoMandiri' => 'required|file|mimes:jpg,jpeg,png|max:10240',
            ]);
        } else {
            $rules = array_merge($rules, [
                'institusi' => 'required|string',
                'nim' => 'required|string',
                'fakultas' => 'required|string',
                'semester' => 'required|string',
                'pembimbing' => 'required|string',
                'kontakPembimbing' => 'required|string',
                'jumlahPeserta' => 'required|integer',
                'suratPengantar' => 'required|file|mimes:pdf|max:10240',
                'transkrip' => 'required|file|mimes:pdf|max:10240',
                'fotoInstitusi' => 'required|file|mimes:jpg,jpeg,png|max:10240',
            ]);
        }

        // Validasi Durasi Minimal 1 Bulan (Manual Check untuk presisi)
        $request->validate($rules);
        
        $start = \Carbon\Carbon::parse($request->tglMulai);
        $end = \Carbon\Carbon::parse($request->tglSelesai);
        if ($end->diffInMonths($start) < 1 && $end->diffInDays($start) < 30) {
             return back()->withErrors(['tglSelesai' => 'Durasi magang minimal 1 bulan.'])->withInput();
        }

        // Upload Files
        $paths = [];
        if ($request->hasFile('suratMandiri')) $paths['surat_permohonan_path'] = $request->file('suratMandiri')->store('uploads/surat', 'public');
        if ($request->hasFile('ktpMandiri')) $paths['ktp_path'] = $request->file('ktpMandiri')->store('uploads/ktp', 'public');
        if ($request->hasFile('fotoMandiri')) $paths['foto_path'] = $request->file('fotoMandiri')->store('uploads/foto', 'public');
        if ($request->hasFile('suratPengantar')) $paths['surat_pengantar_path'] = $request->file('suratPengantar')->store('uploads/surat', 'public');
        if ($request->hasFile('transkrip')) $paths['transkrip_path'] = $request->file('transkrip')->store('uploads/transkrip', 'public');
        if ($request->hasFile('fotoInstitusi')) $paths['foto_path'] = $request->file('fotoInstitusi')->store('uploads/foto', 'public');
        if ($request->hasFile('proposal')) $paths['proposal_path'] = $request->file('proposal')->store('uploads/proposal', 'public');

        // Simpan Data
        MagangApplication::create(array_merge([
            'status_pengajuan' => $request->statusPengajuan,
            'nama' => $request->nama,
            'no_hp' => $request->kontakHp,
            'email' => $request->email,
            'nik' => $request->nik,
            'tgl_lahir' => $request->tglLahir,
            'alamat' => $request->alamat,
            'tgl_mulai' => $request->tglMulai,
            'tgl_selesai' => $request->tglSelesai,
            'tujuan' => $request->tujuan,
            'bidang' => [], // Default kosong
            
            // Mandiri
            'pendidikan_asal' => $request->pendidikanAsal_m,
            'prodi' => $request->prodi_m,

            // Institusi
            'institusi' => $request->institusi,
            'nim' => $request->nim,
            'fakultas' => $request->fakultas,
            'semester' => $request->semester,
            'pembimbing' => $request->pembimbing,
            'kontak_pembimbing' => $request->kontakPembimbing,
            'jumlah_peserta' => $request->jumlahPeserta,
        ], $paths));

        return redirect()->route('sample.register.index')->with('success', 'Pendaftaran berhasil dikirim!');
    }
}