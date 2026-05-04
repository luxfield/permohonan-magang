<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Upload Laporan Kinerja Harian</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans pb-10">
  <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Bagian Kiri: Form -->
    <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-fit">
      <h2 class="text-xl font-bold mb-4 text-slate-800">Laporan Kinerja Harian</h2>

      @if(session('success'))
          <div class="mb-4 bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg text-sm">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="mb-4 bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-lg text-sm">
              {{ session('error') }}
          </div>
      @endif

      <form action="{{ route('status.kinerja.upload', $application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-2">Judul Kinerja</label>
          <input type="text" name="judul" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="{{ old('judul') }}" placeholder="Contoh: Menganalisa Data Bulan Ini">
          @error('judul') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
          <textarea name="deskripsi" rows="4" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Tuliskan detail pekerjaan hari ini...">{{ old('deskripsi') }}</textarea>
          @error('deskripsi') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-slate-700 mb-2">File Bukti (PDF / JPG / PNG, Max 500KB)</label>
          <input type="file" name="file_kinerja" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
          @error('file_kinerja') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-3">
          <a href="{{ route('status.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition text-sm font-bold">Kembali</a>
          <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm">Upload Kinerja</button>
        </div>
      </form>
    </div>

    <!-- Bagian Kanan: Riwayat -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-fit">
      <h3 class="text-xl font-bold mb-4 text-slate-800">Riwayat Laporan Kinerja</h3>
      <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
        <div class="overflow-auto max-h-[500px]">
            <table class="w-full text-sm text-left">
              <thead class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200 sticky top-0 shadow-sm z-10">
                <tr>
                  <th class="px-4 py-3">Tanggal</th>
                  <th class="px-4 py-3">Judul</th>
                  <th class="px-4 py-3">Deskripsi</th>
                  <th class="px-4 py-3 text-center">Bukti</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($kinerjas as $kinerja)
                  <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $kinerja->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $kinerja->judul }}</td>
                    <td class="px-4 py-3 text-slate-600">
                      {{ $kinerja->deskripsi }}
                      @if($kinerja->komentar_admin)
                        <div class="mt-2 bg-amber-50 border border-amber-200 rounded p-2 text-xs text-amber-800">
                          <strong>Komentar Admin:</strong> {{ $kinerja->komentar_admin }}
                        </div>
                      @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                      <a href="{{ asset('storage/' . $kinerja->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-800 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                      Belum ada laporan kinerja yang diunggah.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
        </div>
      </div>
  </main>
</body>
</html>