# Audit Kode SATU — Sistem Informasi Kearsipan Terpadu

Tanggal: 10 September 2026
Ruang lingkup: `app/`, `routes/`, `database/migrations/`, `resources/views/`
Stack: Laravel 13 (PHP 8.3), MySQL, Blade + Bootstrap 5, maatwebsite/excel, simple-qrcode

---

## 1. Ringkasan Arsitektur

Domain inti:

```
Opd_Induk (instansi)  1─n  Opd (unit kerja/bidang)  1─n  Periode (tahun+tahap)
                                   │
                                   └─n  Arsip  ──n:1── MasterKode (klasifikasi, self-parent)
                                          │
                                          ├── Rak_Arsip ──1:n── Dus_Arsip (QR)
                                          └── Pemusnahan_Arsip (snapshot + BA)
```

Dua guard: `web` (pengolah) dan `admin` — keduanya memakai model & tabel yang sama (`users`).
Routing dipecah per modul via `glob()` di `routes/web.php` (`modules-admin/`, `modules-user/`).

Verdict singkat: struktur modulnya sudah benar arahnya, tapi **eksekusinya belum konsisten**. Ada ~10 halaman yang pasti error 500, 1 bug yang bisa menghapus data salah, beberapa lubang keamanan multi-tenant, dan ~3.500 baris view mati.

---

## 2. BUG FATAL — halaman pasti error / data rusak

### 2.1 `DB` facade tidak di-import → pemusnahan tidak pernah bisa disimpan
`app/Http/Controllers/PemusnahanArsipController.php:133`

```php
DB::beginTransaction();   // Class "App\Http\Controllers\DB" not found
```

Tidak ada `use Illuminate\Support\Facades\DB;`. Method `store()` **selalu** fatal.

**Fix:** tambahkan `use Illuminate\Support\Facades\DB;` di header file.

---

### 2.2 Typo operator → halaman "Buat Rak" selalu error
`app/Http/Controllers/RakArsipController.php:78`

```php
$user = auth()->user()>opd_induk_id;   // tanda '-' hilang
$userOpdId = $user->opd_induk_id;      // baris ini juga jadi salah
```

**Fix:**
```php
$userOpdId = auth()->user()->opd_induk_id;
$opds = Opd::where('opd_induk_id', $userOpdId)->get();
```

---

### 2.3 `Route::resource('/')` menghasilkan nama route rusak
`routes/modules-user/pemusnahan_arsip.php:14` dan `routes/modules-user/master-kodes.php:10`

`Route::resource('/', X)` di dalam group `->name('pemusnahan_arsip.')` menghasilkan nama
`pemusnahan_arsip./.index`, `pemusnahan_arsip./.store`, dst — **bukan** `pemusnahan_arsip.store`.

Akibatnya `resources/views/pemusnahan_arsip/create.blade.php:14` yang memanggil
`route('pemusnahan_arsip.store')` melempar `RouteNotFoundException`. Modul pemusnahan tidak bisa dipakai sama sekali.

**Fix:** tulis rute eksplisit (seperti modul lain), jangan `resource('/')`.

---

### 2.4 Nama route yang dipanggil view tapi tidak pernah didaftarkan

| View | Memanggil | Status |
|---|---|---|
| `arsip/edit-admin.blade.php:14` | `arsip_admin.update` | tidak ada (yang ada `arsip_admin.update-admin`) |
| `pemusnahan_arsip/create.blade.php:55` | `arsip.index` | tidak ada (yang ada `arsip.home`) |
| `pemusnahan_arsip/edit.blade.php:139` | `arsip.index` | tidak ada |
| `pemusnahan_arsip/create.blade.php:14` | `pemusnahan_arsip.store` | rusak (lihat 2.3) |

Halaman **Edit Arsip (Admin)** dan seluruh modul **Pemusnahan** fatal saat render.

---

### 2.5 Tombol hapus di daftar pemusnahan menghapus record yang SALAH
`resources/views/pemusnahan_arsip/index.blade.php:117`

