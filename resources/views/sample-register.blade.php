<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Form Pemagangan Kejari</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="color-scheme" content="light" />
</head>

<body class="min-h-screen bg-gradient-to-b from-slate-100 to-slate-50 text-slate-900">
  <!-- Header -->
  <header class="bg-gradient-to-r from-emerald-900 to-emerald-700 text-white border-b-4 border-white/10">
    <div class="max-w-6xl mx-auto px-4 py-5">
      <div class="flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-3">
          <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-emerald-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-bold">Kembali</span>
          </a>
        </div>
        <div class="h-10 w-px bg-white/20"></div>
        <div class="h-11 w-11 rounded-xl bg-white/15 grid place-items-center font-extrabold">KN</div>
        <div>
          <h1 class="text-base sm:text-lg font-bold leading-tight">
            Form Pengajuan Pemagangan — Kejaksaan Negeri Kabupaten Tegal
          </h1>
          <p class="text-xs sm:text-sm text-white/90 mt-1">
            Silahkan isi data diri anda dengan benar.
          </p>
        </div>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 py-4 sm:py-6">
     <div class="flex justify-end mb-4">
      <a href="{{ asset('storage/documents/petunjuk_pengisian.pdf') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-white border border-slate-200 text-slate-800 px-4 py-2 text-sm font-bold hover:bg-slate-50 hover:border-slate-300 transition shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span>Petunjuk Pengisian</span>
      </a>
    </div>

    <div class="grid grid-cols-1 gap-4">
      <!-- Left: Form -->
      <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 sm:p-5">
        <div class="flex items-start justify-between gap-3">
          <div>
            <h2 class="text-sm sm:text-base font-bold">Form Pengajuan</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
              Kolom bertanda <span class="text-rose-700 font-extrabold">*</span> wajib diisi.
            </p>
          </div>
        </div>

        @if(session('success'))
            <div class="mt-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="magangForm" action="{{ route('sample.register.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-5">
          @csrf
          <!-- Section 1 -->
          <div class="pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">1) Status Pengajuan</h3>
            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="statusPengajuan" class="text-xs font-bold">
                  Status Pengajuan <span class="text-rose-700">*</span>
                </label>
                <select id="statusPengajuan" name="statusPengajuan" required
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500">
                  <option value="">— Pilih —</option>
                  <option value="mandiri">Pemagangan Mandiri (Perorangan)</option>
                  <option value="institusi">Magang Bidang Hukum (Fakultas Hukum)</option>
                  <option value="kejuruan">Magang Bidang Umum & Teknis (Mahasiswa/Siswa SMK/MAK)</option>
                </select>
                <p class="text-[11px] text-slate-500 mt-1">Akan memunculkan persyaratan sesuai jalur.</p>
              </div>

            </div>
          </div>

          <!-- Section 2 -->
          <div id="dataPemohonSection" class="pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">2) Data Pemohon</h3>
            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="nama" class="text-xs font-bold">Nama Lengkap <span class="text-rose-700">*</span></label>
                <input id="nama" name="nama" required
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="kontakHp" class="text-xs font-bold">No. HP/WhatsApp <span class="text-rose-700">*</span></label>
                <input id="kontakHp" name="kontakHp" required inputmode="tel" placeholder="08xxxxxxxxxx"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="email" class="text-xs font-bold">Email <span class="text-rose-700">*</span></label>
                <input id="email" name="email" type="email" required
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="nik" class="text-xs font-bold">NIK / NIS / NIM <span class="text-rose-700">*</span></label>
                <input id="nik" name="nik" required inputmode="numeric" placeholder="Nomor Induk Kependudukan / Nomor Induk Siswa / Nomor Induk Mahasiwa"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="tglLahir" class="text-xs font-bold">Tanggal Lahir <span class="text-rose-700">*</span></label>
                <input id="tglLahir" name="tglLahir" type="date" required
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
                <p class="text-[11px] text-slate-500 mt-1">Digunakan untuk verifikasi saat cek status pengajuan.</p>
              </div>
            </div>

            <div class="mt-3">
              <label for="alamat" class="text-xs font-bold">Alamat Domisili <span class="text-rose-700">*</span></label>
              <textarea id="alamat" name="alamat" required
                        class="mt-1 w-full min-h-[92px] rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500"></textarea>
            </div>
          </div>

          <!-- Section 3 -->
          <div class="pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">3) Informasi Pemagangan</h3>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="tglMulai" class="text-xs font-bold">Tanggal Mulai <span class="text-rose-700">*</span></label>
                <input id="tglMulai" name="tglMulai" type="date" required min="{{ now()->toDateString() }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="tglSelesai" class="text-xs font-bold">Tanggal Selesai <span class="text-rose-700">*</span></label>
                <input id="tglSelesai" name="tglSelesai" type="date" required
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3">
              <label for="tujuan" class="text-xs font-bold">Tujuan Pemagangan <span class="text-rose-700">*</span></label>
              <textarea id="tujuan" name="tujuan" required
                        class="mt-1 w-full min-h-[92px] rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500"></textarea>
            </div>
          </div>

          <!-- Section 4A: Mandiri -->
          <div id="mandiriSection" class="hidden pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">4A) Jalur Mandiri</h3>
            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="pendidikanAsal_m" class="text-xs font-bold">Asal Institusi (jika ada)</label>
                <input id="pendidikanAsal_m" name="pendidikanAsal_m"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="prodi_m" class="text-xs font-bold">Program Studi/Jurusan</label>
                <input id="prodi_m" name="prodi_m"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
              <div>
                <label for="suratMandiri" class="text-xs font-bold">Surat Permohonan (PDF)</label>
                <input id="suratMandiri" name="suratMandiri" type="file" accept=".pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900 @error('suratMandiri') text-rose-600 @enderror" />
                @error('suratMandiri')
                    <p class="text-[11px] text-rose-700 mt-1 font-semibold">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="ktpMandiri" class="text-xs font-bold">KTP / NIS / NIM (JPG/PNG/PDF)</label>
                <input id="ktpMandiri" name="ktpMandiri" type="file" accept=".jpg,.jpeg,.png,.pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900 @error('ktpMandiri') text-rose-600 @enderror" />
                @error('ktpMandiri')
                    <p class="text-[11px] text-rose-700 mt-1 font-semibold">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="fotoMandiri" class="text-xs font-bold">Pas Foto (JPG/PNG)</label>
                <input id="fotoMandiri" name="fotoMandiri" type="file" accept=".jpg,.jpeg,.png"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900 @error('fotoMandiri') text-rose-600 @enderror" />
                @error('fotoMandiri')
                    <p class="text-[11px] text-rose-700 mt-1 font-semibold">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <!-- Section 4B: Institusi -->
          <div id="institusiSection" class="hidden pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">4B) Jalur Institusi</h3>

            <div class="mt-3 grid grid-cols-1 gap-3">
              <div>
                <label for="institusi" class="text-xs font-bold">Nama Institusi <span class="text-rose-700">*</span></label>
                <input id="institusi" name="institusi"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="fakultas" class="text-xs font-bold">Fakultas/Jurusan <span class="text-rose-700">*</span></label>
                <input id="fakultas" name="fakultas"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="semester" class="text-xs font-bold">Semester/Tingkat <span class="text-rose-700">*</span></label>
                <select id="semester" name="semester"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500">
                  <option value="">— Pilih —</option>
                  <option>1</option><option>2</option><option>3</option><option>4</option>
                  <option>5</option><option>6</option><option>7</option><option>8</option>
                  <option>9+</option>
                </select>
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="pembimbing" class="text-xs font-bold">Dosen/Guru Pembimbing <span class="text-rose-700">*</span></label>
                <input id="pembimbing" name="pembimbing"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="kontakPembimbing" class="text-xs font-bold">Kontak Pembimbing <span class="text-rose-700">*</span></label>
                <input id="kontakPembimbing" name="kontakPembimbing" placeholder="Email/HP"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="jumlahPeserta" class="text-xs font-bold">Jumlah Peserta <span class="text-rose-700">*</span></label>
                <select id="jumlahPeserta" name="jumlahPeserta"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500">
                  <option value="">— Pilih —</option>
                  <option value="1">1 orang</option>
                  <option value="2-5">2–5 orang</option>
                  <option value="6-10">6–10 orang</option>
                  <option value=">10">&gt; 10 orang</option>
                </select>
              </div>
            </div>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
              <div>
                <label for="suratPengantar" class="text-xs font-bold">Surat Pengantar (PDF)</label>
                <input id="suratPengantar" name="suratPengantar" type="file" accept=".pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900 @error('suratPengantar') text-rose-600 @enderror" />
                @error('suratPengantar')
                    <p class="text-[11px] text-rose-700 mt-1 font-semibold">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="proposal" class="text-xs font-bold">Proposal (opsional)</label>
                <input id="proposal" name="proposal" type="file" accept=".pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900 @error('proposal') text-rose-600 @enderror" />
                @error('proposal')
                    <p class="text-[11px] text-rose-700 mt-1 font-semibold">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <!-- Statement + Actions -->
          <div class="pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">5) Pernyataan & Keamanan</h3>
            <label class="mt-2 flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-3">
              <input id="pernyataan" name="pernyataan" type="checkbox" required class="mt-1 accent-emerald-700" />
              <span class="text-xs text-slate-700">
                Saya menyatakan data yang diisikan benar dan bersedia mematuhi tata tertib di lingkungan Kejaksaan Negeri Kabupaten Tegal.
              </span>
            </label>

            <!-- Captcha Section -->
            <div class="mt-4 p-4 bg-white border border-slate-200 rounded-2xl max-w-sm">
              <label for="captcha" class="text-xs font-bold block mb-2">
                Verifikasi Keamanan <span class="text-rose-700">*</span>
              </label>
              <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-3">
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 flex-shrink-0 [&>img]:max-w-full [&>img]:h-auto" id="captcha-container">
                  {!! captcha_img('flat') !!}
                </div>
                <button type="button" id="btnRefreshCaptcha" class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition self-start sm:self-center border border-transparent hover:border-emerald-200" title="Muat ulang Captcha">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
              </div>
              <input type="text" id="captcha" name="captcha" required placeholder="Masukkan karakter di atas"
                     class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              <p class="text-[11px] text-slate-500 mt-2">Ketik karakter yang muncul pada gambar untuk membuktikan Anda bukan robot.</p>
            </div>

            <div class="mt-3 flex flex-wrap gap-2">
              <button id="btnSubmit" class="btn bg-emerald-700 text-white font-extrabold px-6 py-2 rounded-xl hover:bg-emerald-800 transition disabled:opacity-50 disabled:cursor-not-allowed" type="submit" disabled>Kirim Pengajuan</button>
            </div>
          </div>
        </form>
      </section>
    </div>
  </main>

  <x-footer />

  <script>
    // ===== UI Helpers =====
    const $ = (id)=>document.getElementById(id);
    const statusPengajuan = $("statusPengajuan");
    const mandiriSection = $("mandiriSection");
    const institusiSection = $("institusiSection");
    const form = $("magangForm");
    const btnSubmit = $("btnSubmit");

    function toggleSections(){
      const v = statusPengajuan.value;
      const requiredIds = ["institusi","fakultas","semester","pembimbing","kontakPembimbing","jumlahPeserta"];
      const dataPemohonRequiredIds = ["nama", "kontakHp", "email", "nik", "tglLahir", "alamat"];
      const dataPemohonSection = $("dataPemohonSection");

      if(v === "mandiri"){
        mandiriSection.classList.remove("hidden");
        institusiSection.classList.add("hidden");
        if(dataPemohonSection) dataPemohonSection.classList.remove("hidden");
        requiredIds.forEach(id => $(id).required = false);
        dataPemohonRequiredIds.forEach(id => { if($(id)) $(id).required = true; });
      } else if(v === "institusi" || v === "kejuruan"){
        institusiSection.classList.remove("hidden");
        mandiriSection.classList.add("hidden");
        if(dataPemohonSection) dataPemohonSection.classList.remove("hidden");
        requiredIds.forEach(id => $(id).required = true);
        dataPemohonRequiredIds.forEach(id => { if($(id)) $(id).required = true; });
      } else {
        mandiriSection.classList.add("hidden");
        institusiSection.classList.add("hidden");
        if(dataPemohonSection) dataPemohonSection.classList.remove("hidden");
        requiredIds.forEach(id => $(id).required = false);
        dataPemohonRequiredIds.forEach(id => { if($(id)) $(id).required = true; });
      }

      if(btnSubmit) btnSubmit.disabled = !v;
    }

    function validateCustom(){
      const errs = [];
      if(!statusPengajuan.value) errs.push("Status pengajuan wajib dipilih.");

      const tglLahirValue = $("tglLahir").value;
      if (tglLahirValue) {
        const dob = new Date(tglLahirValue);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        if (age < 17) {
            errs.push("Usia minimal pendaftar adalah 17 tahun.");
        }
      }

      const tglMulaiValue = $("tglMulai").value;
      const tglSelesaiValue = $("tglSelesai").value;

      if (tglMulaiValue) {
        const tglMulai = new Date(tglMulaiValue);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Compare date part only

        if (tglMulai < today) {
            errs.push("Tanggal mulai tidak boleh tanggal yang sudah lewat.");
        }

        if (tglSelesaiValue) {
            const tglSelesai = new Date(tglSelesaiValue);
            const minEndDate = new Date(tglMulai);
            minEndDate.setMonth(minEndDate.getMonth() + 1);

            if (tglSelesai < minEndDate) {
                errs.push("Tanggal selesai minimal 1 bulan dari tanggal mulai.");
            }
        }
      }
      return errs;
    }

    // ===== Events =====
    statusPengajuan.addEventListener("change", ()=>{
      toggleSections();
    });

    $("tglMulai").addEventListener('change', function() {
        const tglSelesaiInput = $("tglSelesai");
        if (this.value) {
            const startDate = new Date(this.value);
            startDate.setMonth(startDate.getMonth() + 1);

            const year = startDate.getFullYear();
            const month = ('0' + (startDate.getMonth() + 1)).slice(-2);
            const day = ('0' + startDate.getDate()).slice(-2);
            const minEndDateString = `${year}-${month}-${day}`;

            tglSelesaiInput.min = minEndDateString;
        } else {
            tglSelesaiInput.min = '';
        }
    });

    // ===== File Validation =====
    function validateFile(input) {
      if (!input.files || !input.files[0]) return;
      const file = input.files[0];
      const maxSize = 10 * 1024 * 1024; // 10MB

      if (file.size > maxSize) {
        alert("Ukuran file terlalu besar! Maksimal 10MB.");
        input.value = "";
        return;
      }

      const accept = input.getAttribute("accept");
      if (accept) {
        const allowed = accept.split(",").map(x => x.trim().toLowerCase());
        const fileName = file.name.toLowerCase();
        const isAllowed = allowed.some(type => fileName.endsWith(type));
        
        if (!isAllowed) {
          alert("Format file tidak sesuai! Harap unggah file dengan format: " + accept);
          input.value = "";
        }
      }
    }

    document.querySelectorAll('input[type="file"]').forEach(el => {
      el.addEventListener("change", () => validateFile(el));
    });

    // ===== Captcha Refresh =====
    if ($("btnRefreshCaptcha")) {
      $("btnRefreshCaptcha").addEventListener("click", function() {
        const img = document.querySelector("#captcha-container img");
        if (img) img.src = img.src.split('?')[0] + '?' + Math.random();
      });
    }

    form.addEventListener("submit", (e) => {
      if (!form.checkValidity()) {
        e.preventDefault();
        alert("Mohon lengkapi semua kolom yang wajib diisi dan unggah dokumen yang diperlukan.");
        return;
      }

      const errs = validateCustom();
      if (errs.length > 0) {
        e.preventDefault();
        alert("Terdapat kesalahan:\n" + errs.map((x, i) => `${i + 1}. ${x}`).join("\n"));
      }
    });

    // init
    toggleSections();
  </script>
</body>
</html>