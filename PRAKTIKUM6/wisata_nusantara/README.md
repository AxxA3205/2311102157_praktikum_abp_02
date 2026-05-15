# 🏝️ Wisata Nusantara — Tugas Praktikum Flutter

Aplikasi Flutter bertema **wisata Indonesia** yang menampilkan berbagai widget UI dasar dalam satu halaman scroll.

---

## 📱 Screenshot

> *(Tambahkan screenshot hasil emulator di sini setelah menjalankan aplikasi)*

---

## 🚀 Cara Menjalankan

```bash
# Clone repo ini
git clone <url-repo-kamu>
cd wisata_nusantara

# Install dependencies
flutter pub get

# Jalankan di emulator / device
flutter run
```

> **Prasyarat:** Flutter SDK terinstall, Android Studio + AVD sudah dikonfigurasi, VS Code dengan ekstensi Flutter.

---

## 📦 Struktur Project

```
wisata_nusantara/
├── lib/
│   └── main.dart       # Seluruh kode aplikasi
├── pubspec.yaml
└── README.md
```

---

## 🧩 Penjelasan Tiap Widget

### 1. `Stack` — Hero Header Bertumpuk

**Lokasi:** `StackHeroSection`

```dart
Stack(
  children: [
    // Layer 1: Container gradient (background)
    Container( ... ),
    // Layer 2: Lingkaran dekoratif kanan atas
    Positioned(top: -50, right: -50, child: Container( ... )),
    // Layer 3: Lingkaran dekoratif kiri bawah
    Positioned(bottom: -30, left: -30, child: Container( ... )),
    // Layer 4: Kotak ikon kecil melayang
    Positioned(top: 80, right: 30, child: Container( ... )),
    // Layer 5: Teks konten utama (paling atas)
    SafeArea( child: Padding( ... ) ),
  ],
)
```

**Fungsi:** `Stack` memungkinkan widget ditumpuk satu di atas yang lain. Setiap `Positioned` menentukan letak elemen relatif terhadap Stack. Urutan children menentukan siapa yang tampil di atas (index terakhir = paling atas).

---

### 2. `Container` — Kotak Info Berwarna

**Lokasi:** `ContainerSection`

```dart
Container(
  padding: const EdgeInsets.all(20),
  decoration: BoxDecoration(
    color: const Color(0xFFFFFBF0),
    borderRadius: BorderRadius.circular(20),
    border: Border.all(color: const Color(0xFFFFE082)),
    boxShadow: [ BoxShadow( ... ) ],
  ),
  child: Row( ... ),
)
```

**Fungsi:** `Container` adalah widget serbaguna untuk membuat kotak dengan warna, padding, border, sudut melengkung (borderRadius), dan shadow. Paling sering digunakan sebagai wrapper atau kartu UI.

---

### 3. `GridView` — Grid Destinasi (6 Item)

**Lokasi:** `GridViewSection`

```dart
GridView.builder(
  shrinkWrap: true,
  physics: const NeverScrollableScrollPhysics(),
  itemCount: destinasiList.length, // 6 item
  gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
    crossAxisCount: 2,      // 2 kolom
    crossAxisSpacing: 12,
    mainAxisSpacing: 12,
    childAspectRatio: 1.05,
  ),
  itemBuilder: (context, index) {
    // Render tiap kartu destinasi
  },
)
```

**Fungsi:** `GridView.builder` membuat grid item secara efisien menggunakan builder pattern. `shrinkWrap: true` + `NeverScrollableScrollPhysics()` digunakan agar GridView tidak konflik dengan `SingleChildScrollView` di luar.

---

### 4. `ListView` — Kategori Wisata (3 Item: A, B, C)

**Lokasi:** `ListViewSection`

```dart
ListView(
  scrollDirection: Axis.horizontal, // scroll ke samping
  children: kategoriList.map((k) {
    return Container( ... ); // kartu A, B, C
  }).toList(),
)
```

**Fungsi:** `ListView` versi paling sederhana — langsung terima list children. Dipakai untuk jumlah item yang sudah diketahui dan tidak terlalu banyak. Di sini diatur horizontal scroll untuk tampilan kartu geser.

---

### 5. `ListView.builder` — Kuliner Nusantara (dari Array)

**Lokasi:** `ListViewBuilderSection`

```dart
ListView.builder(
  shrinkWrap: true,
  physics: const NeverScrollableScrollPhysics(),
  itemCount: kulinerList.length, // panjang array
  itemBuilder: (context, index) {
    final k = kulinerList[index]; // ambil data dari array
    return Padding( ... ); // render tiap item
  },
)
```

**Fungsi:** `ListView.builder` membuat list secara **lazy** — hanya merender item yang terlihat di layar. Cocok untuk data dari array/list yang panjangnya bisa berubah. `itemBuilder` dipanggil untuk tiap index secara otomatis.

---

### 6. `ListView.separated` — Spot Populer + Garis Pembatas

**Lokasi:** `ListViewSeparatedSection`

```dart
ListView.separated(
  shrinkWrap: true,
  physics: const NeverScrollableScrollPhysics(),
  itemCount: popularSpots.length,
  separatorBuilder: (context, index) => const Divider(
    height: 1,
    thickness: 1,
    color: Color(0xFFF0F0F0), // garis pembatas
  ),
  itemBuilder: (context, index) {
    final spot = popularSpots[index];
    return Padding( ... ); // render tiap item
  },
)
```

**Fungsi:** `ListView.separated` mirip dengan `ListView.builder`, tapi ada `separatorBuilder` yang **otomatis menyisipkan widget pemisah** (biasanya `Divider`) di antara setiap item. Berguna untuk membuat list dengan garis pemisah tanpa harus tambahkan secara manual.

---

## 🎨 Tema Visual

| Elemen | Nilai |
|--------|-------|
| Primary Color | `#006B6B` (Deep Teal) |
| Accent Color | `#FFC107` (Amber Gold) |
| Background | `#F0F4F3` (Warm White) |
| Tema | Wisata Nusantara 🏝️ |

---

## 👤 Identitas

| | |
|---|---|
| **Nama** | *(Nama kamu)* |
| **NIM** | *(NIM kamu)* |
| **Kelas** | *(Kelas kamu)* |
| **Mata Kuliah** | Pemrograman Berbasis Platform |