```blade
<form action="{{ route('arsip.destroy', $item->id) }}" method="POST">
```

`$item` adalah baris `pemusnahan_arsips`, tapi id-nya dikirim ke `ArsipController::destroy()`
yang menghapus baris di tabel `arsips`. **Risiko kehilangan data arsip aktif.** Prioritas tertinggi.

---

### 2.6 `qr_list_berkas` mengirim Builder, bukan Collection
`app/Http/Controllers/DusArsipController.php:24`

```php
$data = Arsip::where('dus_arsip_id',$id);   // belum ->get()
```

View melakukan `@foreach($data ...)` → error. Halaman hasil scan QR tidak jalan.

---

### 2.7 `PeriodeController::store()` membaca key validasi yang tidak ada
`app/Http/Controllers/PeriodeController.php:58-63`

```php
'tahun'  => $validatedData['kode_instansi'],   // key tidak pernah divalidasi
'tahap'  => $validatedData['instansi'],
'status' => $validatedData['singkatan_instansi'],
```

`Undefined array key`. Periode baru tidak pernah bisa dibuat — padahal `arsip/create.blade.php:79`
menggantungkan `$periodes->id` pada adanya periode. Efek berantai: **form input arsip juga mati**
kalau OPD belum punya periode (`$periodes` = `null` → `Attempt to read property on null`).

**Fix:** pakai `$validatedData['tahun']`, `['tahap']`, `['status']`, dan di `ArsipController::create()`
tambahkan guard `if (!$periodes) return redirect()->route('periode.create')->with('error', ...)`.

---

### 2.8 `dashbord()` membaca kolom yang tidak ada
`app/Http/Controllers/ArsipController.php:68,73-74`

`$item->arsip_count` dan `$item->nama_kategori` tidak ada di `master_kodes` dan tidak di-`withCount()`.
Chart selalu kosong/null.

**Fix:** `MasterKode::withCount('arsips')->get()` lalu pakai `$item->arsips_count` dan `$item->nama`.

---

### 2.9 Relasi `MasterKode::parent()` salah owner key
`app/Models/MasterKode.php:40`

```php
return $this->belongsTo(MasterKode::class, 'parent_id', 'is_parent');
```

Mencocokkan `parent_id` ke kolom boolean `is_parent`. Harus:
```php
return $this->belongsTo(MasterKode::class, 'parent_id', 'id');
```
Relasi `children()` juga **tidak pernah didefinisikan**, padahal dipanggil di
`MasterKodeController::show()` dan `getdataajax()` (`with('parent','children')`) → error.

Tambahkan:
```php
public function children() { return $this->hasMany(MasterKode::class, 'parent_id'); }
```

---

### 2.10 Rute admin memanggil method yang mengasumsikan guard `web`
`routes/modules-admin/arsip_admin.php:14,25` → `ArsipController::index()` dan `create()`

Kedua method memakai `auth()->user()` (guard default = `web`). Saat diakses admin
(`auth:admin`), `auth()->user()` = `null` → `Attempt to read property "opd_induk_id" on null`.

Rute `/app/arsip_admin/` dan `/app/arsip_admin/create` fatal. Halaman admin yang benar
adalah `index_admin()` (`/app/arsip_admin/inaktif`).

**Fix:** hapus kedua rute admin itu, atau ganti ke method khusus admin.

---

### 2.11 Alur login pengolah tidak pernah sampai dashboard
`app/Http/Controllers/UserController.php:176-184`

```php
if ($role === 'admin')     { ... }
if ($role === 'pengolah')  { return redirect()->intended('/app/dashboard'); }
return redirect()->intended('/');   // fallback
```

Sementara `database/migrations/0001_01_01_000000_create_users_table.php:19` mendefinisikan
`enum('admin','staff','customer')`, dan `users/create.blade.php:136-138` menawarkan
`admin | pengolah | sekretariat`. Tiga sumber kebenaran yang berbeda untuk hal yang sama.

