<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Portal Magang - Kejaksaan Negeri</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex flex-col font-sans">

  <!-- Navbar Component -->
  <x-navbar />

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center px-6 py-24">
    <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="group bg-white rounded-2xl shadow-xl border border-slate-200 p-8 hover:border-emerald-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
        <div class="relative z-10 w-24 h-24 mx-auto bg-white/10 rounded-full flex items-center justify-center border-2 border-white/20 mb-6 backdrop-blur-sm shadow-lg">
                <svg class="w-12 h-12 text-amber-400 animate-[spin_4s_linear_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-4">PENGUMUMAN</h2>
            <p class="text-slate-600 leading-relaxed mb-8 max-w-lg mx-auto">Dalam rangka optimalisasi pelaksanaan kegiatan magang, dengan ini disampaikan bahwa kapasitas penerimaan siswa/siswi dan mahasiswa/mahasiswi magang telah terpenuhi, sehingga penerimaan peserta magang ditutup hingga waktu yang belum dapat ditentukan. Pembukaan kembali penerimaan akan diinformasikan melalui website resmi apabila kapasitas telah tersedia
            </p>
        </div>
        <!-- Card 1: Pendaftaran Baru -->
        <!--<a href="{{ route('sample.register.index') }}" -->
        <!--    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors">-->
        <!--        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>-->
        <!--    </div>-->
        <!--    <h2 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-emerald-700">Permohonan Magang</h2>-->
        <!--    <p class="text-slate-500 text-sm leading-relaxed">-->
        <!--        Bagi mahasiswa atau siswa yang ingin mengajukan permohonan magang baru. Silakan isi formulir pendaftaran.-->
        <!--    </p>-->
        <!--    <span class="mt-6 inline-flex items-center gap-2 text-emerald-600 font-bold text-sm group-hover:underline">-->
        <!--        Daftar Sekarang &rarr;-->
        <!--    </span>-->
        <!--</a>-->

        <!-- Card 2: Cek Status -->
        <a href="{{ route('status.index') }}" class="group bg-white rounded-2xl shadow-xl border border-slate-200 p-8 hover:border-sky-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-sky-700">Cek Status Magang</h2>
            <p class="text-slate-500 text-sm leading-relaxed">
                Sudah mendaftar? Pantau status pengajuan Anda atau upload laporan akhir magang di sini.
            </p>
            <span class="mt-6 inline-flex items-center gap-2 text-sky-600 font-bold text-sm group-hover:underline">
                Cek Status &rarr;
            </span>
        </a>

    </div>
  </main>

  <x-footer />


</body>
</html>