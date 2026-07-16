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
          <span class="font-bold text-lg">Admin Panel Kejaksaan Negeri Kabupaten Tegal</span>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-sm text-emerald-100">Halo, {{ auth()->user()->name ?? 'Admin' }} Kab. Tegal</span>
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
      <button id="whats-new-btn" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-200 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        What's New
      </button>
    </div>

    @if(session('success'))
      <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
      </div>
    @endif

    <!-- Settings Panel -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 mb-6">
      <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-slate-100">
        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <h2 class="font-bold text-slate-800">Pengaturan Registrasi Magang</h2>
      </div>

      <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Pendaftaran</label>
            <div class="flex items-center gap-4 mt-2">
              <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="registration_status" value="open" class="sr-only peer" {{ $registrationOpen ? 'checked' : '' }} onchange="toggleMessageField()">
                <div class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 bg-white peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-500 transition shadow-sm">
                  Dibuka (Open)
                </div>
              </label>
              <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="registration_status" value="closed" class="sr-only peer" {{ !$registrationOpen ? 'checked' : '' }} onchange="toggleMessageField()">
                <div class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 bg-white peer-checked:bg-amber-50 peer-checked:text-amber-700 peer-checked:border-amber-500 transition shadow-sm">
                  Ditutup (Closed)
                </div>
              </label>
            </div>
            <p class="text-[11px] text-slate-500 mt-2">Menentukan apakah form registrasi magang dapat diakses publik.</p>
          </div>

          <div class="md:col-span-2" id="closed-message-container">
            <label for="registration_closed_message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pesan Pengumuman Penutupan</label>
            <textarea id="registration_closed_message" name="registration_closed_message" rows="3" 
                      class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 disabled:bg-slate-50 disabled:text-slate-400 transition"
                      placeholder="Masukkan alasan atau detail pengumuman penutupan pendaftaran...">{{ $registrationClosedMessage }}</textarea>
            <p class="text-[11px] text-slate-500 mt-1">Pesan ini akan tampil di homepage saat pendaftaran ditutup.</p>
          </div>
        </div>

        <div class="flex justify-end pt-3 border-t border-slate-100">
          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold rounded-xl shadow-sm transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Simpan Pengaturan
          </button>
        </div>
      </form>
    </div>

    <script>
      function toggleMessageField() {
        const isOpen = document.querySelector('input[name="registration_status"]:checked').value === 'open';
        const messageTextarea = document.getElementById('registration_closed_message');
        const container = document.getElementById('closed-message-container');
        if (isOpen) {
          messageTextarea.disabled = true;
          container.classList.add('opacity-50');
        } else {
          messageTextarea.disabled = false;
          container.classList.remove('opacity-50');
        }
      }
      document.addEventListener('DOMContentLoaded', toggleMessageField);
    </script>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200">
            <tr>
              <th class="px-4 py-3 w-16">ID</th>
              <th class="px-4 py-3">Nama & Kontak</th>
              <th class="px-4 py-3">Jalur & Institusi</th>
              <th class="px-4 py-3">Bidang & Waktu</th>
              <th class="px-4 py-3">Berkas Pengajuan</th>
              <th class="px-4 py-3">Berkas Makalah</th>
              <th class="px-4 py-3 text-center">Status</th>
              <th class="px-4 py-3 text-center">Aksi</th>
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
                    <div class="text-[10px] text-slate-400 mt-1">NIK/NIM/NIS: {{ $app->nik }}</div>
                  
                </td>
                <td class="px-4 py-3">
                  @if($app->status_pengajuan === 'mandiri')
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 mb-1">MANDIRI</span>
                    <div class="text-xs">{{ $app->pendidikan_asal ?? '-' }}</div>
                    <div class="text-xs text-slate-500">{{ $app->prodi ?? '-' }}</div>
                  @elseif($app->status_pengajuan === 'kejuruan')
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 mb-1">KEJURUAN</span>
                    <div class="text-xs">{{ $app->institusi ?? '-' }}</div>
                    <div class="text-xs text-slate-500">Kelas {{ $app->semester }}</div>
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
                <td class="px-4 py-3">
                  <div class="flex flex-col gap-1 text-xs">
                    @php
                        $files = [
                            'Laporan' => $app->laporan_akhir_path,
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
                <td class="px-4 py-3 text-center">
                  @if($app->status === 'diterima')
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">DITERIMA</span>
                  @elseif($app->status === 'ditolak')
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">DITOLAK</span>
                  @else
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">PENDING</span>
                  @endif
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
                <td colspan="8" class="px-4 py-8 text-center text-slate-500">
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

  <!-- Modal What's New -->
  <div id="whats-new-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform scale-95 transition-all duration-300 opacity-0" id="whats-new-modal-content">
      <div class="px-6 py-4 bg-emerald-900 text-white flex justify-between items-center">
        <div class="flex items-center gap-2">
          <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
          <h2 class="font-bold text-lg">What's New</h2>
        </div>
        <button id="close-modal-btn" class="text-white/80 hover:text-white transition cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>
      <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
        <!-- Update 1 -->
        <div class="flex gap-4">
          <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-800 flex items-center justify-center font-bold text-sm"></div>
          <div>
            <h3 class="font-semibold text-slate-800 text-sm">v1.0.1-08072024</h3>
            <ul class="list-disc list-inside text-xs text-slate-500 mt-1 space-y-1">
              <li>Menambahkan validasi pada saat submit form register</li>
              <li>Menambahkan proteksi rate limiter pada saat submit form register</li>
            </ul>
          </div>
        </div>
        <hr class="border-slate-100">
        <!-- Update 2 -->
        <div class="flex gap-4">
          <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 text-yellow-800 flex items-center justify-center font-bold text-sm"></div>
          <div>
            <h3 class="font-semibold text-slate-800 text-sm">v1.0.0-07072024</h3>
            <p class="text-xs text-slate-500 mt-1">Perbaikan pada alert register tidak tampil pada saat penggunan unggah data melebihi maksimum</p>
          </div>
        </div>
        <!-- <hr class="border-slate-100"> -->
            <!-- Update 3 -->
        <!-- <div class="flex gap-4">
          <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-sm">3</div>
          <div>
            <h3 class="font-semibold text-slate-800 text-sm">Pencarian & Penyaringan Pendaftar</h3>
            <p class="text-xs text-slate-500 mt-1">Sistem pencarian dan penyaringan data pendaftar yang lebih cepat berdasarkan kategori jalur pengajuan (mandiri, kejuruan, atau institusi).</p>
          </div>
        </div> -->
        <!-- <hr class="border-slate-100"> -->
            <!-- Update 4 -->
        <!-- <div class="flex gap-4">
          <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-sm">4</div>
          <div>
            <h3 class="font-semibold text-slate-800 text-sm">Penyempurnaan UI Dashboard</h3>
            <p class="text-xs text-slate-500 mt-1">Tampilan dashboard yang lebih responsif dengan nuansa warna Emerald khas Kejaksaan dan navigasi yang lebih intuitif.</p>
          </div>
        </div> -->
      </div>
      <div class="px-6 py-4 bg-slate-50 flex justify-end">
        <button id="close-modal-footer-btn" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold rounded-xl transition cursor-pointer">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modal = document.getElementById('whats-new-modal');
      const content = document.getElementById('whats-new-modal-content');
      const openBtn = document.getElementById('whats-new-btn');
      const closeBtn = document.getElementById('close-modal-btn');
      const closeFooterBtn = document.getElementById('close-modal-footer-btn');

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Force reflow
        modal.offsetHeight;
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
      }

      function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        // Wait for transition to complete
        setTimeout(() => {
          modal.classList.remove('flex');
          modal.classList.add('hidden');
        }, 300);
      }

      if (openBtn) openBtn.addEventListener('click', openModal);
      if (closeBtn) closeBtn.addEventListener('click', closeModal);
      if (closeFooterBtn) closeFooterBtn.addEventListener('click', closeModal);

      // Close on clicking backdrop
      modal.addEventListener('click', function (e) {
        if (e.target === modal) {
          closeModal();
        }
      });
    });
  </script>

</body>
</html>