Selain itu, user ber-role `admin` yang login lewat `/pengolah` masuk ke guard `web`, lalu
diarahkan ke `/app/dashboard-admin` yang butuh guard `admin` → dilempar balik ke `/pengolah`
(loop). **Fix:** samakan daftar role di satu tempat (enum migrasi + constant/Enum PHP + form),
dan di `login()` cek role admin lalu login ulang ke guard `admin`, atau tolak dengan pesan.

---

### 2.12 Rute yang saling menutupi (shadowing)

| File | Masalah |
|---|---|
| `modules-user/dus_arsip.php:9-10` | dua rute URI **sama persis** `/search` → `search()` mati, yang jalan hanya `search2()` |
| `modules-user/pemusnahan_arsip.php:11,14` | `GET /{id}` didaftarkan sebelum `/dashbord` → `/dashbord` masuk ke `show()` → 404 |
| `modules-admin/opd_induk.php:22,32` | `GET /{id}` (→ `show()`, **method tidak ada**) menutupi `/search` |
| `modules-admin/opd_induk.php:32` | memakai `OpdController::class` tanpa `use` → resolve ke `\OpdController` (class not found) |

Aturan: rute statis (`/search`, `/export`, `/dashbord`) **selalu** didaftarkan sebelum `/{id}`.

---

## 3. Keamanan

### 3.1 Upload file tanpa batasan tipe → risiko RCE
`ArsipController::upload()` dan `uploads_post()` (baris 381-417)

```php
'file' => 'required|file|max:50120'          // tidak ada mimes
$file->move(public_path('arsip'), $filename); // langsung ke webroot
```

File `.php` bisa diunggah ke direktori yang dieksekusi web server. **Wajib** ditambah
`mimes:pdf,jpg,jpeg,png` dan disimpan ke `storage/app/public` (bukan `public_path`).

### 3.2 IDOR — tidak ada cek kepemilikan
- `uploads_post()`: `$id` diambil dari input POST, langsung `findOrFail` → user OPD A bisa menimpa file arsip OPD B.
- `destroy()`: sama, tanpa cek `opd_induk_id`.
- `nomor_definitif()` (baris 632): loop `Arsip::where('id',$id)->update(...)` atas array id dari form → satu request bisa menomori ulang arsip instansi lain.
- `edit()`, `update()`, `kartu()`: `findOrFail($id)` tanpa filter OPD.

**Fix:** buat scope global, contoh di `Arsip`:
```php
public function scopeMilikUser($q) {
    $u = auth()->user();
    $q->where('opd_induk_id', $u->opd_induk_id);
    if ($u->opd && strtolower($u->opd->unit_kerja) !== 'sekretariat') {
        $q->where('opd_id', $u->opd_id);
    }
    return $q;
}
```
lalu pakai `Arsip::milikUser()->findOrFail($id)` di semua titik di atas.

### 3.3 Kebocoran lintas-OPD di endpoint pencarian
`ArsipController::search()` (baris 419)

```php
->where('judul','like',"%$q%")
->orWhere('nomor', ...)      // orWhere tanpa grouping
```

Tidak ada filter OPD sama sekali, dan rangkaian `orWhere` tanpa `function($q){...}` membuat
filter apa pun yang ditambahkan kemudian batal. Endpoint ini mengembalikan arsip **semua instansi**
ke user mana pun yang login. Masalah `orWhere` tanpa grouping yang sama ada di
`DusArsipController::search/search2` dan `RakArsipController::search`.

### 3.4 `AdminMiddleware` tidak pernah dipakai
`app/Http/Middleware/AdminMiddleware.php` tidak terdaftar di `bootstrap/app.php` dan tidak dipakai
rute mana pun. Proteksi admin bergantung sepenuhnya pada `auth:admin` — dan guard `admin`
memakai provider yang menunjuk model `User` yang sama, **tanpa filter role di level guard**.
Yang menahan hanyalah pengecekan `'role' => 'admin'` di `AdminUserController::login():160`.
Aman untuk saat ini, tapi rapuh: matikan/ubah satu baris itu dan pintu admin terbuka.

