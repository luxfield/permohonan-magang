<?php

namespace App\Http\Controllers;

use App\Models\MagangApplication;
use Illuminate\Http\Request;

class MagangRegisterController extends Controller
{
    public function index()
    {
        return view('sample-register');
    }
    public function store(Request $request)
    {
        // 1. Aturan Validasi Dasar (Berlaku untuk semua)
        $rules = [
            'statusPengajuan' => 'required|in:mandiri,institusi,kejuruan',
            'nama'            => 'required_if:statusPengajuan,mandiri|nullable|string|max:255',
            'kontakHp'        => 'required_if:statusPengajuan,mandiri|nullable|string|max:20',
            'email'           => 'required_if:statusPengajuan,mandiri|nullable|email|max:255',
            'nik'             => 'required_if:statusPengajuan,mandiri|nullable|numeric',
            'tglLahir'        => 'required_if:statusPengajuan,mandiri|nullable|date|before_or_equal:-17 years',
            'alamat'          => 'required_if:statusPengajuan,mandiri|nullable|string',
            'tglMulai'        => 'required|date|after_or_equal:today',
            'tglSelesai'      => [
                'required',
                'date',
                'after_or_equal:tglMulai',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->tglMulai && (new \Carbon\Carbon($value))->lt((new \Carbon\Carbon($request->tglMulai))->addMonth())) {
                        $fail('Tanggal selesai minimal 1 bulan dari tanggal mulai.');
                    }
                }
            ],
            'tujuan'          => 'required|string',
            'pernyataan'      => 'accepted',
        ];

        // 2. Aturan Tambahan Berdasarkan Status Pengajuan
        if ($request->statusPengajuan === 'mandiri') {
            $rules = array_merge($rules, [
                'pendidikanAsal_m' => 'nullable|string|max:255',
                'prodi_m'          => 'nullable|string|max:255',
                
                // Validasi File Mandiri (Max 10MB = 10240 KB)
                'suratMandiri'     => 'required|file|mimes:pdf|max:10240',
                'ktpMandiri'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'fotoMandiri'      => 'required|file|mimes:jpg,jpeg,png|max:10240',
            ]);
        } elseif ($request->statusPengajuan === 'institusi' || $request->statusPengajuan === 'kejuruan') {
            $rules = array_merge($rules, [
                'institusi'        => 'required|string|max:255',
                'fakultas'         => 'required|string|max:255',
                'semester'         => 'required|string|max:50',
                'pembimbing'       => 'required|string|max:255',
                'kontakPembimbing' => 'required|string|max:255',
                'jumlahPeserta'    => 'required|string',
                
                // Validasi File Institusi (Max 10MB = 10240 KB)
                'suratPengantar'   => 'required|file|mimes:pdf|max:10240',
                'proposal'         => 'nullable|file|mimes:pdf|max:10240',
            ]);
        }

        // 3. Jalankan Validasi
        $validated = $request->validate($rules);

        // 4. Proses Upload File & Mapping Data
        $data = [
            'status_pengajuan' => $request->statusPengajuan,
            'nama'             => $request->nama ?? '-',
            'no_hp'            => $request->kontakHp ?? '-',
            'email'            => $request->email ?? '-',
            'nik'              => $request->nik ?? '-',
            'tgl_lahir'        => $request->tglLahir ?? now()->format('Y-m-d'), // Simpan ke database
            'alamat'           => $request->alamat ?? '-',
            'tgl_mulai'        => $request->tglMulai,
            'tgl_selesai'      => $request->tglSelesai,
            'tujuan'           => $request->tujuan,
        ];

        if ($request->statusPengajuan === 'mandiri') {
            $data['pendidikan_asal'] = $request->pendidikanAsal_m;
            $data['prodi'] = $request->prodi_m;
            
            // Upload Files Mandiri
            if($request->hasFile('suratMandiri')) $data['surat_permohonan_path'] = $request->file('suratMandiri')->store('uploads/surat', 'public');
            if($request->hasFile('ktpMandiri')) $data['ktp_path'] = $request->file('ktpMandiri')->store('uploads/ktp', 'public');
            if($request->hasFile('fotoMandiri')) $data['foto_path'] = $request->file('fotoMandiri')->store('uploads/foto', 'public');

        } elseif ($request->statusPengajuan === 'institusi' || $request->statusPengajuan === 'kejuruan') {
            $data['institusi'] = $request->institusi;
            $data['nim'] = $request->nim ?? '-';
            $data['fakultas'] = $request->fakultas;
            $data['semester'] = $request->semester;
            $data['pembimbing'] = $request->pembimbing;
            $data['kontak_pembimbing'] = $request->kontakPembimbing;
            $data['jumlah_peserta'] = $request->jumlahPeserta;

            // Upload Files Institusi
            if($request->hasFile('suratPengantar')) $data['surat_pengantar_path'] = $request->file('suratPengantar')->store('uploads/surat', 'public');
            if($request->hasFile('proposal')) $data['proposal_path'] = $request->file('proposal')->store('uploads/proposal', 'public');
        }

        MagangApplication::create($data);

        // 5. Redirect Kembali dengan Pesan Sukses
        return back()->with('success', 'Pengajuan berhasil dikirim');
    }
}