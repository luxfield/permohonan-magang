<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>E-Magang Kejaksaan Negeri Kabupaten Tegal</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-950 text-white font-sans leading-relaxed antialiased">
  <header class="relative min-h-screen overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-amber-900/50" id="beranda">
    <div class="absolute top-28 -right-24 w-[290px] h-[290px] bg-yellow-500/20 rounded-full blur-[70px]"></div>
    <div class="absolute bottom-20 -left-24 w-[330px] h-[330px] bg-emerald-500/10 rounded-full blur-[70px]"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <nav class="flex items-center justify-between py-5">
        <a href="#beranda" class="flex items-center gap-3.5" aria-label="E-Magang Kejati Jawa Barat">
          <div class="grid place-items-center w-[46px] h-[46px] rounded-[18px] bg-yellow-400 text-emerald-950 shadow-[0_12px_30px_rgba(250,204,21,0.18)] text-[22px]">⚖</div>
          <div>
            <p class="text-xs font-extrabold text-yellow-300 tracking-[0.25em] uppercase">E-Magang</p>
            <p class="text-sm text-emerald-50 hidden sm:block">Kejaksaan Negeri Kabupaten Tegal</p>
          </div>
        </a>

        <div class="hidden lg:flex items-center gap-8 text-emerald-50 text-sm" id="navLinks">
          <a href="#beranda" class="hover:text-yellow-300 transition-colors">Beranda</a>
          <a href="#tentang" class="hover:text-yellow-300 transition-colors">Tentang</a>
          <a href="#fitur" class="hover:text-yellow-300 transition-colors">Fitur</a>
          <a href="#statistik" class="hover:text-yellow-300 transition-colors">Statistik</a>
        </div>

        <a href="#" class="hidden lg:inline-flex items-center justify-center gap-2.5 min-h-[48px] px-7 rounded-full font-extrabold transition duration-200 ease-in-out bg-yellow-400 text-emerald-950 hover:bg-yellow-300 hover:-translate-y-px">Buat Permohonan</a>
        <button class="lg:hidden grid place-items-center w-10 h-10 rounded-lg bg-white/10 text-white text-2xl" id="mobileToggle" aria-label="Buka menu">☰</button>
      </nav>

      <div class="relative z-0 grid lg:grid-cols-[1fr,0.9fr] gap-14 items-center pt-12 lg:pt-24 pb-20 lg:pb-28">
        <div class="reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
          <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 border border-yellow-300/30 rounded-full bg-white/10 text-yellow-100 backdrop-blur-md text-sm">🎓 Program Magang Digital Terintegrasi</div>
          <p class="mb-3 text-yellow-300 text-sm font-extrabold tracking-[0.35em] uppercase">Kejaksaan Negeri Kabupaten Tegal</p>
          <h1 class="max-w-3xl text-5xl md:text-7xl font-black leading-tight tracking-tighter">Merdeka Belajar <span class="text-yellow-300">Kampus Merdeka</span></h1>
          <p class="max-w-2xl mt-6 text-emerald-50 text-lg leading-loose">
            Raih pengalaman berharga melalui program magang yang membantu mahasiswa memahami proses kerja, administrasi, dan praktik profesional di lingkungan Kejaksaan.
          </p>
          <div class="mt-9 flex flex-col sm:flex-row flex-wrap gap-4">
            <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 min-h-[48px] px-7 rounded-full font-extrabold transition duration-200 ease-in-out bg-yellow-400 text-emerald-950 hover:bg-yellow-300 hover:-translate-y-px">Masuk Sekarang →</a>
            <a href="#tentang" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 min-h-[48px] px-7 rounded-full font-extrabold transition duration-200 ease-in-out border border-white/30 bg-white/5 text-white hover:bg-white/10">Pelajari Lebih Lanjut</a>
          </div>
        </div>

        <div class="relative reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
          <div class="absolute -inset-4 rounded-[36px] bg-yellow-400/20 blur-xl"></div>
          <div class="relative overflow-hidden border border-white/10 rounded-[34px] bg-white/10 backdrop-blur-lg shadow-2xl">
            <div class="aspect-[4/3] min-h-[360px] sm:min-h-[420px] p-4 sm:p-8 bg-gradient-to-br from-yellow-100 via-white to-emerald-100 text-emerald-950">
              <div class="flex flex-col justify-between h-full p-5 sm:p-7 rounded-[28px] bg-white/80 shadow-lg">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-emerald-900/70 text-sm font-semibold">Dashboard Peserta</p>
                    <h3 class="text-2xl font-black">Status Magang</h3>
                  </div>
                  <div class="text-4xl text-yellow-500">🏅</div>
                </div>

                <div class="grid gap-3.5">
                  <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 font-extrabold">
                    <div class="flex items-center gap-2.5"><span class="text-emerald-600">✓</span> Pengajuan</div>
                    <span class="px-3 py-1 rounded-full bg-yellow-200 text-yellow-900 text-xs font-black">Selesai</span>
                  </div>
                  <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 font-extrabold">
                    <div class="flex items-center gap-2.5"><span class="text-emerald-600">✓</span> Verifikasi</div>
                    <span class="px-3 py-1 rounded-full bg-yellow-200 text-yellow-900 text-xs font-black">Diproses</span>
                  </div>
                  <div class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 font-extrabold">
                    <div class="flex items-center gap-2.5"><span class="text-emerald-600">✓</span> Penempatan</div>
                    <span class="px-3 py-1 rounded-full bg-yellow-200 text-yellow-900 text-xs font-black">Menunggu</span>
                  </div>
                </div>

                <div class="p-5 rounded-2xl bg-emerald-950 text-white">
                  <p class="text-emerald-100/60 text-sm font-semibold">Progress Program</p>
                  <div class="h-3 mt-3 overflow-hidden rounded-full bg-white/10">
                    <div class="w-2/3 h-full rounded-inherit bg-yellow-400"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="py-10 border-y border-white/10 bg-emerald-900/85" id="statistik">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="p-7 border border-white/10 rounded-2xl bg-white/5 text-center reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
        <p class="text-yellow-300 text-4xl font-black">120+</p>
        <p class="mt-2 text-emerald-100/80">Mahasiswa/i</p>
      </div>
      <div class="p-7 border border-white/10 rounded-2xl bg-white/5 text-center reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:100ms]">
        <p class="text-yellow-300 text-4xl font-black">20+</p>
        <p class="mt-2 text-emerald-100/80">Mentor</p>
      </div>
      <div class="p-7 border border-white/10 rounded-2xl bg-white/5 text-center reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:200ms]">
        <p class="text-yellow-300 text-4xl font-black">50+</p>
        <p class="mt-2 text-emerald-100/80">Stakeholder</p>
      </div>
      <div class="p-7 border border-white/10 rounded-2xl bg-white/5 text-center reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:300ms]">
        <p class="text-yellow-300 text-4xl font-black">15+</p>
        <p class="mt-2 text-emerald-100/80">Bidang Magang</p>
      </div>
    </div>
  </section>

  <section class="bg-white text-emerald-950 py-16 sm:py-24" id="tentang">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-[0.95fr,1fr] gap-14 items-center">
      <div class="relative reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
        <div class="absolute -inset-5 rounded-3xl bg-yellow-200"></div>
        <div class="relative p-8 rounded-3xl bg-emerald-950 text-white shadow-2xl">
          <p class="text-yellow-300 text-sm font-black tracking-widest uppercase">Tentang Program</p>
          <h2 class="mt-4 text-4xl lg:text-5xl font-black leading-tight tracking-tight">Raih pengalaman belajar yang berdampak.</h2>
          <p class="mt-5 text-emerald-100/80 text-base leading-relaxed">
            Platform E-Magang dirancang untuk menyederhanakan proses pendaftaran, pembimbingan, pelaporan, hingga penerbitan sertifikat bagi peserta magang.
          </p>
          <div class="grid gap-3 mt-7">
            <div class="flex gap-3 items-start p-4 rounded-2xl bg-white/10"><span class="text-emerald-500 mt-1">✓</span> Pengalaman praktik langsung di lingkungan profesional</div>
            <div class="flex gap-3 items-start p-4 rounded-2xl bg-white/10"><span class="text-emerald-500 mt-1">✓</span> Bimbingan dari mentor dan praktisi berpengalaman</div>
            <div class="flex gap-3 items-start p-4 rounded-2xl bg-white/10"><span class="text-emerald-500 mt-1">✓</span> Mendukung program Merdeka Belajar Kampus Merdeka</div>
            <div class="flex gap-3 items-start p-4 rounded-2xl bg-white/10"><span class="text-emerald-500 mt-1">✓</span> Dokumentasi kegiatan dan sertifikat resmi</div>
          </div>
        </div>
      </div>

      <div class="reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:200ms]">
        <p class="text-yellow-700 text-sm font-black tracking-widest uppercase">Merdeka Belajar</p>
        <h2 class="mt-4 text-4xl lg:text-5xl font-black leading-tight tracking-tight">Program E-Magang Kejaksaan Negeri Kabupaten Tegal</h2>
        <p class="mt-5 text-emerald-900/70 text-lg leading-loose">
          Program ini menjadi jembatan antara pembelajaran kampus dan pengalaman profesional. Mahasiswa dapat mengenal budaya kerja, tata kelola, dan praktik pelayanan publik secara langsung.
        </p>
        <div class="flex items-center gap-4 mt-7 p-5 border border-emerald-100 rounded-2xl bg-emerald-50/50">
          <div class="grid place-items-center flex-shrink-0 w-14 h-14 rounded-2xl bg-yellow-400 text-3xl">👥</div>
          <div>
            <h3 class="font-bold text-lg">Dibimbing profesional</h3>
            <p class="text-emerald-900/70">Peserta mendapat arahan dan evaluasi selama masa magang.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-emerald-50/30 text-emerald-950 py-16 sm:py-24" id="fitur">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
        <p class="text-yellow-700 text-sm font-black tracking-widest uppercase">Fitur Platform</p>
        <h2 class="mt-4 text-4xl lg:text-5xl font-black leading-tight tracking-tight">Sistem magang digital yang mudah digunakan</h2>
        <p class="mt-5 text-emerald-900/70 text-lg leading-loose">Semua kebutuhan administrasi dan monitoring magang tersedia dalam satu platform terpadu.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-14">
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">📋</div>
          <h3 class="text-xl font-black">Pengajuan Online</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Daftar dan ajukan permohonan magang secara digital, cepat, dan mudah dipantau.</p>
        </article>
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:100ms]">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">📍</div>
          <h3 class="text-xl font-black">Absensi Digital</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Absensi berbasis foto dan lokasi untuk memastikan kehadiran tercatat akurat.</p>
        </article>
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:200ms]">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">📘</div>
          <h3 class="text-xl font-black">Laporan Harian</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Dokumentasikan aktivitas magang setiap hari dalam dashboard yang rapi.</p>
        </article>
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:300ms]">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">✅</div>
          <h3 class="text-xl font-black">Sertifikat Digital</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Sertifikat resmi dengan kode validasi untuk memastikan keaslian dokumen.</p>
        </article>
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:400ms]">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">📊</div>
          <h3 class="text-xl font-black">Monitoring Realtime</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Pantau progres peserta, bimbingan, dan status administrasi dari satu tempat.</p>
        </article>
        <article class="p-8 border border-emerald-100 rounded-2xl bg-white shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-200 reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0 [transition-delay:500ms]">
          <div class="grid place-items-center w-14 h-14 mb-6 rounded-2xl bg-emerald-950 text-yellow-300 text-3xl group-hover:bg-yellow-400 group-hover:text-emerald-950 transition-colors">🔔</div>
          <h3 class="text-xl font-black">Notifikasi Status</h3>
          <p class="mt-3 text-emerald-900/70 leading-relaxed">Dapatkan pembaruan otomatis untuk setiap tahapan proses magang.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="bg-emerald-950 py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto p-8 sm:p-14 rounded-3xl bg-gradient-to-br from-yellow-300 to-yellow-500 text-emerald-950 text-center shadow-2xl reveal transition-all duration-700 ease-out opacity-0 translate-y-6 [&.visible]:opacity-100 [&.visible]:translate-y-0">
        <h2 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight">Siap memulai pengalaman magang?</h2>
        <p class="max-w-2xl mx-auto mt-5 text-emerald-900/80 text-lg leading-loose">Bergabung dan kelola seluruh proses magang secara lebih transparan, modern, dan terintegrasi.</p>
        <a href="#" class="mt-8 inline-flex items-center justify-center gap-2.5 min-h-[48px] px-7 rounded-full font-extrabold transition duration-200 ease-in-out bg-emerald-950 text-white hover:bg-emerald-900 hover:-translate-y-px">Masuk Sekarang →</a>
      </div>
    </div>
  </section>

  <footer class="border-t border-white/10 bg-emerald-950 text-emerald-100/70 pt-12 pb-7">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <div>
          <div class="flex items-center gap-3.5">
            <div class="grid place-items-center w-11 h-11 rounded-2xl bg-yellow-400 text-emerald-950 text-2xl">⚖</div>
            <p class="font-black text-white">Kejaksaan Negeri Kabupaten Tegal</p>
          </div>
          <p class="mt-4 leading-relaxed">Platform E-Magang digital untuk mendukung program Merdeka Belajar Kampus Merdeka.</p>
        </div>
        <div>
          <h4 class="font-black text-white">Kontak</h4>
          <p class="mt-4 leading-relaxed">Jalan Professor Muhammad Yamin No.16, Mingkrik, Pakembaran, Kec. Slawi, Kabupaten Tegal, Jawa Tengah 52415</p>
          <p class="mt-2">(022) 4204501</p>
        </div>
        <div>
          <h4 class="font-black text-white">Link Cepat</h4>
          <div class="grid gap-2 mt-4">
            <a href="#beranda" class="hover:text-yellow-300 transition-colors">Beranda</a>
            <a href="#tentang" class="hover:text-yellow-300 transition-colors">Tentang Program</a>
            <a href="#fitur" class="hover:text-yellow-300 transition-colors">Fitur</a>
            <a href="#" class="hover:text-yellow-300 transition-colors">Login</a>
          </div>
        </div>
      </div>
      <p class="mt-9 pt-5 border-t border-white/10 text-emerald-100/50 text-sm">© @php
        echo date('Y');
      @endphp Kejari Kabupaten Tegal.</p>
    </div>
  </footer>

  <script>
    const mobileToggle = document.getElementById("mobileToggle");
    const navLinks = document.getElementById("navLinks");
 
    mobileToggle.addEventListener("click", () => {
      const isHidden = navLinks.classList.contains('hidden');
      if (isHidden) {
        navLinks.classList.remove('hidden');
        navLinks.classList.add('grid');
        mobileToggle.textContent = "×";
      } else {
        navLinks.classList.add('hidden');
        navLinks.classList.remove('grid');
        mobileToggle.textContent = "☰";
      }
    });
 
    navLinks.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        if (window.innerWidth < 1024) {
          navLinks.classList.add("hidden");
          navLinks.classList.remove("grid");
          mobileToggle.textContent = "☰";
        }
      });
    });
 
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
          }
        });
      },
      { threshold: 0.1 }
    );
 
    document.querySelectorAll(".reveal").forEach((el) => {
      observer.observe(el);
    });
  </script>
</body>
</html>
