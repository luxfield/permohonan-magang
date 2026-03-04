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
        <div class="h-11 w-11 rounded-xl bg-white/15 grid place-items-center font-extrabold">KN</div>
        <div>
          <h1 class="text-base sm:text-lg font-bold leading-tight">
            Form Pengajuan Pemagangan — Kejaksaan Negeri
          </h1>
          <p class="text-xs sm:text-sm text-white/90 mt-1">
            Silahkan isi data diri anda dengan benar.
          </p>
        </div>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 py-4 sm:py-6">
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
                  <option value="institusi">Magang Bidang Umum & Teknis (Mahasiswa/Siswa SMK/MAK):</option>
                </select>
                <p class="text-[11px] text-slate-500 mt-1">Akan memunculkan persyaratan sesuai jalur.</p>
              </div>

            </div>
          </div>

          <!-- Section 2 -->
          <div class="pt-4 border-t border-dashed border-slate-200">
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
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
              <div>
                <label for="ktpMandiri" class="text-xs font-bold">KTP / NIS / NIM (JPG/PNG/PDF)</label>
                <input id="ktpMandiri" name="ktpMandiri" type="file" accept=".jpg,.jpeg,.png,.pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
              <div>
                <label for="fotoMandiri" class="text-xs font-bold">Pas Foto (JPG/PNG)</label>
                <input id="fotoMandiri" name="fotoMandiri" type="file" accept=".jpg,.jpeg,.png"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
            </div>
          </div>

          <!-- Section 4B: Institusi -->
          <div id="institusiSection" class="hidden pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">4B) Jalur Institusi</h3>

            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label for="institusi" class="text-xs font-bold">Nama Institusi <span class="text-rose-700">*</span></label>
                <input id="institusi" name="institusi"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500" />
              </div>
              <div>
                <label for="nim" class="text-xs font-bold">NIM/NIS <span class="text-rose-700">*</span></label>
                <input id="nim" name="nim"
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
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
              <div>
                <label for="transkrip" class="text-xs font-bold">Transkrip/Raport (PDF)</label>
                <input id="transkrip" name="transkrip" type="file" accept=".pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
              <div>
                <label for="fotoInstitusi" class="text-xs font-bold">Pas Foto (JPG/PNG)</label>
                <input id="fotoInstitusi" name="fotoInstitusi" type="file" accept=".jpg,.jpeg,.png"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
              <div>
                <label for="proposal" class="text-xs font-bold">Proposal (opsional)</label>
                <input id="proposal" name="proposal" type="file" accept=".pdf"
                       class="mt-1 w-full text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900/5 file:px-3 file:py-2 file:font-bold file:text-slate-900" />
              </div>
            </div>
          </div>

          <!-- Statement + Actions -->
          <div class="pt-4 border-t border-dashed border-slate-200">
            <h3 class="text-sm font-bold">5) Pernyataan</h3>
            <label class="mt-2 flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-3">
              <input id="pernyataan" name="pernyataan" type="checkbox" required class="mt-1 accent-emerald-700" />
              <span class="text-xs text-slate-700">
                Saya menyatakan data yang diisikan benar dan bersedia mematuhi tata tertib di lingkungan Kejaksaan Negeri.
              </span>
            </label>

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
    const getChecked = (name) => {
        const els = document.querySelectorAll(`input[name="${name}"], input[name="${name}[]"]`);
        return Array.from(els).filter(e => e.checked).map(e => e.value);
    };
    const statusPengajuan = $("statusPengajuan");
    const mandiriSection = $("mandiriSection");
    const institusiSection = $("institusiSection");
    const form = $("magangForm");
    const btnSubmit = $("btnSubmit");

    function toggleSections(){
      const v = statusPengajuan.value;
      const requiredIds = ["institusi","nim","fakultas","semester","pembimbing","kontakPembimbing","jumlahPeserta"];
      if(v === "mandiri"){
        mandiriSection.classList.remove("hidden");
        institusiSection.classList.add("hidden");
        requiredIds.forEach(id => $(id).required = false);
      } else if(v === "institusi"){
        institusiSection.classList.remove("hidden");
        mandiriSection.classList.add("hidden");
        requiredIds.forEach(id => $(id).required = true);
      } else {
        mandiriSection.classList.add("hidden");
        institusiSection.classList.add("hidden");
        requiredIds.forEach(id => $(id).required = false);
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

    function buildPayload(){
      const fd = new FormData(form);
      const status = (fd.get("statusPengajuan") || "").toString();

      const payload = {
        status,
        nama: (fd.get("nama") || "").toString(),
        hp: (fd.get("kontakHp") || "").toString(),
        email: (fd.get("email") || "").toString(),
        nik: (fd.get("nik") || "").toString(),
        tglLahir: (fd.get("tglLahir") || "").toString(),
        alamat: (fd.get("alamat") || "").toString(),
        tglMulai: (fd.get("tglMulai") || "").toString(),
        tglSelesai: (fd.get("tglSelesai") || "").toString(),
        tujuan: (fd.get("tujuan") || "").toString(),
        jalur: {}
      };

      if(status === "mandiri"){
        payload.jalur = {
          pendidikanAsal: (fd.get("pendidikanAsal_m") || "").toString(),
          prodi: (fd.get("prodi_m") || "").toString(),
          files: {
            suratPermohonan: fileMeta(fd.get("suratMandiri")),
            cv: fileMeta(fd.get("cvMandiri")),
            ktp: fileMeta(fd.get("ktpMandiri")),
            foto: fileMeta(fd.get("fotoMandiri")),
          }
        };
      } else if(status === "institusi"){
        payload.jalur = {
          institusi: (fd.get("institusi") || "").toString(),
          nim: (fd.get("nim") || "").toString(),
          fakultas: (fd.get("fakultas") || "").toString(),
          semester: (fd.get("semester") || "").toString(),
          pembimbing: (fd.get("pembimbing") || "").toString(),
          kontakPembimbing: (fd.get("kontakPembimbing") || "").toString(),
          jumlahPeserta: (fd.get("jumlahPeserta") || "").toString(),
          files: {
            suratPengantar: fileMeta(fd.get("suratPengantar")),
            cv: fileMeta(fd.get("cvInstitusi")),
            transkrip: fileMeta(fd.get("transkrip")),
            foto: fileMeta(fd.get("fotoInstitusi")),
            proposal: fileMeta(fd.get("proposal")),
          }
        };
      }

      return payload;
    }

    function matchSearch(rec, q){
      if(!q) return true;
      const hay = [
        rec.nama, rec.email, rec.hp,
        rec.jalur?.institusi, rec.jalur?.pendidikanAsal, rec.jalur?.fakultas
      ].filter(Boolean).join(" ").toLowerCase();
      return hay.includes(q.toLowerCase());
    }

    function escapeHtml(s){
      return s.replace(/[&<>"']/g, m => ({
        "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
      }[m]));
    }

    function renderList(records){
      if(!records.length){
        listWrap.innerHTML = `<div class="text-slate-600">Belum ada data.</div>`;
        debug.textContent = "{}";
        return;
      }

      const sFilter = filterStatus.value;
      const q = searchText.value.trim();

      const filtered = records
        .filter(r => !sFilter || r.status === sFilter)
        .filter(r => matchSearch(r, q));

      if(!filtered.length){
        listWrap.innerHTML = `<div class="text-slate-600">Tidak ada hasil untuk filter/pencarian saat ini.</div>`;
        return;
      }

      debug.textContent = JSON.stringify(filtered[0], null, 2);

      listWrap.innerHTML = filtered.map(r => {
        const badge = r.status === "mandiri"
          ? `<span class="text-[11px] font-semibold rounded-full border border-emerald-200 bg-emerald-50 text-emerald-800 px-2.5 py-1">MANDIRI</span>`
          : `<span class="text-[11px] font-semibold rounded-full border border-sky-200 bg-sky-50 text-sky-800 px-2.5 py-1">INSTITUSI</span>`;

        const extra = r.status === "institusi"
          ? `Institusi: ${r.jalur?.institusi || "-"}`
          : `Asal: ${r.jalur?.pendidikanAsal || "-"}`;

        return `
          <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-3">
            <div class="flex flex-wrap items-start justify-between gap-2">
              <div>
                <div class="flex items-center gap-2">
                  <div class="font-extrabold">#${r.id}</div>
                  ${badge}
                </div>
                <div class="text-[11px] text-slate-500 mt-0.5">${new Date(r.createdAt).toLocaleString("id-ID")}</div>
              </div>
              <div class="flex flex-wrap gap-2">
                <button class="border border-slate-200 bg-white px-3 py-2 rounded-xl font-extrabold text-xs" data-view="${r.id}">Detail</button>
                <button class="border border-rose-200 bg-white text-rose-700 px-3 py-2 rounded-xl font-extrabold text-xs" data-del="${r.id}">Hapus</button>
              </div>
            </div>

            <div class="mt-2">
              <div class="font-bold">${r.nama} <span class="font-normal text-slate-600">— ${r.email}</span></div>
              <div class="text-xs text-slate-500 mt-1">${extra}</div>
            </div>

            <div id="detail-${r.id}" class="hidden mt-3">
              <details open class="rounded-2xl border border-slate-200 bg-white p-3">
                <summary class="cursor-pointer font-extrabold text-sm">Detail Pengajuan</summary>
                <pre class="mt-3 rounded-2xl bg-slate-900 text-slate-100 text-xs p-3 overflow-auto">${escapeHtml(JSON.stringify(r, null, 2))}</pre>
              </details>
            </div>
          </div>
        `;
      }).join("");

      // bind
      listWrap.querySelectorAll("button[data-del]").forEach(btn=>{
        btn.addEventListener("click", async ()=>{
          const id = Number(btn.getAttribute("data-del"));
          const ok = confirm(`Hapus data #${id}?`);
          if(!ok) return;
          await deleteById(id);
          await refresh();
        });
      });

      listWrap.querySelectorAll("button[data-view]").forEach(btn=>{
        btn.addEventListener("click", ()=>{
          const id = btn.getAttribute("data-view");
          document.getElementById(`detail-${id}`).classList.toggle("hidden");
        });
      });
    }

    async function refresh(){
      const rows = await listNewest();
      renderList(rows);
    }

    function downloadText(filename, content, type="application/json"){
      const blob = new Blob([content], {type});
      const a = document.createElement("a");
      a.href = URL.createObjectURL(blob);
      a.download = filename;
      a.click();
      URL.revokeObjectURL(a.href);
    }

    function toCSV(rows){
      const header = ["id","createdAt","status","nama","hp","email","nik","tglLahir","tglMulai","tglSelesai","institusi_or_asal"];
      const lines = [header.join(",")];
      for(const r of rows){
        const instOrAsal = r.status === "institusi" ? (r.jalur?.institusi || "") : (r.jalur?.pendidikanAsal || "");
        const values = [
          r.id, r.createdAt, r.status, r.nama||"", r.hp||"", r.email||"", r.nik||"", r.tglLahir||"",
          r.tglMulai||"", r.tglSelesai||"", instOrAsal
        ].map(x => `"${String(x).replaceAll('"','""')}"`);
        lines.push(values.join(","));
      }
      return lines.join("\n");
    }

    // ===== Events =====
    statusPengajuan.addEventListener("change", ()=>{
      // hide(msg);
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

    if($("btnResetForm")) $("btnResetForm").addEventListener("click", ()=>{
      form.reset();
      // hide(msg);
      toggleSections();
    });

    if($("btnRefresh")) $("btnRefresh").addEventListener("click", refresh);
    if(typeof filterStatus !== 'undefined') filterStatus.addEventListener("change", refresh);

    if(typeof searchText !== 'undefined') searchText.addEventListener("input", ()=>{
      clearTimeout(window.__t);
      window.__t = setTimeout(refresh, 150);
    });

    if($("btnResetDb")) $("btnResetDb").addEventListener("click", async ()=>{
      const ok = confirm("Reset DB akan menghapus semua data demo pada browser ini. Lanjutkan?");
      if(!ok) return;
      await clearAll();
      await refresh();
    });

    if($("btnExportJson")) $("btnExportJson").addEventListener("click", async ()=>{
      const rows = await listNewest();
      downloadText("pengajuan-kejari-demo.json", JSON.stringify(rows, null, 2), "application/json");
    });

    if($("btnExportCsv")) $("btnExportCsv").addEventListener("click", async ()=>{
      const rows = await listNewest();
      downloadText("pengajuan-kejari-demo.csv", toCSV(rows), "text/csv");
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

    // form.addEventListener("submit", async (e)=>{
    //   e.preventDefault();
    //   hide(msg);
    //
    //   if(!form.checkValidity()){
    //     form.reportValidity();
    //     setStatus("err","Mohon lengkapi kolom yang wajib diisi.");
    //     return;
    //   }
    //
    //   const errs = validateCustom();
    //   if(errs.length){
    //     setStatus("err", errs.map((x,i)=>`${i+1}. ${x}`).join("\n"));
    //     return;
    //   }
    //
    //   const payload = buildPayload();
    //   const newId = await addRecord(payload);
    //
    //   setStatus("ok", `Tersimpan (demo) ke IndexedDB. ID: #${newId}`);
    //   form.reset();
    //   toggleSections();
    //   await refresh();
    // });

    // init
    toggleSections();
    // refresh();
  </script>
</body>
</html>
</body>
</html>