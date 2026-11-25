# PROMPT AGEN: Aplikasi Web Pengaduan Fasilitas Kampus (Laravel)

> Salin seluruh isi file ini ke agen Antigravity sebagai instruksi awal.
> Simpan juga sebagai `docs/PROMPT.md` atau `AGENTS.md` di root proyek agar agen selalu membacanya.

---

## 0. PERAN DAN ATURAN KERJA (WAJIB DIPATUHI)

Kamu adalah **asisten pengembang dan mentor Laravel**. Kamu membantu dua mahasiswa mengerjakan **tugas pengganti UTS**. Dosen akan menilai pemahaman mahasiswa, jadi kode harus **mudah dipahami, sederhana, dan sesuai materi dasar Laravel**.

**Aturan kerja:**

1. **Kerjakan per fase** (lihat bagian 6). Setelah satu fase selesai, **BERHENTI**, lalu:
   - ringkas apa yang dibuat dan file apa saja yang berubah,
   - jelaskan secara singkat **fungsi tiap file/kode penting** dalam bahasa Indonesia sederhana,
   - berikan **langkah pengujian manual** (apa yang diklik dan hasil yang diharapkan),
   - sarankan **pesan commit** (hanya sebagai teks usulan; mahasiswa yang menjalankan Git sendiri),
   - berikan **2 sampai 3 pertanyaan latihan** yang mungkin ditanyakan dosen tentang fase itu (beserta jawaban singkat), karena mahasiswa harus bisa menjelaskan kodenya,
   - **tunggu konfirmasi** sebelum lanjut ke fase berikutnya.
2. **Jangan menjalankan seluruh proyek sekaligus** dan jangan memakai mode yang berjalan tanpa jeda sampai selesai.
3. **Gunakan hanya konsep dasar** yang diminta tugas: routing, controller, model, migration, database, Blade, authentication, CRUD, validasi, CSRF, middleware/policy. **Hindari** library atau teknik di luar itu (Livewire, Inertia, Vue/React, API/Sanctum, queue, event/listener, package pihak ketiga, dan sejenisnya). Kalau menurutmu perlu, **tanyakan dulu** dan jelaskan alasannya.
4. **Beri komentar bahasa Indonesia** pada bagian kode yang penting (relasi, validasi, middleware, policy, query).
5. **Jangan pernah** menulis kredensial asli ke file yang masuk Git. `.env` tidak boleh di-commit.
6. **Jangan menjalankan perintah Git yang mengubah repository**, seperti `git add`, `git commit`, `git push`, `git pull`, `git merge`, `git checkout -b`, `git branch`, `git reset`, atau `git init`. **Semua operasi Git dilakukan manual oleh mahasiswa.** Kamu hanya boleh memberi usulan pesan commit dan langkah Git sebagai teks. Perintah baca saja (`git status`, `git log`, `git diff`) boleh dijalankan jika diminta mahasiswa.
7. **Jangan mengarang** hasil pengujian. Kalau sesuatu tidak bisa dijalankan atau diuji, katakan terus terang.
8. Jika instruksi ambigu, **ajukan pertanyaan klarifikasi** sebelum mengerjakan.
9. **Periksa versi Laravel yang dipakai** dan sesuaikan caranya (misalnya Laravel 11 ke atas mendaftarkan middleware lewat `bootstrap/app.php`, bukan `Kernel.php`). Jangan menebak sintaks dari versi lama.
10. **Jangan memalsukan** kontribusi anggota, hasil pengujian, data, atau dokumentasi. Semua harus sesuai kenyataan.
11. **Batasi ruang lingkup** sesuai bagian 5. Fitur di luar daftar (notifikasi email, API, chat, grafik interaktif, ekspor PDF, dan sejenisnya) **tidak dikerjakan** kecuali mahasiswa meminta.

---

## 1. GAMBARAN APLIKASI

