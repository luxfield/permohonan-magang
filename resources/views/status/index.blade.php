<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Cek Status Magang - Kejari</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 flex flex-col font-sans">

  <!-- Navbar Component -->
  <x-navbar />

  <main class="flex-grow flex items-center justify-center px-4 py-24">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-emerald-900 p-6 text-center">
        <h1 class="text-2xl font-bold text-white">Cek Status Magang</h1>
        <p class="text-emerald-100 text-sm mt-1">Masukkan data diri untuk melihat progress pengajuan</p>
      </div>

      <div class="p-8">
        @if(session('error'))
          <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-lg border border-red-100">
            {{ session('error') }}
          </div>
        @endif

        <form action="{{ route('status.check') }}" method="POST" class="space-y-5">
          @csrf
          <div>
            <label for="identifier" class="block text-sm font-medium text-slate-700 mb-1">NIK / NIM / NIS</label>
            <input type="text" name="identifier" id="identifier" required 
              class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
              placeholder="Contoh: 3201234567890001">
          </div>

          <div>
            <label for="tgl_lahir" class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir" required 
              class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
          </div>

          <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-emerald-200">
            Lihat Status
          </button>
        </form>

        <div class="mt-6 text-center">
          <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-emerald-600">
            &larr; Kembali ke Halaman Utama
          </a>
        </div>
      </div>
    </div>
  </main>
<x-footer />

</body>
</html>