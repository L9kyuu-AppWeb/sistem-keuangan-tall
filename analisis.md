Berikut adalah **Product Requirement Document (PRD)** yang telah disusun ulang dan disempurnakan berdasarkan seluruh rangkaian percakapan kita dari awal hingga akhir.

Dokumen ini dirancang dengan pendekatan profesional dan secara eksplisit menegaskan bahwa aplikasi ini adalah **platform SaaS murni pencatatan keuangan (bookkeeping/financial tracker)**, bukan aplikasi *fintech* transaksional.

Resume this session with:
  hermes --resume 20260620_181857_2ce08a
  hermes -c "Indonesian Greeting and Help Offer #7"

Session:        20260620_181857_2ce08a
Title:          Indonesian Greeting and Help Offer #7
Duration:       6h 49m 54s
Messages:       257 (24 user, 209 tool calls)

---

# PRODUCT REQUIREMENT DOCUMENT (PRD)

## 1. Identifikasi Dokumen & Metadata

* **Nama Produk:** *FamiBalance (Nama Sementara)*
* **Jenis Produk:** Software-as-a-Service (SaaS) Murni Pencatatan Keuangan Rumah Tangga
* **Fase Pengembangan:** 1.0 (Minimum Viable Product - MVP)
* **Target Pengguna:** Kepala keluarga, pasangan suami-istri, atau individu yang mengelola anggaran domestik secara mandiri.

---

## 2. Visi & Tujuan Produk

Menciptakan aplikasi pencatatan keuangan rumah tangga yang intuitif, profesional, dan membantu pengguna mendapatkan visibilitas penuh atas kesehatan finansial mereka tanpa kerumitan teknis perbankan. Aplikasi ini **murni berfungsi sebagai buku kas digital (ledger)** di mana semua data diinput secara mandiri oleh pengguna (tidak memindahkan uang riil atau terhubung untuk transfer antar-bank).

Keunggulan utama terletak pada kemudahan pengelolaan banyak pos saldo virtual, fitur pelacakan portofolio emas secara otomatis (Pro), serta fitur sinkronisasi pencatatan antar-pasangan (Pro).

---

## 3. Strategi Monetisasi SaaS (Skema Freemium)

Aplikasi ini menggunakan model bisnis freemium untuk mendorong pertumbuhan pengguna baru secara masif (organik), sekaligus membatasi fitur-fitur kenyamanan tingkat lanjut guna mengonversi pengguna menjadi pelanggan berbayar (Pro).

### Tabel Perbandingan Fitur: Akun Biasa (Free) vs. Akun Pro

| Fitur / Modul | Akun Biasa (Free) | Akun Pro (Berlangganan) |
| --- | --- | --- |
| **Batas Akun Saldo (Dompet Virtual)** | **Maksimal 2 Dompet Virtual** (Contoh: Hanya bisa mencatat pos "Uang Tunai" dan "Rekening Bank Utama"). | **Tanpa Batas (Unlimited)**. Bebas membuat pos pencatatan (Contoh: Kas, Mandiri, BCA, Gopay, ShopeePay, Kartu Kredit A & B). |
| **Modul Dompet Emas** | **Pencatatan Statis**. Hanya melacak jumlah gram emas. Pengguna harus menghitung nilai konversi uangnya sendiri secara manual. | **Otomatis & Real-Time**. Cukup input jumlah gram, sistem otomatis mengonversi ke nilai Rupiah terkini via API harga pasar harian. Dilengkapi grafik *Gain/Loss*. |
| **Akses Keluarga (Multi-User Sync)** | **Single Ledger**. Catatan keuangan hanya bisa diakses dan diisi dari satu akun/perangkat saja. | **Family Sync (Bagi Buku)**. Suami dan istri bisa terhubung untuk mencatat dan memantau buku kas rumah tangga yang sama dari perangkat masing-masing secara *real-time*. |
| **Manajemen Anggaran (Budgeting)** | **Maksimal 1 Anggaran** per bulan (Contoh: Hanya bisa membatasi total pengeluaran bulanan gabungan). | **Multi-Anggaran per Pos**. Bisa membatasi budget per kategori (Contoh: Budget Jajan Rp500rb, Budget Listrik Rp1jt) + Notifikasi limit sisa 10%. |
| **Kategori Transaksi** | **Kategori Standar** bawaan sistem (tidak dapat diubah, ditambah, atau dihapus). | **Kustomisasi Penuh**. Pengguna bebas membuat nama kategori dan sub-kategori baru sesuai pola belanja rumah tangga mereka. |
| **Bukti Fisik (Attachment)** | Tidak dapat mengunggah file. | **Bisa Unggah Foto Struk/Nota** di setiap transaksi sebagai arsip digital. |
| **Analisis & Ekspor Data** | Grafik pie chart dasar untuk komposisi pengeluaran bulan berjalan langsung di aplikasi. | **Analisis Tren Mendalam** antar-bulan dan kemampuan **Ekspor Data (Excel/CSV & PDF)** untuk pelaporan tahunan keluarga. |
| **Pengalaman Pengguna (UX)** | Didukung oleh penayangan iklan (*Ad-supported*). | **100% Bebas Iklan (Ad-Free)**. |