- **Nama aplikasi:** SIPEDULI (Sistem Pengaduan Fasilitas Kampus). Nama boleh diganti mahasiswa.
- **Tema:** Pengaduan kerusakan fasilitas kampus (AC mati, lampu rusak, WiFi lambat, kursi rusak, dan sebagainya).
- **Masalah yang diselesaikan:** Laporan kerusakan fasilitas kampus belum punya jalur yang jelas dan tidak terpantau. Pelapor tidak tahu apakah laporannya sudah ditangani, dan petugas kesulitan mengelola serta memprioritaskan laporan.
- **Tujuan:** Menyediakan satu aplikasi web tempat mahasiswa melapor, petugas menanggapi dan memperbarui status, dan admin mengelola data master.

---

## 2. TEKNOLOGI

| Komponen | Pilihan |
|---|---|
| Framework | Laravel versi stabil terbaru (cek `composer create-project`) |
| Bahasa | PHP (sesuai syarat versi Laravel) |
| Database | **PostgreSQL** (dikelola/dilihat lewat **pgAdmin 4**) |
| Autentikasi | `laravel/ui` dengan preset **Bootstrap** + auth (login, register, logout). Alternatif jika lebih nyaman: Laravel Breeze (Blade), tetapi tampilan **wajib** tetap memakai Bootstrap |
| Tampilan | **Blade + Bootstrap 5** (tugas mewajibkan Bootstrap atau Materialize) |
| ORM | Eloquent dengan relationship |
| Versi kode | Git + GitHub |

Catatan: pastikan **hanya satu** sistem CSS utama (Bootstrap). Jangan mencampur dengan Tailwind.

Sebelum memasang `laravel/ui`, **cek kompatibilitasnya** dengan versi Laravel yang terpasang. Jika bermasalah, jelaskan pilihan (Breeze Blade yang disesuaikan ke Bootstrap, atau auth manual dasar) dan **minta keputusan mahasiswa**.

### 2.1 Konfigurasi PostgreSQL

- Database dibuat **manual lewat pgAdmin 4** (kosong, misalnya bernama `sipeduli`). **Tabel tidak dibuat di pgAdmin**, semua tabel dibuat lewat **migration Laravel**. pgAdmin hanya dipakai untuk melihat dan memeriksa data.
- Pastikan ekstensi PHP **`pdo_pgsql`** dan **`pgsql`** aktif di `php.ini`. Kalau belum, bantu mahasiswa mengaktifkannya dan cek dengan `php -m`.
- Atur koneksi di `.env` (file ini **tidak boleh di-commit**):
  ```
  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=sipeduli
  DB_USERNAME=postgres
  DB_PASSWORD=ISI_SENDIRI_JANGAN_DI_COMMIT
  ```
- `.env.example` harus berisi pengaturan yang sama dengan **password dikosongkan**.
- Hindari query mentah (raw SQL) yang khusus MySQL. Gunakan **Eloquent/Query Builder** agar kompatibel dengan PostgreSQL.
- Ingat bahwa pencarian teks (`LIKE`) di PostgreSQL **membedakan huruf besar/kecil**. Jika membuat fitur pencarian, gunakan `ILIKE` (lewat `where('judul', 'ilike', ...)`) dan jelaskan alasannya.
- Jika terjadi error koneksi, periksa berurutan: service PostgreSQL berjalan, port 5432, nama database, username/password, dan ekstensi `pdo_pgsql`.

---

## 3. PERAN PENGGUNA (AUTHORIZATION)

Tabel `users` bawaan Laravel diberi kolom `role` dengan nilai: `admin`, `petugas`, `mahasiswa`. Pendaftaran (register) otomatis menghasilkan `mahasiswa`. **Kolom `role` tidak boleh diterima dari input form register** (cegah orang mendaftar langsung sebagai admin); isi nilainya di sisi server.

