<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\MagangApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MagangRegisterController extends Controller
{
    public function index()
    {
        if (\App\Models\Setting::getByKey('registration_status', 'open') !== 'open') {
            return redirect()->route('home')->with('error', 'Pendaftaran magang saat ini sedang ditutup.');
        }

        return view('sample-register');
    }

    public function store(Request $request): RedirectResponse
    {
        if (\App\Models\Setting::getByKey('registration_status', 'open') !== 'open') {
            return redirect()->route('home')->with('error', 'Pendaftaran magang saat ini sedang ditutup.');
        }

        // 1. Aturan Validasi Dasar (Berlaku untuk semua)
        $rules = [
            'statusPengajuan' => 'required|in:mandiri,institusi,kejuruan',
            'nama' => 'required|string|max:255',
            'kontakHp' => 'required|string|min:10|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email|max:255',
            'nik' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $existsInApp = MagangApplication::where('nik', $value)
                        ->orWhere('nim', $value)
                        ->exists();
                    $existsInIntern = Intern::where('nim', $value)->exists();
                    if ($existsInApp || $existsInIntern) {
                        $fail('NIM / KTP sudah terdaftar silahkan cek ke menu "cek status magang" untuk melihat progressnya');
                    }
                },
            ],
            'tglLahir' => 'required|date|before_or_equal:-17 years',
            'alamat' => 'required|string',
            'tglMulai' => 'required|date|after_or_equal:today',
            'tglSelesai' => [
                'required',
                'date',
                'after_or_equal:tglMulai',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->tglMulai && (new \Carbon\Carbon($value))->lt((new \Carbon\Carbon($request->tglMulai))->addMonth())) {
                        $fail('Tanggal selesai minimal 1 bulan dari tanggal mulai.');
                    }
                },
            ],
            'tujuan' => 'required|string',
            'pernyataan' => 'accepted',
            'buktiSurvey' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        if (! config('captcha.disable')) {
            $rules['captcha'] = 'required|captcha';
        }

        // 2. Aturan Tambahan Berdasarkan Status Pengajuan
        if ($request->statusPengajuan === 'mandiri') {
            $rules = array_merge($rules, [
                'pendidikanAsal_m' => 'nullable|string|max:255',
                'prodi_m' => 'nullable|string|max:255',

                // Validasi File Mandiri (Max 5MB = 5120 KB)
                'suratMandiri' => 'required|file|mimes:pdf|max:5120',
                'ktpMandiri' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'fotoMandiri' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            ]);
        } elseif ($request->statusPengajuan === 'institusi' || $request->statusPengajuan === 'kejuruan') {
            $rules = array_merge($rules, [
                'institusi' => 'required|string|max:255',
                'fakultas' => 'required|string|max:255',
                'semester' => 'required|string|max:50',
                'pembimbing' => 'required|string|max:255',
                'kontakPembimbing' => 'required|string|max:255',
                'jumlahPeserta' => 'required|string',

                // Validasi File Institusi (Max 5MB = 5120 KB)
                'suratPengantar' => 'required|file|mimes:pdf|max:5120',
                'proposal' => 'nullable|file|mimes:pdf|max:5120',
            ]);
        }

        // 3. Jalankan Validasi
        $messages = [
            'kontakHp.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'kontakHp.min' => 'Nomor HP/WhatsApp minimal 10 karakter.',
            'kontakHp.max' => 'Nomor HP/WhatsApp maksimal 15 karakter.',
            'kontakHp.regex' => 'Format nomor HP/WhatsApp tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'suratMandiri.max' => 'Ukuran file Surat Permohonan maksimal 5MB.',
            'ktpMandiri.max' => 'Ukuran file KTP maksimal 5MB.',
            'fotoMandiri.max' => 'Ukuran file Pas Foto maksimal 5MB.',
            'suratPengantar.max' => 'Ukuran file Surat Pengantar maksimal 5MB.',
            'proposal.max' => 'Ukuran file Proposal maksimal 5MB.',
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captcha.captcha' => 'Kode captcha tidak sesuai.',
            'buktiSurvey.required' => 'Bukti survey wajib diunggah.',
            'buktiSurvey.max' => 'Ukuran file bukti survey maksimal 5MB.',
        ];

        $validated = $request->validate($rules, $messages);

        // 4. Proses Upload File & Mapping Data
        $data = [
            'status_pengajuan' => $request->statusPengajuan,
            'nama' => $request->nama ?? '-',
            'no_hp' => $request->kontakHp ?? '-',
            'email' => $request->email ?? '-',
            'nik' => $request->nik ?? '-',
            'tgl_lahir' => $request->tglLahir ?? now()->format('Y-m-d'), // Simpan ke database
            'alamat' => $request->alamat ?? '-',
            'tgl_mulai' => $request->tglMulai,
            'tgl_selesai' => $request->tglSelesai,
            'tujuan' => $request->tujuan,
        ];

        if ($request->hasFile('buktiSurvey')) {
            $data['bukti_survey_path'] = $request->file('buktiSurvey')->store('uploads/bukti_survey', 'public');
        }

        if ($request->statusPengajuan === 'mandiri') {
            $data['pendidikan_asal'] = $request->pendidikanAsal_m;
            $data['prodi'] = $request->prodi_m;

            // Upload Files Mandiri
            if ($request->hasFile('suratMandiri')) {
                $data['surat_permohonan_path'] = $request->file('suratMandiri')->store('uploads/surat', 'public');
            }
            if ($request->hasFile('ktpMandiri')) {
                $data['ktp_path'] = $request->file('ktpMandiri')->store('uploads/ktp', 'public');
            }
            if ($request->hasFile('fotoMandiri')) {
                $data['foto_path'] = $request->file('fotoMandiri')->store('uploads/foto', 'public');
            }

        } elseif ($request->statusPengajuan === 'institusi' || $request->statusPengajuan === 'kejuruan') {
            $data['institusi'] = $request->institusi;
            $data['nim'] = $request->nim ?? '-';
            $data['fakultas'] = $request->fakultas;
            $data['semester'] = $request->semester;
            $data['pembimbing'] = $request->pembimbing;
            $data['kontak_pembimbing'] = $request->kontakPembimbing;
            $data['jumlah_peserta'] = $request->jumlahPeserta;

            // Upload Files Institusi
            if ($request->hasFile('suratPengantar')) {
                $data['surat_pengantar_path'] = $request->file('suratPengantar')->store('uploads/surat', 'public');
            }
            if ($request->hasFile('proposal')) {
                $data['proposal_path'] = $request->file('proposal')->store('uploads/proposal', 'public');
            }
        }

        MagangApplication::create($data);

        // 5. Redirect Kembali dengan Pesan Sukses
        return redirect()->route('sample.register.index')->with('success', 'Pengajuan berhasil dikirim');
    }
}