### 3.5 Lain-lain
- `.env` punya `APP_DEBUG=true` dan `APP_ENV=local` — pastikan tidak ikut ke produksi (`.env` sudah di-`.gitignore`, bagus).
- `satu_db.sql` **ikut ter-commit** dan berisi hash password 3 akun + dump session. Sebaiknya dihapus dari repo (`git rm --cached satu_db.sql`).
- Tidak ada `<meta name="csrf-token">` di layout mana pun, padahal 15 view membaca
  `$('meta[name="csrf-token"]').attr('content')`. Setiap AJAX POST akan kena 419.
  Tambahkan di `layouts/head.blade.php` dan `layouts/head_customer.blade.php`:
  `<meta name="csrf-token" content="{{ csrf_token() }}">`
- `AdminUserController::store():89` membuat user tanpa `role`/`status` → jatuh ke default `staff`
  dan `status` yang **tidak punya default** di enum → error insert.

---

## 4. Kesalahan Alur Bisnis

### 4.1 Konsep "periode/tahap" punya tiga representasi berbeda
- Tabel `periodes` (`tahun`, `tahap` 1-4, `status` buka/tutup)
- Kolom `arsips.periode_id` (FK yang benar)
- Kolom `arsips.tahap` (duplikat denormalisasi)
- `session('periodes')`

`ArsipController::index_tahap():136` default `$periode = date('Y-m')` (mis. `"2026-09"`) lalu
dipakai `->where('tahap', session('periodes'))` — membandingkan `"2026-09"` dengan angka 1-4.
Hasilnya selalu kosong saat diakses tanpa parameter.

Selain itu `manuver():185` menulis `session(['periodes' => $periode])` dengan nilai `null` bila
parameter kosong, sehingga judul halaman di view lain (`arsip/index.blade.php:69`) ikut kosong.

**Rekomendasi:** buang kolom `arsips.tahap`, pakai `periode_id` saja, dan jangan simpan filter di
session — kirim lewat query string (`?periode_id=`).

### 4.2 Kolom `pemusnahan` dipakai untuk dua arti sekaligus
- Migrasi: `$table->date('pemusnahan')`
- `arsip/create.blade.php:211`: `<input type="text" name="pemusnahan">` berisi keterangan `Musnah`/`Permanen`
- `ArsipController::musnah():239`: `->where('pemusnahan', 'musnah')`
- `PemusnahanArsipController::store():170`: `'pemusnahan' => now()` (tanggal!)

Satu kolom, dua tipe data, dua makna. Sementara tanggal hasil hitung retensi sudah punya
kolom sendiri (`tanggal_musnah`).

**Fix:** pisahkan jadi `nasib_akhir` (enum: musnah|permanen) dan `tanggal_pemusnahan` (date).

### 4.3 "Sekretariat" ditentukan dari nama unit kerja, bukan role
`ArsipController` (baris 117, 165, 207, 242, 276), `CustomerController:44`, `PeriodeController:22`,
`ArsipExport:31` — semuanya:

```php
if ($user->opd && strtolower($user->opd->unit_kerja) !== 'sekretariat')
```

Hak akses bergantung pada **string nama unit kerja**. Ganti nama unit jadi "Sekretariat Daerah"
atau typo satu huruf → hak akses berubah diam-diam. Padahal form user sudah menyediakan role
`sekretariat` yang tidak pernah dipakai kode.

**Fix:** pakai `$user->role === 'sekretariat'` (atau kolom boolean `is_sekretariat` di `opds`),
dan pindahkan logika ini ke satu scope (lihat 3.2) — sekarang duplikat di 8 tempat.

### 4.4 Tombol Edit Periode selalu mengedit baris yang salah
`resources/views/periode/index.blade.php:103`

```blade
route('periode.edit', auth()->guard('web')->user()->opd_id)
```

Bukan `$item->id`. Rute `/periode/{opd_id}/edit` lalu mengambil periode **terbaru** milik OPD user.
Jadi klik "Ubah" di baris mana pun selalu membuka periode terakhir milik user sendiri —
untuk user sekretariat yang melihat periode unit lain, ini salah sasaran.