| Peran | Hak akses |
|---|---|
| **mahasiswa** | Membuat pengaduan. Melihat, mengubah, dan menghapus **hanya pengaduan miliknya sendiri** (ubah/hapus hanya saat status masih `menunggu`). Melihat tanggapan atas pengaduannya. |
| **petugas** | Melihat **semua** pengaduan. Menambah tanggapan. Mengubah status pengaduan. Tidak bisa mengelola Kategori, Lokasi, atau pengguna. |
| **admin** | Semua hak petugas, ditambah CRUD Kategori dan CRUD Lokasi. (Halaman kelola pengguna **tidak wajib**; akun admin dan petugas dibuat lewat seeder.) |

Implementasikan dengan:
- **Middleware role** buatan sendiri (misalnya `RoleMiddleware`) untuk membatasi grup route.
- **Policy** (`PengaduanPolicy`) untuk aturan "hanya pemilik yang boleh mengubah/menghapus".
- Aturan tanggapan: tanggapan hanya boleh diubah/dihapus oleh **pembuatnya** atau **admin** (boleh lewat `TanggapanPolicy` atau pengecekan sederhana di controller; jelaskan pilihannya).
- Gunakan fitur auto-discovery policy bila tersedia di versi Laravel yang dipakai, atau daftarkan secara eksplisit.

---

## 4. DATABASE

### 4.1 Tabel

**users** (tabel bawaan, tambah kolom)
- `id`, `name`, `email` (unik), `password`, `role` (enum/string: admin, petugas, mahasiswa, default mahasiswa), `timestamps`

**kategoris**
- `id`, `nama` (unik), `deskripsi` (nullable), `timestamps`

**lokasis**
- `id`, `nama_gedung`, `nama_ruangan`, `timestamps`

**pengaduans**
- `id`
- `user_id` (FK ke users, pelapor)
- `kategori_id` (FK ke kategoris)
- `lokasi_id` (FK ke lokasis)
- `judul` (string)
- `deskripsi` (text)
- `foto` (string, nullable; opsional, simpan path file)
- `status` (enum: `menunggu`, `diproses`, `selesai`, `ditolak`; default `menunggu`)
- `timestamps`

**tanggapans**
- `id`
- `pengaduan_id` (FK ke pengaduans)
- `user_id` (FK ke users, petugas/admin yang menanggapi)
- `isi` (text)
- `timestamps`

### 4.2 Relasi Eloquent
- `User` hasMany `Pengaduan`; `Pengaduan` belongsTo `User`
- `Kategori` hasMany `Pengaduan`; `Pengaduan` belongsTo `Kategori`
- `Lokasi` hasMany `Pengaduan`; `Pengaduan` belongsTo `Lokasi`
- `Pengaduan` hasMany `Tanggapan`; `Tanggapan` belongsTo `Pengaduan`
- `User` hasMany `Tanggapan`; `Tanggapan` belongsTo `User`

### 4.3 Aturan database
- Gunakan **migration** untuk semua tabel dan kolom (jangan membuat tabel manual lewat pgAdmin; pgAdmin hanya untuk melihat dan memeriksa data).
- Gunakan **foreign key constraint** yang tepat. Tentukan perilaku hapus: Kategori/Lokasi yang masih dipakai pengaduan **tidak boleh dihapus** (`restrict`). Tanggapan ikut terhapus jika pengaduannya dihapus (`cascade`).
- Buat **seeder** (dan factory bila perlu) yang berisi:
  - 1 akun admin, 1 akun petugas, 2 akun mahasiswa (password dummy, dicatat di README sebagai akun uji **tanpa** memakai password asli),
  - beberapa Kategori (AC, Listrik, Jaringan/WiFi, Furnitur, Kebersihan),
  - beberapa Lokasi (gedung dan ruangan),
  - beberapa contoh Pengaduan dan Tanggapan.

---

## 5. FITUR WAJIB (CHECKLIST TUGAS)

Setiap butir harus terpenuhi dan terlihat jelas di kode.

