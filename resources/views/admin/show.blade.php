<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Detail Pendaftar #{{ $application->id }} - Admin Kejari</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans pb-10">
  <!-- Navbar -->
  <nav class="bg-emerald-900 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:text-emerald-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-bold">Kembali</span>
          </a>
        </div>
        <div class="font-mono text-sm opacity-80">ID: #{{ $application->id }}</div>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
      <div>
        <div class="flex items-center gap-3 mb-2">
          @if($application->status_pengajuan === 'mandiri')
            <h1 class="text-3xl font-bold text-slate-800">{{ $application->nama }}</h1>
          @else
            <h1 class="text-3xl font-bold text-slate-800">{{ $application->institusi }}</h1>
          @endif
            @if($application->status_pengajuan === 'mandiri')
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">MANDIRI</span>
          @else
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200">INSTITUSI</span>
          @endif

          {{-- Status Badge --}}
          @if($application->status === 'diterima')
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">DITERIMA</span>
          @elseif($application->status === 'ditolak')
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">DITOLAK</span>
          @else
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">PENDING</span>
          @endif
        </div>
        <p class="text-slate-500 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            {{ $application->email }}
            <span class="mx-1">•</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            {{ $application->no_hp }}
        </p>
      </div>
      
      <div class="flex gap-3">
        <form action="{{ route('admin.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?');">
            @csrf @method('DELETE')
            <button type="submit" class="bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 px-4 py-2 rounded-xl font-bold text-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Data
            </button>
        </form>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Card: Data Pribadi / Institusi -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                    {{ $application->status_pengajuan === 'mandiri' ? 'Data Pribadi' : 'Data Institusi' }}
                </h3>
                <dl class="space-y-3 text-sm">
                    @if($application->status_pengajuan === 'mandiri')
                    <div>
                        <dt class="text-slate-500 text-xs">NIK</dt>
                        <dd class="font-mono font-medium">{{ $application->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 text-xs">Tanggal Lahir</dt>
                        <dd class="font-medium">{{ $application->tgl_lahir ? \Carbon\Carbon::parse($application->tgl_lahir)->format('d M Y') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 text-xs">Alamat Domisili</dt>
                        <dd class="font-medium">{{ $application->alamat }}</dd>
                    </div>
                    @else
                        <div>
                            <dt class="text-slate-500 text-xs">Nama Institusi</dt>
                            <dd class="font-medium">{{ $application->institusi }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 text-xs">Fakultas / Jurusan</dt>
                            <dd class="font-medium">{{ $application->fakultas }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 text-xs">Pembimbing</dt>
                            <dd class="font-medium">{{ $application->pembimbing }} ({{ $application->kontak_pembimbing }})</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Card: Data Magang -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Informasi Magang</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-slate-500 text-xs">Periode Magang</dt>
                        <dd class="font-medium">
                            {{ $application->tgl_mulai ? $application->tgl_mulai->format('d M Y') : '-' }} 
                            <span class="text-slate-400 mx-1">s/d</span> 
                            {{ $application->tgl_selesai ? $application->tgl_selesai->format('d M Y') : '-' }}
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-slate-500 text-xs">Tujuan Pemagangan</dt>
                        <dd class="font-medium text-slate-700 mt-1 leading-relaxed">{{ $application->tujuan }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Card: Data Akademik -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                    {{ $application->status_pengajuan === 'mandiri' ? 'Data Asal Institusi' : 'Detail Peserta' }}
                </h3>
                <dl class="space-y-3 text-sm">
                    @if($application->status_pengajuan === 'mandiri')
                        <div>
                            <dt class="text-slate-500 text-xs">Asal Institusi</dt>
                            <dd class="font-medium">{{ $application->pendidikan_asal ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 text-xs">Program Studi</dt>
                            <dd class="font-medium">{{ $application->prodi ?: '-' }}</dd>
                        </div>
                    @else
                        <div>
                            <dt class="text-slate-500 text-xs">Jumlah Peserta</dt>
                            <dd class="font-medium">{{ $application->jumlah_peserta ?: '-' }} Orang</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 text-xs">Semester</dt>
                            <dd class="font-medium">{{ $application->semester }}</dd>
                        </div>
                        @if($application->nim !== '-')
                        <div>
                            <dt class="text-slate-500 text-xs">NIM / NIS</dt>
                            <dd class="font-medium">{{ $application->nim }}</dd>
                        </div>
                        @endif
                    @endif
                </dl>
            </div>
        </div>

        <!-- Right Column: File Previews -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card: Tindakan Admin (Approval) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Verifikasi Pengajuan</h3>
                
                <form action="{{ route('admin.update_status', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="catatan_admin" class="block text-sm font-medium text-slate-700 mb-2">Catatan / Alasan</label>
                        <textarea name="catatan_admin" id="catatan_admin" rows="3" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm disabled:bg-slate-100 disabled:text-slate-500" placeholder="Tuliskan catatan untuk pemohon (opsional)..." {{ ($application->status === 'diterima' || $application->status === 'ditolak') ? 'disabled' : '' }}>{{ old('catatan_admin', $application->catatan_admin) }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        @if($application->status !== 'diterima' && $application->status !== 'ditolak')
                            <button type="submit" name="status" value="diterima" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Setujui Pengajuan
                            </button>
                            <button type="submit" name="status" value="ditolak" class="flex-1 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak
                            </button>
                        @else
                            <div class="w-full py-3 text-center text-sm text-slate-500 bg-slate-100 rounded-lg border border-slate-200">
                                Pengajuan ini telah <strong>{{ strtoupper($application->status) }}</strong>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Card: Manajemen Peserta (Hanya untuk Institusi & Diterima) --}}
            @if($application->status_pengajuan !== 'mandiri' && $application->status === 'diterima')
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mt-6">
                <div class="border-b border-slate-100 pb-3 mb-4 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Manajemen Peserta Magang</h3>
                    <span class="text-sm text-slate-500 font-medium">
                        {{ $application->interns->count() }} / {{ $application->jumlah_peserta }} Peserta
                    </span>
                </div>

                {{-- Daftar Peserta yang Sudah Didaftarkan --}}
                @if($application->interns->isNotEmpty())
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-slate-600 mb-3">Daftar Akun Peserta</h4>
                    <ul class="space-y-3">
                        @foreach($application->interns as $intern)
                        <li class="flex flex-col p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex justify-between items-center w-full">
                                <div>
                                    <p class="font-bold text-sm text-slate-800">{{ $intern->nama }}</p>
                                     <p class="text-xs text-slate-500">{{ $intern->email }}
                                        @if($intern->nim)
                                        <span class="mx-1">•</span> NIM: {{ $intern->nim }}
                                        @endif
                                    <p class="text-xs text-slate-500">NIM / NIS: <span class="font-semibold">{{ $intern->nim }}</span>
                                        <span class="mx-1">•</span> Tgl Lahir: {{ \Carbon\Carbon::parse($intern->tanggal_lahir)->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="toggleEdit('edit-intern-{{ $intern->id }}')" class="text-xs font-bold text-amber-600 hover:text-amber-800 hover:bg-amber-100 bg-amber-50 px-2 py-1 rounded transition">Edit</button>
                                    <form action="{{ route('admin.interns.destroy', $intern->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini? Akun login juga akan dihapus secara permanen.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-100 bg-rose-50 px-2 py-1 rounded transition">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Form Edit (Tersembunyi by default) -->
                            <div id="edit-intern-{{ $intern->id }}" class="hidden mt-3 pt-3 border-t border-slate-200">
                                <form action="{{ route('admin.interns.update', $intern->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama Lengkap</label>
                                        <input type="text" name="nama" value="{{ $intern->nama }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ $intern->email }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                        <label class="block text-xs font-medium text-slate-600 mb-1">NIM / NIS / NIK</label>
                                        <input type="text" name="nim" value="{{ $intern->nim }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">NIM / NIS</label>
                                        <input type="text" name="nim" value="{{ $intern->nim }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" value="{{ $intern->tanggal_lahir }}" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="toggleEdit('edit-intern-{{ $intern->id }}')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">Batal</button>
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Form Tambah Peserta (jika kuota masih ada) --}}
                @if($application->interns->count() < $application->jumlah_peserta)
                <div>
                    <h4 class="text-sm font-bold text-slate-600 mb-3">Buat Akun Peserta Baru</h4>
                    <form action="{{ route('admin.interns.add', $application->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="nama" class="block text-xs font-medium text-slate-600 mb-1">Nama Lengkap Peserta</label>
                            <input type="text" name="nama" id="nama" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-medium text-slate-600 mb-1">Email Peserta</label>
                            <input type="email" name="email" id="email" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Email aktif untuk login">
                            <label for="nim" class="block text-xs font-medium text-slate-600 mb-1">NIM / NIS / NIK</label>
                            <input type="text" name="nim" id="nim" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Nomor Induk Mahasiswa/Siswa/Kependudukan">
                        </div>
                        <div>
                            <label for="nim" class="block text-xs font-medium text-slate-600 mb-1">NIM / NIS (Opsional)</label>
                            <input type="text" name="nim" id="nim" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Nomor Induk Mahasiswa/Siswa">
                            <label for="tanggal_lahir" class="block text-xs font-medium text-slate-600 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Buat Akun & Tambah Peserta
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="w-full py-3 text-center text-sm text-slate-500 bg-slate-100 rounded-lg border border-slate-200">
                    Kuota peserta untuk pengajuan ini sudah penuh.
                </div>
                @endif

                {{-- Display success/error messages from session --}}
                @if(session('success') && Str::contains(session('success'), 'Akun untuk'))
                    <div class="mt-4 bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            @endif

            <h3 class="font-bold text-xl text-slate-800">Berkas Lampiran</h3>
            
            @php
                // Mapping file berdasarkan jenis pengajuan
                $files = [];
                
                // Foto Profil (Selalu ada)
                if($application->foto_path) {
                    $files['Pas Foto'] = ['type' => 'image', 'path' => $application->foto_path];
                }

                if($application->status_pengajuan === 'mandiri') {
                    if($application->surat_permohonan_path) $files['Surat Permohonan'] = ['type' => 'pdf', 'path' => $application->surat_permohonan_path];
                    if($application->ktp_path) {
                        // KTP bisa gambar atau PDF, cek ekstensi sederhana
                        $isPdf = str_ends_with(strtolower($application->ktp_path), '.pdf');
                        $files['KTP'] = ['type' => $isPdf ? 'pdf' : 'image', 'path' => $application->ktp_path];
                    }
                } else {
                    if($application->surat_pengantar_path) $files['Surat Pengantar'] = ['type' => 'pdf', 'path' => $application->surat_pengantar_path];
                    if($application->transkrip_path) $files['Transkrip Nilai'] = ['type' => 'pdf', 'path' => $application->transkrip_path];
                    if($application->proposal_path) $files['Proposal'] = ['type' => 'pdf', 'path' => $application->proposal_path];
                }
            @endphp

            @if(empty($files))
                <div class="p-8 text-center bg-white rounded-2xl border border-dashed border-slate-300 text-slate-500">
                    Tidak ada berkas yang diunggah.
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($files as $label => $file)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex justify-between items-center">
                                <h4 class="font-bold text-slate-700 text-sm">{{ $label }}</h4>
                                <a href="{{ asset('storage/'.$file['path']) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                            </div>
                            
                            <div class="p-4 bg-slate-100/50 flex justify-center">
                                @if($file['type'] === 'image')
                                    <img src="{{ asset('storage/'.$file['path']) }}" alt="{{ $label }}" class="max-h-[400px] rounded-lg shadow-sm border border-slate-200 object-contain">
                                @elseif($file['type'] === 'pdf')
                                    <div class="w-full h-[500px] bg-slate-200 rounded-lg overflow-hidden relative group">
                                        <embed src="{{ route('admin.file.preview', ['path' => $file['path']]) }}" type="application/pdf" class="w-full h-full" />
                                        
                                        <!-- Fallback jika browser tidak support preview PDF -->
                                        {{-- <div class="absolute inset-0 flex items-center justify-center bg-white/90 opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                            <span class="text-sm font-bold text-slate-600">Klik tombol Download di atas jika preview tidak muncul</span>
                                        </div> --}}
                                    </div>
                                @else
                                    <div class="py-8 text-center text-slate-500 text-sm">
                                        Preview tidak tersedia untuk format file ini.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

  </main>

  <!-- Script untuk toggle form edit -->
  <script>
    function toggleEdit(id) {
        const el = document.getElementById(id);
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
        } else {
            el.classList.add('hidden');
        }
    }
  </script>
</body>
</html>