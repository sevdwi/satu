-- =====================================================================
-- SATU — Query Perbaikan Redundansi Skema Database
-- Sumber: AUDIT-KODE-SATU.md Bagian 8-9 (analisis satu10sep_db.sql, 10 Sep 2026)
--
-- CARA PAKAI:
--   1. WAJIB backup dulu:
--        mysqldump -u root -p satu > backup_sebelum_redundansi_$(date +%Y%m%d).sql
--   2. Jalankan BAGIAN per BAGIAN, bukan sekaligus. Setiap bagian punya
--      query verifikasi (SELECT) sebelum ALTER/DROP — baca hasilnya dulu.
--   3. Angka/asumsi di komentar dihitung dari dump 10 Sep 2026 (13 baris arsip,
--      2.986 master kode, 0 baris pemusnahan). Kalau data sudah berubah,
--      jalankan ulang query verifikasi sebelum lanjut.
--   4. Setelah BAGIAN C dan D jalan, kode aplikasi (controller/model) HARUS
--      disesuaikan dulu sebelum dipakai — lihat catatan di tiap bagian.
-- =====================================================================

START TRANSACTION;

-- =====================================================================
-- BAGIAN A — arsips.tahap
-- Redundan dengan arsips.periode_id -> periodes.tahap (lihat Audit 4.1 & 9.1)
-- =====================================================================

-- Verifikasi: cek baris yang punya nilai tahap terisi
SELECT id, periode_id, tahap, opd_id, tahun
FROM arsips
WHERE tahap IS NOT NULL;
-- Per 10 Sep 2026: hanya id=2 yang terisi (tahap=2), dan baris itu SUDAH
-- punya periode_id=2 — sementara periodes.id=2 sebenarnya tahap=1.
-- Jadi kolom ini sudah tidak sinkron dengan sumber aslinya dan aman didrop.

ALTER TABLE arsips DROP COLUMN tahap;

-- CATATAN KODE: setelah ini, cari semua ->where('tahap', ...) dan
-- kolom 'tahap' di $fillable Arsip model / ArsipController, ganti ke
-- filter lewat relasi periode (join periodes, bukan kolom arsips.tahap).


-- =====================================================================
-- BAGIAN B — opds.singkatan_instansi
-- Selalu NULL, nilai yang sama sudah ada lewat opd_induks.singkatan_instansi
-- =====================================================================

SELECT COUNT(*) AS baris_terisi
FROM opds
WHERE singkatan_instansi IS NOT NULL;
-- Harus 0 sebelum lanjut.

ALTER TABLE opds DROP COLUMN singkatan_instansi;

-- CATATAN KODE: Opd model & OpdController sudah tidak memakai kolom ini
-- (sudah di-comment di kode), jadi harusnya tidak ada dampak.


-- =====================================================================
-- BAGIAN C — arsips.pemusnahan
-- Satu kolom dipakai untuk dua arti: keterangan (musnah/permanen) DAN
-- kadang diisi tanggal oleh PemusnahanArsipController::store() (Audit 4.2 & 9.1)
-- =====================================================================

ALTER TABLE arsips
  ADD COLUMN nasib_akhir ENUM('musnah','permanen') NULL AFTER pemusnahan;

UPDATE arsips
SET nasib_akhir = 'musnah'
WHERE LOWER(pemusnahan) LIKE '%musnah%';

UPDATE arsips
SET nasib_akhir = 'permanen'
WHERE LOWER(pemusnahan) LIKE '%permanen%';

-- Verifikasi: cari baris yang isinya BUKAN kata musnah/permanen
-- (kemungkinan tanggal yang kesasar masuk kolom ini)
SELECT id, pemusnahan, nasib_akhir
FROM arsips
WHERE pemusnahan IS NOT NULL
  AND nasib_akhir IS NULL;

-- JANGAN drop kolom 'pemusnahan' dulu di sini — tunggu sampai kode
-- ArsipController/PemusnahanArsipController dialihkan untuk baca/tulis
-- ke 'nasib_akhir', baru jalankan manual:
-- ALTER TABLE arsips DROP COLUMN pemusnahan;


-- =====================================================================
-- BAGIAN D — pemusnahan_arsips
-- Dua masalah sekaligus:
--  1. FK disimpan sebagai varchar, bukan bigint unsigned (Audit 9.1)
--  2. Kolom id_arsip, no_ba, file_ba yang DITULIS KODE tidak ada di tabel
--     ini sama sekali (Audit 2.1/2.5) — salah satu sebab tabel ini 0 baris.
-- =====================================================================

SELECT COUNT(*) AS total_baris FROM pemusnahan_arsips;
-- Per 10 Sep 2026 = 0, jadi aman diubah langsung tanpa migrasi data.
-- Kalau hasilnya SUDAH TIDAK 0 saat kamu jalankan, STOP — perlu strategi
-- migrasi data dulu (mapping opd_id/master_kode_id lama ke tipe baru),
-- jangan langsung ALTER.