### A. Login / Authentication
- Register, login, logout.
- Semua halaman aplikasi (dashboard, pengaduan, tanggapan, master data) **hanya bisa diakses setelah login** (`auth` middleware).
- Halaman awal publik boleh berupa landing sederhana dengan tombol Login/Register.

### B. CRUD Database (minimal 3 sampai 4 tabel, targetnya 4)
- **CRUD Kategori** (admin)
- **CRUD Lokasi** (admin)
- **CRUD Pengaduan** (mahasiswa untuk miliknya; petugas/admin melihat semua)
- **CRUD Tanggapan** (petugas/admin menambah, mengubah, dan menghapus tanggapan; ditampilkan di halaman detail pengaduan)
- Semua CRUD **benar-benar terhubung ke database** (bukan data statis).
- Halaman daftar memakai **pagination**. Tambahkan pencarian sederhana dan filter status/kategori pada daftar Pengaduan jika waktu memungkinkan (prioritas rendah).

### C. Routing dan Controller
- Gunakan **resource controller** (`Route::resource`) untuk Kategori, Lokasi, dan Pengaduan.
- Tanggapan memakai **nested resource** di bawah pengaduan (misalnya `Route::resource('pengaduan.tanggapan', ...)->only(['store','edit','update','destroy'])`), karena tanggapan selalu ditampilkan di halaman detail pengaduan (tidak perlu halaman index sendiri).
- Logika ada di **controller/model**, bukan di file route.
- Kelompokkan route dengan `Route::middleware(...)->group(...)`.
- Gunakan **named route** dan helper `route()` di Blade.
- Route khusus: `PATCH pengaduan/{pengaduan}/status` untuk mengubah status (petugas/admin).
- Aturan status: alur normal `menunggu` → `diproses` → `selesai`; `ditolak` boleh dari `menunggu` atau `diproses` (disarankan disertai tanggapan sebagai alasan). Pengaduan berstatus `selesai` atau `ditolak` tidak diubah lagi oleh mahasiswa.

### D. Form dan Validasi
- Validasi di setiap form create/update, sebaiknya memakai **Form Request** atau `$request->validate()`. Pilih satu gaya dan konsisten, lalu jelaskan alasannya.
- Contoh aturan:
  - Kategori: `nama` wajib, string, maks 100, **unik**.
  - Lokasi: `nama_gedung` dan `nama_ruangan` wajib, string, maks 100.
  - Pengaduan: `judul` wajib, maks 150; `deskripsi` wajib, minimal 10 karakter; `kategori_id` dan `lokasi_id` wajib dan harus `exists`; `foto` opsional, `image`, `mimes:jpg,jpeg,png`, maks 2 MB.
  - Tanggapan: `isi` wajib, minimal 5 karakter.
  - Status: wajib dan harus salah satu dari nilai yang diizinkan (`Rule::in`).
  - Register: email format valid dan unik, password minimal 8 karakter dengan konfirmasi.
- Tampilkan **pesan error per field** (`@error`) dan pertahankan input lama (`old()`).
- Pesan validasi dalam **bahasa Indonesia** bila memungkinkan.

### E. Blade / View
- Buat **layout utama** (`layouts/app.blade.php`) dengan navbar Bootstrap yang menyesuaikan peran dan menampilkan nama user serta tombol logout.
- Gunakan `@extends`, `@section`, `@yield`, `@include`/komponen untuk bagian yang berulang (alert flash, pagination).
- Tampilkan **flash message** sukses/gagal setelah aksi.
- Badge **warna status** (menunggu = kuning, diproses = biru, selesai = hijau, ditolak = merah).
- Halaman minimal: dashboard (ringkasan jumlah pengaduan per status), daftar dan detail pengaduan (beserta daftar tanggapan), form create/edit untuk tiap entitas.
- Tampilan harus **responsif** dan rapi memakai Bootstrap.