### 4.5 Route pencarian klasifikasi salah guard
- `arsip/create.blade.php:361` → `route('master-kodes.search')` = grup **admin** (`auth:admin`)
- `arsip/edit.blade.php:340` → `route('master_kodes.search')` = grup **user**

User pengolah yang membuka form Tambah Arsip akan mendapat redirect login pada AJAX select2 →
dropdown klasifikasi kosong. Samakan keduanya ke grup user.

### 4.6 `MasterKodeController::destroy()` mengembalikan JSON ke form HTML biasa
`master-kodes/index.blade.php:159` mengirim form `DELETE` normal, tapi controller (baris 252)
`return response()->json(...)`. User melihat teks JSON mentah, bukan kembali ke daftar.

### 4.7 Kolom `file` bermakna ganda
`arsip/create.blade.php:238` = input **teks** berisi link Google Drive.
Tapi `ArsipController::destroy():776` melakukan `unlink(public_path('arsip/'.$arsip->file))`
dan `uploads_post()` mengisinya dengan nama file fisik. Dua mekanisme penyimpanan berkas
hidup berdampingan tanpa penanda.

### 4.8 `CustomerController::index():23,30` mengambil jalan memutar
```php
$userfilter = auth()->user()->opd;
$userOpdId  = $userfilter->opd_induk_id;
```
User tanpa `opd_id` → null → fatal. `$user->opd_induk_id` sudah tersedia langsung.

### 4.9 `public/storage` bukan symlink
Direktori `public/storage` ada tapi kosong (bukan symlink). QR code (`storage/app/public/qr-codes/`)
dan Berita Acara (`ba_pemusnahan/`) tidak akan bisa diakses dari browser.
**Fix:** `rm -rf public/storage && php artisan storage:link`

---

## 5. Redundansi & Kode Mati

### 5.1 View yatim (tidak pernah dirender siapa pun) — ±3.500 baris
```
resources/views/utama.blade.php               1739  ← template demo AdminLTE mentah
resources/views/users/createholdlagi.blade.php  534
resources/views/users/createhold.blade.php      454
resources/views/arsip/kartu-hold.blade.php      216
resources/views/pemusnahan_arsip/edit.blade.php 255  (tidak ada method edit yang render)
resources/views/dashboardlama.blade.php
resources/views/welcomelama.blade.php
resources/views/auth/loginlama-admin.blade.php
resources/views/master-kodes/index.blade-lama.php
resources/views/master-kodes/index.blade copy.php   ← nama file dengan spasi
```

### 5.2 Empat file `edit2.blade.php` identik (md5 sama, 235 baris ×4)
`arsip/edit2`, `dus_arsip/edit2`, `rak_arsip/edit2`, `pemusnahan_arsip/edit2` — semuanya salinan
persis dan tidak dipakai. Hapus keempatnya.

### 5.3 Dua file identik lain
`arsip/index-musnah-admin.blade.php` dan `arsip/index-permanen-admin.blade.php` md5 sama —
artinya halaman "permanen admin" menampilkan judul/konten "musnah". Salah satu belum disesuaikan.

### 5.4 Method controller tanpa rute (dead code)
```
ArsipController::updateTahan()          duplikat update()
ArsipController::uploads()              duplikat uploads_post()
ArsipController::upload()               duplikat uploads_post()
UserController::updatetahan2()          duplikat update()
MasterKodeController::storex()          duplikat store() (versi JSON)
MasterKodeController::getdataajax()     memakai relasi children yang tidak ada
PemusnahanArsipController::uploadBAa()  duplikat uploadBA()
DusArsipController::dashbord()          duplikat index() tanpa filter OPD
RakArsipController::dashbord()          duplikat index() tanpa filter OPD
ArsipController::show()                 isinya cuma dd($id)
```

### 5.5 Controller/Model mati
- `app/Models/Bawaanlaravel.php` — sisa scaffolding, tidak dipakai.
- `app/Http/Controllers/ImportController.php` — 100% duplikat `MasterKodeController::import()`.
- `app/Http/Controllers/MasterKodeImportController.php` — jalur import kedua (via `maatwebsite/excel`) yang tidak dirutekan; jalur yang aktif adalah `store_import()` (parsing CSV manual). Dua implementasi import untuk fungsi yang sama.

