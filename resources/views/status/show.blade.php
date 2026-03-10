<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Status Pengajuan: {{ $application->nama }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans flex flex-col">
  <!-- Navbar Component -->
  <x-navbar />
  
  <!-- Main Content -->
  <main class="flex-grow w-full max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('status.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-emerald-600 mb-6 transition">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
      Kembali ke Pencarian
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <!-- Header Status -->
      <div class="p-6 border-b border-slate-100 text-center">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Status Pengajuan Magang</h2>
        
        @if($application->status === 'diterima')
          <div class="inline-flex flex-col items-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-2xl font-bold text-green-700">DITERIMA</span>
            <p class="text-green-600 text-sm mt-1">Selamat! Pengajuan Anda telah disetujui.</p>
            <p class="text-green-600 text-sm mt-1 text-md">Silahkan Cek Kotak Masuk Pada E-Mail Anda</p>
          </div>
        @elseif($application->status === 'ditolak')
          <div class="inline-flex flex-col items-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <span class="text-2xl font-bold text-red-700">DITOLAK</span>
            <p class="text-red-600 text-sm mt-1">Mohon maaf, pengajuan Anda belum dapat kami terima.</p>
          </div>
        @else
          <div class="inline-flex flex-col items-center">
            <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-3 animate-pulse">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-2xl font-bold text-yellow-700">SEDANG DIPROSES</span>
            <p class="text-yellow-600 text-sm mt-1">Pengajuan Anda sedang ditinjau oleh admin.</p>
          </div>
        @endif
      </div>

      <div class="p-6 space-y-6">
        <!-- Detail Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div>
            <span class="block text-slate-500 text-xs">Nama Lengkap</span>
            <span class="font-medium text-slate-800">{{ $application->nama }}</span>
          </div>
          <div>
            <span class="block text-slate-500 text-xs">Institusi / Asal</span>
            <span class="font-medium text-slate-800">{{ $application->institusi ?? $application->pendidikan_asal }}</span>
          </div>
          <div>
            <span class="block text-slate-500 text-xs">Periode Magang</span>
            <span class="font-medium text-slate-800">
              {{ $application->tgl_mulai ? \Carbon\Carbon::parse($application->tgl_mulai)->format('d M Y') : '-' }} s/d 
              {{ $application->tgl_selesai ? \Carbon\Carbon::parse($application->tgl_selesai)->format('d M Y') : '-' }}
            </span>
          </div>
        </div>

        <!-- Alasan Penolakan -->
        @if($application->status === 'ditolak' && $application->catatan_admin)
          <div class="bg-red-50 border border-red-100 rounded-xl p-4">
            <h3 class="font-bold text-red-800 text-sm mb-1">Alasan Penolakan:</h3>
            <p class="text-red-700 text-sm">{{ $application->catatan_admin }}</p>
          </div>
        @endif

        <!-- Tombol Aksi (Hanya jika Diterima) -->
        @if($application->status === 'diterima')
          <div class="border-t border-slate-100 pt-6 mt-6">
            <h3 class="font-bold text-slate-800 mb-3">Tindak Lanjut</h3>
            <p class="text-sm text-slate-600 mb-4">Untuk melengkapi proses magang, silakan unggah Laporan Akhir pada halaman berikut.</p>
            
            <a href="{{ route('status.upload.form', $application->id) }}" class="inline-flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition shadow-sm hover:shadow-md">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
              Halaman Upload Laporan
            </a>
          </div>
        @endif

      </div>
    </div>
  </main>
  <x-footer />
</body>
</html>