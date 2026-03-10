<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Upload Laporan: {{ $application->nama }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans flex flex-col">
  <!-- Navbar Component -->
  <x-navbar />
  
  <!-- Main Content -->
  <main class="flex-grow w-full max-w-3xl mx-auto px-4 py-12">
    <a href="{{ route('status.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-emerald-600 mb-6 transition">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
      Kembali ke Cek Status
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <div class="p-6 border-b border-slate-100">
        <h2 class="text-xl font-bold text-slate-800">Upload Makalah Magang</h2>
        <p class="text-slate-500 text-sm mt-1">Peserta: {{ $application->nama }}</p>
      </div>

      <div class="p-6">
        @if(session('success'))
          <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-xl border border-green-100 flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-bold block mb-1">Berhasil!</span>
                {{ session('success') }}
            </div>
          </div>
        @endif

        @if(session('error'))
          <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-100 flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-bold block mb-1">Gagal!</span>
                {{ session('error') }}
            </div>
          </div>
        @endif

        @if($application->laporan_akhir_path)
          <div class="flex items-center justify-between bg-slate-50 p-4 rounded-xl border border-slate-200 mb-6">
            <div class="flex items-center gap-3 text-sm text-slate-700">
              <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                  <span class="font-bold block text-slate-800">Laporan Tersimpan</span>
                  <span class="text-xs text-slate-500">Terakhir diupdate: {{ $application->updated_at->diffForHumans() }}</span>
              </div>
            </div>
            <a href="{{ asset('storage/'.$application->laporan_akhir_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition">Lihat File</a>
          </div>
        @endif

        @php
            $startDate = $application->tgl_selesai ? $application->tgl_selesai->copy()->subWeek() : null;
            $deadline = $application->tgl_selesai ? $application->tgl_selesai->copy()->addWeek() : null;
            
            $isTooEarly = $startDate && now()->lessThan($startDate);
            $isTooLate = $deadline && now()->greaterThan($deadline);
            $isOpen = !$isTooEarly && !$isTooLate;
        @endphp

        @if($isOpen)
            <form action="{{ route('status.upload', $application->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-6 rounded-xl border border-dashed border-slate-300">
              <div class="mb-4 text-sm text-slate-600 bg-blue-50 border border-blue-100 p-3 rounded-lg">
                <span class="font-bold text-blue-700">Info:</span> Batas akhir upload adalah <strong>{{ $deadline ? $deadline->format('d M Y') : '-' }}</strong> (7 hari setelah selesai magang).
              </div>
              @csrf
              <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">File Laporan (PDF, Max 10MB)</label>
                <input type="file" name="laporan_akhir" accept=".pdf" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer bg-white border border-slate-200 rounded-lg">
                <p class="text-xs text-slate-500 mt-2">*Pastikan file dalam format PDF dan tidak melebihi 10MB.</p>
              </div>
              <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition shadow-sm">
                {{ $application->laporan_akhir_path ? 'Update Laporan' : 'Kirim Laporan' }}
              </button>
            </form>
        @elseif($isTooEarly)
            <div class="p-6 bg-amber-50 text-amber-800 rounded-xl text-sm border border-amber-100 flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="mt-0.5">Form upload laporan belum tersedia. Anda dapat mengunggah laporan mulai tanggal <strong>{{ $startDate ? $startDate->format('d M Y') : '-' }}</strong> (Seminggu sebelum periode magang selesai).</p>
            </div>
        @elseif($isTooLate)
            <div class="p-6 bg-red-50 text-red-800 rounded-xl text-sm border border-red-100 flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="mt-0.5">Maaf, batas waktu pengumpulan laporan telah berakhir pada tanggal <strong>{{ $deadline ? $deadline->format('d M Y') : '-' }}</strong>.</p>
            </div>
        @endif
      </div>
    </div>
  </main>
  <x-footer />
</body>
</html>