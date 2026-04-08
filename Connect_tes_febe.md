# Ringkasan

## 1) Tes Intelegensi

### Yang diubah

- Halaman tes sekarang pakai data kategori dan soal dari backend, bukan hardcoded penuh di frontend.
- Instruksi per subtes diset 3 menit.
- Waktu pengerjaan tiap subtes mengikuti durasi kategori.
- Soal sekarang tampil 1 per 1, bukan langsung semua sekaligus.
- Ditambah navigasi soal: sebelumnya, berikutnya, dan tombol nomor soal.
- Untuk subtes gambar, opsi gambar sudah bisa tampil di UI.
- Untuk subtes mengingat, instruksi bisa menampilkan materi hafalan (gambar + daftar kata), lalu lanjut ke fase isian.

### File utama

- [routes/web.php](routes/web.php)
- [resources/js/pages/user/inteligensi/Tes.vue](resources/js/pages/user/inteligensi/Tes.vue)
- [resources/js/components/SoalInteligensiPilihan.vue](resources/js/components/SoalInteligensiPilihan.vue)
- [resources/js/components/SoalInteligensiIsian.vue](resources/js/components/SoalInteligensiIsian.vue)
- [resources/js/components/HalamanInstruksi.vue](resources/js/components/HalamanInstruksi.vue)

## 2) Seeder data intelegensi

### Yang diubah

- Seeder kategori intelegensi diperluas jadi isi kategori + bank soal + kunci jawaban.
- Struktur dibuat idempotent (aman dijalankan ulang tanpa bikin data dobel).
- Soal yang sudah tidak dipakai bisa dibersihkan per kategori saat seeding ulang.

### File utama

- [database/seeders/IntelligenceTestSeeder.php](database/seeders/IntelligenceTestSeeder.php)

### Seeder yang dijalankan

- php artisan db:seed --class=IntelligenceTestSeeder

## 3) Perbaikan bug halaman koreksi

### Masalah sebelumnya

Pertanyaan di hasil koreksi intelegensi bisa ketuker antar subtes karena mapping question_id tidak sinkron.

### Solusi

- Perbaiki cara resolve pertanyaan di model jawaban untuk tipe intelligence_question.
- Simpan question_id intelegensi berdasarkan id soal asli saat submit, bukan hanya nomor urut.
- Tambah fallback untuk data lama supaya tetap kebaca dengan benar.

### File utama

- [app/Models/TestAnswer.php](app/Models/TestAnswer.php)
- [app/Http/Controllers/OnlineTestSubmitController.php](app/Http/Controllers/OnlineTestSubmitController.php)

## 4) Tes Gaya Belajar (backend + UX dibiakin)

### Yang diubah

- Soal gaya belajar sekarang diambil dari tabel LearningStyleStatement.
- Halaman test menerima statements dari backend.
- UX pengisian dibuat lebih jelas:
    - progress bar
    - mode satu pernyataan per layar
    - status sudah/belum dijawab
    - navigasi sebelumnya/berikutnya
    - tombol nomor pernyataan
    - warning kalau submit tapi masih ada yang kosong

### File utama

- [routes/web.php](routes/web.php)
- [resources/js/pages/user/gaya-belajar/Tes.vue](resources/js/pages/user/gaya-belajar/Tes.vue)
- [resources/js/components/TesGayaBelajar.vue](resources/js/components/TesGayaBelajar.vue)

## 5) Aset pendukung subtes gambar dan memori

### Yang ditambahkan

- [public/images/ist/fa-q1.svg](public/images/ist/fa-q1.svg)
- [public/images/ist/fa-a.svg](public/images/ist/fa-a.svg)
- [public/images/ist/fa-b.svg](public/images/ist/fa-b.svg)
- [public/images/ist/fa-c.svg](public/images/ist/fa-c.svg)
- [public/images/ist/fa-d.svg](public/images/ist/fa-d.svg)
- [public/images/ist/me-board.svg](public/images/ist/me-board.svg)