ALTER TABLE pemusnahan_arsips
  ADD COLUMN id_arsip BIGINT UNSIGNED NULL AFTER id,
  ADD COLUMN no_ba VARCHAR(255) NULL AFTER korektor,
  ADD COLUMN file_ba VARCHAR(255) NULL AFTER no_ba,
  MODIFY COLUMN master_kode_id BIGINT UNSIGNED NULL,
  MODIFY COLUMN created_by BIGINT UNSIGNED NULL,
  MODIFY COLUMN opd_id BIGINT UNSIGNED NULL;

ALTER TABLE pemusnahan_arsips
  ADD CONSTRAINT pemusnahan_arsips_id_arsip_foreign
    FOREIGN KEY (id_arsip) REFERENCES arsips(id) ON DELETE SET NULL,
  ADD CONSTRAINT pemusnahan_arsips_master_kode_id_foreign
    FOREIGN KEY (master_kode_id) REFERENCES master_kodes(id) ON DELETE SET NULL,
  ADD CONSTRAINT pemusnahan_arsips_created_by_foreign
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  ADD CONSTRAINT pemusnahan_arsips_opd_id_foreign
    FOREIGN KEY (opd_id) REFERENCES opds(id) ON DELETE SET NULL;

-- CATATAN KODE: ini baru bisa dipakai SETELAH bug routing (Audit 2.3) dan
-- bug `DB` facade (Audit 2.1) diperbaiki di PemusnahanArsipController.


-- =====================================================================
-- BAGIAN E — master_kodes.created_at / updated_at
-- Ada di skema tapi model set $timestamps=false -> selalu NULL (Audit 9.2)
-- =====================================================================

SELECT COUNT(*) AS baris_ada_timestamp
FROM master_kodes
WHERE created_at IS NOT NULL OR updated_at IS NOT NULL;
-- Harus 0.

ALTER TABLE master_kodes
  DROP COLUMN created_at,
  DROP COLUMN updated_at;

-- Alternatif kalau kamu MAU pakai timestamps ke depan (bukan drop):
-- cukup hapus baris "public $timestamps = false;" di app/Models/MasterKode.php,
-- tidak perlu ubah skema.


COMMIT;

-- =====================================================================
-- BAGIAN F (opsional) — normalisasi master_kodes.parent_id
-- Ini BUKAN redundansi kolom, tapi nilai sentinel yang tidak konsisten:
-- root disimpan dengan parent_id=0 padahal kolomnya nullable, sehingga
-- FK constraint ke tabel sendiri tidak pernah bisa dipasang (Audit 8.3).
-- Jalankan terpisah — pastikan Bagian 2.9 (fix relasi parent()/children()
-- di model MasterKode) sudah dikerjakan dulu di kode sebelum ini.
-- =====================================================================

START TRANSACTION;

SELECT COUNT(*) AS baris_parent_sentinel_0
FROM master_kodes
WHERE parent_id = 0;

UPDATE master_kodes SET parent_id = NULL WHERE parent_id = 0;

-- 9 baris punya parent_id yang menunjuk id yang sudah tidak ada.
-- JANGAN diautomasi — putuskan manual per baris (root baru / re-parent):
SELECT m.id, m.kode, m.nama, m.parent_id AS parent_id_hilang
FROM master_kodes m
LEFT JOIN master_kodes p ON p.id = m.parent_id
WHERE m.parent_id IS NOT NULL AND p.id IS NULL;

COMMIT;

-- Setelah semua baris parent_id bersih (NULL untuk root, valid untuk yang
-- lain), baru pasang FK constraint yang hilang di produksi:
-- ALTER TABLE master_kodes
--   ADD CONSTRAINT master_kodes_parent_id_foreign
--   FOREIGN KEY (parent_id) REFERENCES master_kodes(id) ON DELETE SET NULL;


-- =====================================================================
-- BONUS — diagnostik kode klasifikasi duplikat (BUKAN auto-fix)
-- Kolom `kode` seharusnya UNIQUE tapi ada 2 pasang duplikat di produksi.
-- Cek dulu apakah sudah dipakai arsip sebelum memutuskan hapus/gabung/rename.
-- =====================================================================

SELECT kode, COUNT(*) AS jumlah
FROM master_kodes
GROUP BY kode
HAVING COUNT(*) > 1;

SELECT
  m.id, m.kode, m.nama, m.parent_id,
  (SELECT COUNT(*) FROM arsips a WHERE a.master_kode_id = m.id) AS dipakai_arsip
FROM master_kodes m
WHERE m.kode IN ('400.1','500.1')
ORDER BY m.kode, m.id;
-- Kalau salah satu dipakai_arsip=0, itu kandidat aman untuk dihapus/rename.
-- Kalau dua-duanya dipakai, harus rename salah satu (kode baru) baru bisa
-- pasang UNIQUE constraint ulang di kolom `kode`.