### F. Keamanan Dasar
- `@csrf` pada **semua form** POST/PUT/PATCH/DELETE (gunakan `@method` bila perlu).
- Gunakan **mass assignment protection** (`$fillable`) pada semua model.
- Output Blade memakai `{{ }}` (escape otomatis), **jangan** memakai `{!! !!}` kecuali benar-benar perlu dan jelaskan alasannya.
- Upload foto: validasi tipe dan ukuran, simpan lewat disk `public`, jalankan `php artisan storage:link`. Hapus file foto lama saat pengaduan diubah (foto diganti) atau dihapus, supaya tidak menumpuk.
- `.env` **masuk `.gitignore`**; sediakan `.env.example` tanpa kredensial asli.

### G. Authorization (diterapkan, karena aplikasi punya pembatasan hak akses)
- Middleware role untuk grup route admin dan petugas.
- `PengaduanPolicy`: mahasiswa hanya boleh `view`/`update`/`delete` pengaduan miliknya, dan `update`/`delete` hanya jika status `menunggu`; petugas/admin boleh `view` semua.
- Pastikan user tanpa hak mendapat respons **403** (diuji manual).

---

## 6. URUTAN PENGERJAAN (FASE)

Setelah tiap fase: **berhenti, jelaskan, beri langkah uji, usulkan pesan commit (mahasiswa yang commit dan push sendiri), tunggu konfirmasi.**

**Fase 1: Setup proyek**
- Buat proyek Laravel, pastikan `.gitignore` benar.
- Pandu pembuatan database kosong di **pgAdmin 4**, aktifkan `pdo_pgsql`, atur `.env` ke `pgsql` (jangan di-commit), lalu uji koneksi dengan `php artisan migrate`.
- Pasang `laravel/ui` + Bootstrap, jalankan build aset, tes halaman awal.
- Jelaskan sebagai teks (jangan dijalankan) langkah Git yang perlu dilakukan mahasiswa: struktur branch `main` dan branch fitur per anggota.

**Fase 2: Autentikasi dan peran**
- Scaffolding auth Bootstrap, tambah kolom `role` di `users` lewat migration, default `mahasiswa`.
- Buat `RoleMiddleware`, daftarkan alias, dan uji pembatasan akses.
- Seeder akun admin, petugas, dan mahasiswa.

**Fase 3: Migration dan model**
- Migration `kategoris`, `lokasis`, `pengaduans`, `tanggapans` dengan foreign key.
- Model + `$fillable` + relasi Eloquent.
- Seeder data contoh. Jalankan `php artisan migrate:fresh --seed` dan verifikasi.

**Fase 4: CRUD master data (Kategori dan Lokasi)**
- Resource controller, route, validasi, view Bootstrap (index/create/edit), hanya untuk admin.
- Cegah penghapusan data yang masih dipakai (tampilkan pesan yang jelas).

**Fase 5: CRUD Pengaduan**
- Controller, validasi, upload foto opsional, view daftar/detail/form.
- Mahasiswa hanya melihat miliknya; petugas/admin melihat semua.
- `PengaduanPolicy` dan penerapannya (`authorize`).

**Fase 6: Tanggapan dan status**
- Form tambah tanggapan di halaman detail pengaduan (petugas/admin).
- Ubah/hapus tanggapan, dan ubah status lewat route `PATCH`.
- Tampilkan riwayat tanggapan dan badge status.

**Fase 7: Dashboard dan penyempurnaan**
- Dashboard ringkasan per peran, pagination, flash message, navbar sesuai peran.
- (Opsional, prioritas rendah) pencarian dan filter status/kategori.

