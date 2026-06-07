# Praktikum 9 — Modul 12 & 13
## Aplikasi To-Do List dengan Provider dan Firebase Cloud Messaging (FCM)

> **Nama:** Mahija Danadyaksa Sadtya  
> **NIM:** 2311102157  
> **Mata Kuliah:** Aplikasi Berbasis Platform (ABP)  
> **Semester:** 6 — Teknik Informatika  

---

## 📋 Deskripsi Tugas

Membuat aplikasi **To-Do List** sederhana menggunakan Flutter yang menerapkan:
- **State Management** dengan package `Provider` (`ChangeNotifier`)
- **Push Notification** menggunakan **Firebase Cloud Messaging (FCM)**

Fitur yang diimplementasikan:
- Menampilkan daftar tugas
- Menambah tugas baru (via dialog)
- Menghapus seluruh tugas sekaligus
- Menerima push notification dari Firebase Console

---

## 🛠️ Tech Stack

| Komponen | Detail |
|---|---|
| Framework | Flutter 3.44.1 |
| Bahasa | Dart 3.12.1 |
| State Management | Provider 6.1.2 |
| Push Notification | Firebase Cloud Messaging (FCM) |
| Firebase Core | firebase_core 3.15.2 |
| IDE | Visual Studio Code |
| Target Device | Android (Samsung SM-A325F) |

---

## 📁 Struktur Project

```
todo_fcm_app/
├── lib/
│   ├── main.dart                  # Entry point, inisialisasi Firebase & FCM
│   ├── firebase_options.dart      # Konfigurasi Firebase (auto-generated)
│   ├── models/
│   │   └── task_model.dart        # Model data Task
│   ├── providers/
│   │   └── task_provider.dart     # ChangeNotifier — manajemen state
│   └── screens/
│       └── home_screen.dart       # Tampilan UI utama
├── android/
│   └── app/
│       ├── build.gradle.kts       # Konfigurasi Gradle Android
│       └── google-services.json  # Konfigurasi Firebase Android
└── pubspec.yaml                   # Dependencies
```

---

## 📦 Dependencies (`pubspec.yaml`)

```yaml
dependencies:
  flutter:
    sdk: flutter
  provider: ^6.1.2            # State Management
  firebase_core: ^3.6.0       # Firebase Core
  firebase_messaging: ^15.1.3 # FCM Push Notification
```

---

## ⚙️ Cara Setup & Menjalankan

### 1. Clone Repository
```bash
git clone https://github.com/AxxA3205/2311102157_praktikum_abp_02.git
cd 2311102157_praktikum_abp_02/PRAKTIKUM9/todo_fcm_app
```

### 2. Install Dependencies
```bash
flutter pub get
```

### 3. Konfigurasi Firebase
Project ini memerlukan file `google-services.json` dan `lib/firebase_options.dart` dari Firebase Console. Jalankan:
```bash
flutterfire configure
```
Lalu pilih project Firebase yang sesuai.

### 4. Jalankan Aplikasi
```bash
flutter run
```

---

## 🏗️ Arsitektur State Management (Provider)

Aplikasi menggunakan pola **ChangeNotifier** dari package Provider:

```
ChangeNotifierProvider (main.dart)
        │
        ▼
  TaskProvider (task_provider.dart)
  ├── List<Task> _tasks        ← data tugas
  ├── addTask(String title)    ← tambah tugas → notifyListeners()
  └── deleteAllTasks()         ← hapus semua  → notifyListeners()
        │
        ▼
  Consumer<TaskProvider> (home_screen.dart)
  └── Rebuild otomatis saat notifyListeners() dipanggil
```

**Penjelasan alur:**
- `TaskProvider` meng-extend `ChangeNotifier` dan menyimpan list tugas secara in-memory
- Setiap perubahan data memanggil `notifyListeners()` untuk memicu rebuild UI
- `Consumer<TaskProvider>` di `home_screen.dart` mendengarkan perubahan dan memperbarui tampilan
- `context.read<TaskProvider>()` digunakan di dalam callback tombol (aksi, tidak perlu rebuild)

---

## 🔔 Implementasi FCM

### Background Handler
```dart
@pragma('vm:entry-point')
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  print('Background message: ${message.notification?.title}');
}
```

### Inisialisasi di `main()`
```dart
void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);
  await FirebaseMessaging.instance.requestPermission(...);
  final token = await FirebaseMessaging.instance.getToken();
  runApp(const MyApp());
}
```

---

## 📸 Hasil Screenshot

### 1. Tampilan Daftar Tugas
Menampilkan 3 tugas yang sudah ditambahkan (Gym, Study, Sleep) beserta counter jumlah tugas pending.

<img src="https://github.com/user-attachments/assets/2e0a26a0-e3c1-4a09-9738-51a8983cd06c" width="300"/>

---

### 2. Dialog Tambah Tugas
Dialog muncul saat tombol **+** (FAB) ditekan. User dapat mengetikkan nama tugas lalu menekan tombol **Add**.

<img src="https://github.com/user-attachments/assets/9c3b38a3-9c8a-4649-b7f6-382f77ffa0ba" width="300"/>

---

### 3. Dialog Hapus Semua Tugas
Dialog konfirmasi muncul saat tombol delete di AppBar ditekan untuk mencegah penghapusan tidak sengaja.

<img src="https://github.com/user-attachments/assets/baeb9ebe-f3c8-4132-ae5b-6a7e52600a70" width="300"/>

---

### 4. Tampilan Kosong (Empty State)
Tampilan setelah semua tugas dihapus, menampilkan pesan "No tasks yet!" dengan ikon centang.

<img src="https://github.com/user-attachments/assets/6fe48f69-3029-473b-963e-580621dce062" width="300"/>

---

### 5. Notifikasi FCM Berhasil Diterima
Notifikasi push dari Firebase Console berhasil diterima di perangkat Android saat aplikasi dalam kondisi background.

<img src="https://github.com/user-attachments/assets/2d6827c2-2da8-4d9b-a3d3-e6da51e5ac33" width="300"/>

---

## ✅ Hasil Pengujian FCM

| Skenario | Hasil |
|---|---|
| App di **foreground** | Tidak tampil banner (sesuai ekspektasi — tanpa `flutter_local_notifications`) |
| App di **background** | ✅ Notifikasi muncul di status bar Android |
| App **terminated** | ✅ Notifikasi muncul di status bar Android |

**Cara pengujian:**
1. Jalankan aplikasi → salin FCM Device Token dari Debug Console
2. Buka Firebase Console → **Run → Messaging → Send test message**
3. Paste token → klik **Test**
4. Tekan **Home** di HP agar app masuk background
5. Notifikasi muncul di status bar dengan judul dan isi yang sesuai

---

## 💡 Kesimpulan

Praktikum ini berhasil mengimplementasikan:

1. **Provider State Management** — `ChangeNotifier` dengan `notifyListeners()` memungkinkan UI rebuild otomatis tanpa perlu `setState()` manual. Ini memisahkan logika bisnis (provider) dari tampilan (UI) secara bersih.

2. **Firebase Cloud Messaging** — Aplikasi dapat menerima push notification dari server Firebase pada kondisi background dan terminated. FCM token berhasil di-generate dan notifikasi test berhasil dikirim via Firebase Console.

3. **Arsitektur Modular** — Pemisahan kode menjadi `model`, `provider`, dan `screen` membuat project lebih mudah dipelihara dan dikembangkan.

---

*Praktikum 9 — Modul 12 & 13 | Flutter Provider & FCM | 2311102157*