---

## 4. Spesifikasi Fungsional & Modul Utama

### 4.1. Modul Dashboard (Pusat Kendali Finansial)

Halaman utama yang memberikan ringkasan kondisi keuangan keluarga secara instan saat aplikasi dibuka.

* **Total Kekayaan Bersih (Net Worth):** Akumulasi otomatis dari saldo seluruh Dompet Virtual aktif ditambah nilai konversi real-time dari Dompet Emas (Khusus Pro).
* **Arus Kas Bulan Berjalan:** Visualisasi perbandingan Total Pemasukan vs Total Pengeluaran dalam bulan berjalan.
* **Alokasi Anggaran (Budget Tracker):** *Progress bar* interaktif yang memantau sisa kuota anggaran yang telah ditetapkan pengguna.
* **Konten Profesional Finansial:** Rekomendasi atau tips keuangan adaptif harian berdasarkan pola log transaksi pengguna (Contoh: *"Pengeluaran kategori 'Hiburan' Anda bulan ini naik 20% dibanding bulan lalu, pertimbangkan untuk mengeremnya"*).

### 4.2. Modul Manajemen Dompet Virtual (Buku Kas Saldo)

Modul untuk mengelompokkan tempat penyimpanan uang pengguna secara visual di aplikasi.

* **Pencatatan Transaksi Manual:** Pengguna menginput secara mandiri transaksi berupa Pemasukan (*Income*) dan Pengeluaran (*Expense*).
* **Fitur "Pindah Saldo" (Transfer Virtual):** Fitur untuk mencatat perpindahan dana dari Dompet A ke Dompet B (Misal: Uang tunai disetor ke bank). Sistem akan memotong saldo Dompet A dan menambah Dompet B secara otomatis tanpa mengategorikannya sebagai pengeluaran atau pemasukan baru agar grafik analisis tidak rusak.

### 4.3. Modul Dompet Emas (Portofolio Aset)

Modul khusus untuk melacak investasi emas fisik maupun digital milik keluarga sebagai instrumen pelindung nilai.

* **Input Berbasis Gramasi:** Pengguna memasukkan data transaksi emas berdasarkan satuan **Gram** dan menginput harga beli per gram pada saat transaksi dilakukan (*Average Buying Price*).
* **Automated Valuation Engine (Fitur Pro):** Sistem mengintegrasikan API pihak ketiga penyedia harga emas harian terpercaya untuk memperbarui nilai aset ke dalam Rupiah secara otomatis.
* **Analisis Portofolio (Fitur Pro):** Menampilkan performa aset berupa persentase (%) dan nominal keuntungan atau kerugian (*Gain/Loss*) akumulatif.

### 4.4. Modul Kolaborasi Keluarga (Family Sync)

* **Multi-Device Synchronization:** Memungkinkan satu basis data buku kas diakses oleh dua akun pengguna terpisah (Suami & Istri). Setiap pencatatan pengeluaran yang dilakukan oleh suami akan langsung muncul dan memotong anggaran di aplikasi istri secara *real-time*, begitu pula sebaliknya.

---

## 5. Kebutuhan Non-Fungsional (Non-Functional Requirements)

* **Keamanan & Isolasi Data (Multi-tenancy):** Karena aplikasi ini berbasis SaaS, arsitektur database harus menjamin pemisahan (*tenant isolation*) data antar-pengguna terjamin dengan aman agar tidak terjadi kebocoran data pencatatan antar-keluarga.
* **Kecepatan Respons (Performa):** Karena proses pencatatan sering dilakukan secara langsung di kasir atau sesaat setelah transaksi, kalkulasi saldo dashboard dan penyimpanan transaksi manual harus selesai dalam waktu kurang dari 1,5 detik.
* **Aksesibilitas Multi-Platform:** Aplikasi wajib menggunakan pendekatan *mobile-first* (baik responsif web yang dioptimalkan atau aplikasi mobile) agar nyaman digunakan di *smartphone*.

---

## 6. Pemicu Paywall & Alur Konversi Pro (UX Trigger)

Sistem paywall ditempatkan secara strategis pada alur kerja (*user flow*) harian untuk mendorong konversi tanpa mengganggu fungsi dasar aplikasi pencatatan:

1. **Trigger Kuota Dompet:** Saat pengguna Free menekan tombol "Tambah Dompet Baru" ketika pos saldo sudah mencapai 2, pop-up penawaran Pro akan muncul.
2. **Trigger Nilai Emas:** Di dalam halaman Dompet Emas versi Free, grafik keuntungan sengaja dikunci dengan visualisasi blur dan tombol *"Lihat performa investasi & otomatisasi harga emas Anda sekarang dengan Pro"*.
3. **Trigger Sinkronisasi Pasangan:** Menu "Hubungkan Akun Pasangan" akan langsung mengarahkan pengguna ke halaman opsi pembayaran langganan SaaS.