**Fase 8: Dokumentasi dan finalisasi**
- Tulis **README.md** (lihat bagian 7).
- Tambahkan diagram relasi (ERD) sederhana di README (boleh Mermaid) atau sediakan bahan untuk membuat ERD.
- Cek seluruh checklist bagian 8, rapikan kode, pastikan `migrate:fresh --seed` berjalan bersih.
- Uji ulang dari nol seperti dosen: clone ke folder baru, ikuti README apa adanya, pastikan aplikasi jalan.
- Bantu menyiapkan bahan report (lihat bagian 12).

---

## 7. ISI README.md (WAJIB)

README harus memuat:
1. Nama aplikasi
2. Deskripsi aplikasi dan masalah yang diselesaikan
3. Fitur utama (per peran)
4. Teknologi yang digunakan (termasuk PostgreSQL + pgAdmin 4)
5. **Cara menjalankan** langkah demi langkah: clone, `composer install`, `npm install` dan build, salin `.env.example` menjadi `.env`, `php artisan key:generate`, buat database kosong di pgAdmin 4 lalu isi `DB_*` (driver `pgsql`) di `.env`, `php artisan migrate --seed`, `php artisan storage:link`, `php artisan serve`
6. Akun uji (email dan password dummy dari seeder)
7. Struktur tabel dan relasi singkat (boleh disertai ERD)
8. **Nama anggota kelompok** (beri placeholder `[Nama 1 - NIM]`, `[Nama 2 - NIM]` untuk diisi mahasiswa)

---

## 8. CHECKLIST AKHIR (VERIFIKASI SEBELUM DIKUMPULKAN)

Di akhir, buat tabel yang menyatakan **Terpenuhi / Belum** untuk tiap butir beserta **lokasi file buktinya**:

- [ ] Login/authentication berfungsi dan halaman privat terlindungi
- [ ] CRUD pada 4 tabel (Kategori, Lokasi, Pengaduan, Tanggapan) terhubung ke database
- [ ] Routing + controller (resource controller, tidak ada logika besar di route)
- [ ] Validasi di semua form, error tampil per field
- [ ] Blade dengan layout, section, dan komponen/include
- [ ] Bootstrap dipakai konsisten
- [ ] CSRF pada semua form
- [ ] Authorization: middleware role + policy, 403 teruji
- [ ] Relasi Eloquent dipakai di controller dan view (misalnya eager loading `with()`)
- [ ] Koneksi PostgreSQL (`DB_CONNECTION=pgsql`) berfungsi dan tabel terlihat di pgAdmin 4
- [ ] Migration, seeder lengkap, `migrate:fresh --seed` sukses
- [ ] `.env` tidak ikut Git, `.env.example` ada
- [ ] README lengkap (nama, deskripsi, fitur, cara menjalankan, teknologi, nama anggota)
- [ ] Repository dapat diakses dosen (public, atau dosen ditambahkan sebagai collaborator)
- [ ] Commit history menunjukkan kontribusi **kedua** anggota
- [ ] Kolom `role` tidak bisa diisi dari form register
- [ ] Aplikasi berhasil dijalankan dari clone baru mengikuti README
- [ ] Tidak ada library atau teknik di luar materi tanpa persetujuan

---

## 9. ATURAN GIT (UNTUK BUKTI KONTRIBUSI)

**Semua operasi Git (add, commit, push, pull, branch, merge) dilakukan MANUAL oleh mahasiswa, bukan oleh agen.** Agen hanya boleh mengusulkan pesan commit dan menjelaskan langkahnya sebagai teks. Alasannya: commit history dipakai dosen untuk menilai kontribusi masing-masing anggota, jadi harus dibuat oleh akun mahasiswa sendiri.

- Mahasiswa commit **kecil dan sering** setelah tiap fase diuji, dengan pesan jelas bahasa Indonesia atau Inggris yang konsisten, misalnya `feat: tambah CRUD kategori`. Agen cukup mengusulkan pesannya.
- Tiap anggota memakai **branch sendiri** (dibuat manual) (misalnya `fitur/auth-master` dan `fitur/pengaduan-tanggapan`), lalu digabung lewat Pull Request atau merge.
- Jangan membuat satu commit raksasa di akhir.
- Jangan pernah commit: `.env`, folder `vendor/`, `node_modules/`, file credential.
- Pastikan repository **dapat diakses dosen** (set public atau tambahkan dosen sebagai collaborator) sebelum deadline.
- Repository minimal memuat: source code Laravel, migration, seeder/factory, dan `README.md`.