### 5.6 Blok kode ter-komentar besar
`routes/modules-user/master-kodes.php` (28 dari 39 baris komentar),
`routes/modules-user/opd_induk.php` (semua isi dikomentari kecuali `/search`),
`UserController::login()` (blok reCAPTCHA 20 baris), banyak `// dd(...)` tersebar.

### 5.7 Duplikasi query eager-load
Blok `Arsip::with([...])` yang sama persis diulang **9 kali** di `ArsipController`.
Pindahkan ke scope model:
```php
public function scopeLengkap($q) {
    return $q->with(['opd:id,unit_kerja,singkatan_uk,instansi,singkatan_instansi',
        'opd_induk:id,instansi','masterKode:id,kode,nama','user:id,name,email',
        'dus_arsip:id,nomor_dus','rak_arsip:id,nomor_rak','periode:id,tahun,tahap,status']);
}
```
Method `index()`, `index_tahap()`, `manuver()`, `musnah()`, `permanen()` juga 90% identik —
bisa jadi satu method dengan parameter filter.

### 5.8 Aset dimuat dua kali
`arsip/create.blade.php` memuat ulang jQuery dan Select2 (CSS+JS) padahal
`layouts/head_customer.blade.php` sudah memuatnya. jQuery ganda = plugin select2 bisa
ter-registrasi di instance yang salah.

---

## 6. Skema Database — drift parah antara migrasi dan kode

Migrasi **tidak mencerminkan** database yang sebenarnya berjalan.

### 6.1 Tabel tanpa migrasi sama sekali
`opd_induks` dan `periodes` punya model + controller + dipakai di mana-mana,
tapi **tidak ada file migrasinya**. `php artisan migrate:fresh` = aplikasi mati total.

### 6.2 Kolom yang dipakai kode tapi tidak ada di migrasi

| Tabel | Kolom yang hilang di migrasi |
|---|---|
| `arsips` | `tahun`, `periode_id`, `tahap`, `tanggal_musnah`, `opd_induk_id`, `dus_arsip_id`, `rak_arsip_id`, `aktif`, `inaktif` |
| `opds` | `opd_induk_id` |
| `master_kodes` | `aktif`, `inaktif` |
| `rak_arsips` | `opd_induk_id`, `timestamps` |
| `dus_arsips` | `rak_arsip_id`, `opd_induk_id`, `qrcode` (migrasi malah punya `nomor_rak` string) |
| `users` | `opd_id`, `opd_induk_id`, `is_active`, `last_login_at` (migrasi punya `opd` string) |
| `pemusnahan_arsips` | `id_arsip`, `no_ba`, `file_ba` |

### 6.3 Kolom di migrasi yang tidak dipakai lagi
`arsips.retensi` (digantikan `aktif`+`inaktif`), `users.opd` (digantikan `opd_id`),
`dus_arsips.nomor_rak` (digantikan `rak_arsip_id` — tapi `DusArsipController::update():234`
masih menulis `nomor_rak`, jadi form edit dus menyimpan ke kolom mati).

### 6.4 `pemusnahan_arsips` memakai `string` untuk FK
`master_kode_id`, `created_by`, `opd_id` didefinisikan `string()` — tidak ada FK constraint,
tipe tidak cocok dengan tabel induk. Model juga tidak punya relasi `dus_arsip`/`rak_arsip`
padahal di-`with()` pada `PemusnahanArsipController::create():117-118` → error relasi.

### 6.5 `satu_db.sql` sudah usang
Dump tertanggal 18 Mei 2026, hanya berisi 3 migrasi bawaan + tabel `opds` dengan skema
lama (`name_opd`). Menyesatkan siapa pun yang memakainya untuk setup.

