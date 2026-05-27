# Praktikum 8 - Notifikasi & API Perangkat Keras

Aplikasi Flutter sederhana yang mengimplementasikan akses kamera, galeri, dan notifikasi lokal.

---

## Fitur
- **Ambil Foto via Kamera** – membuka kamera langsung menggunakan `image_picker`
- **Pilih Foto dari Galeri** – memilih foto yang sudah tersimpan di perangkat
- **Notifikasi Lokal** – muncul otomatis setelah foto berhasil diambil/dipilih

---

## Struktur File

```
lib/
├── main.dart                 # Entry point aplikasi
├── home_page.dart            # Halaman utama (UI + logika kamera/galeri)
└── notification_service.dart # Service notifikasi lokal
```

---

## Penjelasan Singkat Tiap Widget

### `main.dart`

| Widget / Fungsi | Penjelasan |
|---|---|
| `WidgetsFlutterBinding.ensureInitialized()` | Memastikan Flutter engine siap sebelum kode async dijalankan |
| `MaterialApp` | Widget root yang menyediakan tema, navigasi, dan konfigurasi dasar seluruh aplikasi |
| `ThemeData` | Mengatur skema warna, font, dan gaya visual global menggunakan Material 3 |
| `ColorScheme.fromSeed` | Menghasilkan palet warna harmonis dari satu warna utama (seed color) |

---

### `notification_service.dart`

| Widget / Class | Penjelasan |
|---|---|
| `FlutterLocalNotificationsPlugin` | Instance utama plugin notifikasi lokal dari package `flutter_local_notifications` |
| `AndroidInitializationSettings` | Konfigurasi inisialisasi khusus Android, termasuk ikon notifikasi |
| `InitializationSettings` | Menggabungkan konfigurasi per-platform menjadi satu objek inisialisasi |
| `AndroidNotificationDetails` | Mengatur tampilan notifikasi di Android: channel ID, nama channel, prioritas, dll |
| `NotificationDetails` | Pembungkus `AndroidNotificationDetails` agar bisa digunakan lintas platform |
| `_notificationsPlugin.show()` | Menampilkan notifikasi dengan ID, judul, isi, dan detail tampilan |
| `requestNotificationsPermission()` | Meminta izin notifikasi dari user (wajib di Android 13+) |

---

### `home_page.dart`

| Widget / Fungsi | Penjelasan |
|---|---|
| `StatefulWidget` | Widget yang memiliki state yang bisa berubah (digunakan karena foto bisa berganti) |
| `setState()` | Memberitahu Flutter bahwa state berubah sehingga UI perlu di-render ulang |
| `ImagePicker` | Class dari package `image_picker` untuk mengakses kamera dan galeri |
| `pickImage(source: ImageSource.camera)` | Membuka kamera dan mengembalikan `XFile` berisi path foto |
| `pickImage(source: ImageSource.gallery)` | Membuka galeri dan mengembalikan `XFile` berisi path foto yang dipilih |
| `File` | Representasi file di sistem dengan path tertentu (dari `dart:io`) |
| `Scaffold` | Menyediakan struktur halaman dasar: AppBar, Body, FloatingActionButton, dll |
| `AppBar` | Bilah navigasi atas yang menampilkan judul dan ikon aksi |
| `SingleChildScrollView` | Membuat konten bisa di-scroll vertikal jika melebihi tinggi layar |
| `Column` | Menyusun widget secara vertikal |
| `Row` | Menyusun widget secara horizontal |
| `Material` | Memberikan efek elevasi dan warna latar belakang sebagai fondasi visual tombol |
| `InkWell` | Memberikan efek ripple (gelombang) saat widget ditekan |
| `Container` | Widget serbaguna untuk padding, margin, dekorasi (warna, sudut, bayangan) |
| `BoxDecoration` | Dekorasi pada Container: border radius, warna, shadow, gradient |
| `ClipRRect` | Memotong widget dengan sudut membulat (digunakan untuk gambar) |
| `Image.file` | Menampilkan gambar dari file lokal di perangkat |
| `AnimatedSwitcher` | Menambahkan animasi fade saat widget berganti (placeholder → foto) |
| `SnackBar` | Pesan singkat yang muncul di bagian bawah layar untuk notifikasi error |
| `ScaffoldMessenger` | Mengontrol tampilan SnackBar pada konteks Scaffold tertentu |
| `Icon` | Menampilkan ikon dari kumpulan ikon Material Design |
| `Text` | Widget dasar untuk menampilkan teks dengan gaya tertentu |
| `Expanded` | Membuat widget mengisi sisa ruang yang tersedia dalam Row/Column |
| `Spacer` | Mendorong widget ke sisi berlawanan dalam Row/Column |
| `SizedBox` | Memberikan jarak (spacing) antar widget dengan ukuran tetap |
| `Divider` | Garis pemisah horizontal |
| `VoidCallback` | Tipe fungsi tanpa parameter dan tanpa nilai kembali (digunakan untuk `onTap`) |

---

## Packages yang Digunakan

| Package | Versi | Fungsi |
|---|---|---|
| `image_picker` | ^1.1.2 | Akses kamera dan galeri foto |
| `flutter_local_notifications` | ^18.0.1 | Notifikasi lokal di perangkat |
| `permission_handler` | ^11.3.1 | Manajemen izin (permission) runtime |

---

## Cara Menjalankan

```bash
# 1. Install dependencies
flutter pub get

# 2. Jalankan di emulator/device
flutter run
```

> Pastikan emulator Android sudah berjalan atau perangkat sudah terhubung via USB.

## Hasil
<img width="1080" height="2400" alt="photo_2026-05-27_20-48-31" src="https://github.com/user-attachments/assets/3fc48192-5a06-4918-80cf-67e8b31a979b" />
<img width="1080" height="2400" alt="photo_2026-05-27_20-48-29" src="https://github.com/user-attachments/assets/0afb4e31-30c4-464b-a20d-81b2d1b909c1" />
<img width="1080" height="2400" alt="photo_2026-05-27_20-48-26" src="https://github.com/user-attachments/assets/2ad122fe-563d-42bc-a283-cb17e274f7a9" />