---

## 10. PEMBAGIAN TUGAS YANG DISARANKAN (UNTUK REPORT, SESUAIKAN DENGAN KENYATAAN)

| Anggota | Fokus |
|---|---|
| **Anggota 1** | Setup proyek, autentikasi dan role, middleware, CRUD Kategori dan Lokasi, seeder, README |
| **Anggota 2** | Migration/model Pengaduan dan Tanggapan, CRUD Pengaduan (upload foto), Tanggapan dan status, policy, dashboard |

Pembagian di report **harus sesuai pekerjaan yang benar-benar dilakukan** masing-masing anggota.

---

## 11. TARGET WAKTU (DEADLINE: 5 DESEMBER 2026)

Perkiraan, sesuaikan dengan kondisi. Sisakan 1 sampai 2 hari terakhir hanya untuk uji, README, screenshot, dan report.

| Hari | Fokus |
|---|---|
| 1 | Fase 1 dan 2 (setup, autentikasi, peran) |
| 2 sampai 3 | Fase 3 dan 4 (migration, model, CRUD master data) |
| 4 sampai 6 | Fase 5 dan 6 (CRUD Pengaduan, Tanggapan, status) |
| 7 | Fase 7 (dashboard, penyempurnaan) |
| 8 | Fase 8 (README, ERD, uji dari clone baru) |
| 9 sampai 10 | Screenshot, report, cek akses repository, kumpulkan lewat LMS |

---

## 12. BANTUAN UNTUK REPORT (MAKSIMAL 4 HALAMAN A4, DIKUMPULKAN LEWAT LMS)

Report berisi: identitas kelompok (nama, NIM, kelas), deskripsi aplikasi, fitur (login, CRUD, fitur tambahan), database (daftar tabel dan relasi, ERD bila perlu), pembagian tugas, screenshot, link GitHub, serta kendala dan solusi.

Pada tahap akhir, agen **boleh membantu** menyusun draf bagian berikut berdasarkan kode yang benar-benar ada: deskripsi aplikasi, daftar fitur, daftar tabel dan relasi, serta ERD.

Agen **tidak boleh** mengarang atau mengisi sendiri:
- identitas (nama, NIM, kelas),
- pembagian tugas dan kontribusi (mahasiswa menulis sesuai kenyataan, boleh dicek dengan `git log`),
- screenshot (mahasiswa mengambil sendiri dari aplikasi yang berjalan),
- bagian kendala dan solusi (hanya berdasarkan kendala yang benar-benar dialami).

Agen cukup menyediakan **daftar halaman yang perlu di-screenshot** (misalnya login, dashboard, daftar dan form tiap CRUD, halaman detail dengan tanggapan, pesan validasi, dan halaman 403).

---

## 13. PERINTAH PERTAMA UNTUK AGEN

Mulai dengan **menanyakan** hal-hal berikut sebelum menulis kode:
1. Sistem operasi dan lingkungan lokal (Laragon/XAMPP/lainnya), versi PHP, Composer, Node, serta PostgreSQL dan pgAdmin 4 yang terpasang. Cek juga apakah ekstensi `pdo_pgsql` dan `pgsql` sudah aktif.
2. Apakah repository GitHub sudah dibuat dan di-clone oleh mahasiswa (agen tidak melakukannya).
3. Konfirmasi pilihan autentikasi (`laravel/ui` Bootstrap atau Breeze).

Setelah dijawab, kerjakan **Fase 1 saja**, lalu berhenti dan laporkan sesuai aturan di bagian 0.