**Rekomendasi:** buat satu batch migrasi baru (`php artisan make:migration sinkronisasi_skema_satu`)
yang mencerminkan struktur DB produksi saat ini, hapus `satu_db.sql`, lalu pastikan
`migrate:fresh --seed` menghasilkan aplikasi yang jalan.

---

## 7. Urutan Perbaikan yang Disarankan

**Tahap 1 — stop the bleeding (hari ini)**
1. Perbaiki `pemusnahan_arsip/index.blade.php:117` → `route('pemusnahan_arsip.destroy', ...)` atau hilangkan tombolnya (risiko hapus data).
2. Tambah `mimes:pdf,jpg,jpeg,png` + pindah upload ke `storage/app/public` (3.1).
3. Tambah cek kepemilikan di `uploads_post`, `destroy`, `nomor_definitif`, `edit`, `update` (3.2).
4. Tambah filter OPD + grouping `orWhere` di semua `search()` (3.3).
5. `git rm --cached satu_db.sql` dan tambahkan ke `.gitignore`.

**Tahap 2 — bikin halaman-halaman mati jadi hidup (minggu ini)**
6. `use DB` di PemusnahanArsipController (2.1)
7. Typo `>` di RakArsipController:78 (2.2)
8. Ganti `Route::resource('/')` jadi rute eksplisit di dua file (2.3)
9. Perbaiki 4 nama route yang salah di view (2.4)
10. `->get()` di `qr_list_berkas` (2.6)
11. Key validasi PeriodeController::store (2.7) + guard `$periodes` null di ArsipController::create
12. Relasi `parent()`/`children()` di MasterKode (2.9)
13. Hapus 2 rute admin yang memanggil method guard web (2.10)
14. Urutkan ulang rute statis sebelum `/{id}` di 3 file (2.12)
15. Tambah `<meta name="csrf-token">` di 2 layout (3.5)

**Tahap 3 — rapikan alur (2-3 minggu)**
16. Satukan definisi role di satu Enum PHP + enum migrasi + form (2.11)
17. Ganti pengecekan `unit_kerja === 'sekretariat'` jadi berbasis role, taruh di satu scope (4.3)
18. Pisahkan kolom `pemusnahan` jadi `nasib_akhir` + `tanggal_pemusnahan` (4.2)
19. Buang `arsips.tahap`, pakai `periode_id`; ganti session jadi query string (4.1)
20. `periode.edit` pakai `$item->id` (4.4)
21. Samakan route pencarian klasifikasi (4.5)

**Tahap 4 — bersih-bersih**
22. Hapus 10 view yatim + 4 `edit2.blade.php` (±3.500 baris)
23. Hapus 10 method dead code + `Bawaanlaravel.php` + `ImportController.php`
24. Ekstrak `scopeLengkap()` dan gabung 5 method index yang mirip (5.7)
25. Tulis ulang migrasi agar sinkron dengan DB produksi (6)

### Perintah cepat untuk Tahap 4 (jalankan dari root project)
```bash
git rm --cached satu_db.sql && echo "satu_db.sql" >> .gitignore

rm -f resources/views/utama.blade.php \
      resources/views/dashboardlama.blade.php \
      resources/views/welcomelama.blade.php \
      resources/views/auth/loginlama-admin.blade.php \
      resources/views/users/createhold.blade.php \
      resources/views/users/createholdlagi.blade.php \
      resources/views/arsip/kartu-hold.blade.php \
      resources/views/arsip/edit2.blade.php \
      resources/views/dus_arsip/edit2.blade.php \
      resources/views/rak_arsip/edit2.blade.php \
      resources/views/pemusnahan_arsip/edit2.blade.php \
      "resources/views/master-kodes/index.blade copy.php" \
      resources/views/master-kodes/index.blade-lama.php

rm -f app/Models/Bawaanlaravel.php app/Http/Controllers/ImportController.php

rm -rf public/storage && php artisan storage:link
php artisan optimize:clear
```

Jalankan `php artisan route:list` setelah Tahap 2 — kalau masih ada nama route
bertanda `/` atau titik ganda, berarti masih ada sisa `Route::resource('/')`.
