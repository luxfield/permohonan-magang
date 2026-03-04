<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard - Magang Kejari</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans">

  <!-- Navbar -->
  <nav class="bg-emerald-900 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <div class="h-8 w-8 rounded bg-white/20 grid place-items-center font-bold text-sm">KN</div>
          <span class="font-bold text-lg">Admin Panel</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-sm text-emerald-100">Halo, {{ Auth::user()->name ?? 'Admin' }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm bg-emerald-800 hover:bg-emerald-700 px-3 py-1.5 rounded-lg transition">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <h1 class="text-2xl font-bold text-slate-800">Data Pendaftar Magang</h1>
    </div>

    @if(session('success'))
      <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200">
            <tr>
              <th class="px-4 py-3 w-16">ID</th>
              <th class="px-4 py-3">Nama & Kontak</th>
              <th class="px-4 py-3">Jalur & Institusi</th>
              <th class="px-4 py-3">Bidang & Waktu</th>
              <th class="px-4 py-3">Berkas</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($applications as $app)
              <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 font-mono text-xs text-slate-500">#{{ $app->id }}</td>
                <td class="px-4 py-3">
                  <div class="font-bold text-slate-900">{{ $app->nama }}</div>
                  <div class="text-xs text-slate-500">{{ $app->email }}</div>
                  <div class="text-xs text-slate-500">{{ $app->no_hp }}</div>
                  <div class="text-[10px] text-slate-400 mt-1">NIK: {{ $app->nik }}</div>
                </td>
                <td class="px-4 py-3">
                  @if($app->status_pengajuan === 'mandiri')
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 mb-1">MANDIRI</span>
                    <div class="text-xs">{{ $app->pendidikan_asal ?? '-' }}</div>
                    <div class="text-xs text-slate-500">{{ $app->prodi ?? '-' }}</div>
                  @else
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 mb-1">INSTITUSI</span>
                    <div class="text-xs">{{ $app->institusi ?? '-' }}</div>
                    <div class="text-xs text-slate-500">{{ $app->fakultas ?? '-' }} (Sem. {{ $app->semester }})</div>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="flex flex-wrap gap-1 mb-1">
                    @if(is_array($app->bidang))
                        @foreach($app->bidang as $bidang)
                            <span class="px-1.5 py-0.5 rounded border border-slate-200 bg-slate-50 text-[10px]">{{ $bidang }}</span>
                        @endforeach
                    @else
                        <span class="text-xs text-slate-400">-</span>
                    @endif
                  </div>
                  <div class="text-xs text-slate-600">
                    {{ $app->tgl_mulai ? $app->tgl_mulai->format('d M Y') : '-' }} s/d 
                    {{ $app->tgl_selesai ? $app->tgl_selesai->format('d M Y') : '-' }}
                  </div>
                </td>
                <td class="px-4 py-3">
                  <div class="flex flex-col gap-1 text-xs">
                    @php
                        $files = [
                            'Surat' => $app->status_pengajuan == 'mandiri' ? $app->surat_permohonan_path : $app->surat_pengantar_path,
                            'CV' => $app->cv_path,
                            'Foto' => $app->foto_path,
                            'KTP/Transkrip' => $app->status_pengajuan == 'mandiri' ? $app->ktp_path : $app->transkrip_path,
                        ];
                    @endphp
                    @foreach($files as $label => $path)
                        @if($path)
                            <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-emerald-600 hover:underline hover:text-emerald-800 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $label }}
                            </a>
                        @endif
                    @endforeach
                  </div>
                </td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('admin.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.show', $app->id) }}" class="inline-block text-xs font-bold text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 px-2 py-1 rounded transition mr-1">
                            Detail
                        </a>
                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 px-2 py-1 rounded transition">
                            Hapus
                        </button>
                    </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                  Belum ada data pengajuan yang masuk.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
        {{ $applications->links() }}
      </div>
    </div>
  </main>

</body>
</html>