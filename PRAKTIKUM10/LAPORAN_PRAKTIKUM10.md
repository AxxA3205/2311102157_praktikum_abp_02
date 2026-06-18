# Laporan Praktikum 10
## Implementasi State Management dengan BLoC pada Aplikasi Flutter

**Nama:** Mahija Danadyaksa Sadtomo
**NIM:** 2311102157
**Mata Kuliah:** ABP
**Tanggal:** 18 Juni 2026  

---

## 1. Deskripsi Aplikasi

Aplikasi **Sport Shop** adalah aplikasi daftar produk alat olahraga yang dibangun menggunakan Flutter dengan menerapkan pola state management **BLoC (Business Logic Component)**. Aplikasi menampilkan 7 produk olahraga dan memungkinkan pengguna untuk menambah/menghapus produk ke/dari keranjang belanja dengan tampilan jumlah item secara *real-time*.

---

## 2. Struktur Proyek

```
sport_shop/lib/
├── main.dart                        # Entry point + BlocProvider
├── models/
│   └── product.dart                 # Model data produk (Equatable)
├── data/
│   └── product_data.dart            # Data 7 produk alat olahraga
├── bloc/cart/
│   ├── cart_event.dart              # CartEvent: Add, Remove, Clear
│   ├── cart_state.dart              # CartState + getter real-time
│   └── cart_bloc.dart               # CartBloc (business logic)
└── screens/
    ├── product/
    │   └── product_list_screen.dart # Halaman daftar produk
    └── cart/
        └── cart_screen.dart         # Halaman keranjang belanja
```

---

## 3. Implementasi BLoC

### 3.1 CartEvent

```dart
abstract class CartEvent extends Equatable { const CartEvent(); }

class AddToCartEvent extends CartEvent {
  final Product product;
  const AddToCartEvent(this.product);
}

class RemoveFromCartEvent extends CartEvent {
  final Product product;
  const RemoveFromCartEvent(this.product);
}

class ClearCartEvent extends CartEvent { const ClearCartEvent(); }
```

| Event | Fungsi |
|-------|--------|
| `AddToCartEvent` | Menambahkan satu unit produk ke keranjang |
| `RemoveFromCartEvent` | Mengurangi satu unit produk dari keranjang |
| `ClearCartEvent` | Mengosongkan seluruh isi keranjang |

### 3.2 CartState

```dart
class CartState extends Equatable {
  final List<Product> cartItems;
  const CartState({this.cartItems = const []});

  int get totalItems => cartItems.length;
  double get totalPrice => cartItems.fold(0, (s, i) => s + i.price);
  int getQuantity(Product p) => cartItems.where((x) => x.id == p.id).length;

  CartState copyWith({List<Product>? cartItems}) =>
      CartState(cartItems: cartItems ?? this.cartItems);
}
```

### 3.3 CartBloc

```dart
class CartBloc extends Bloc<CartEvent, CartState> {
  CartBloc() : super(const CartState()) {
    on<AddToCartEvent>(_onAddToCart);
    on<RemoveFromCartEvent>(_onRemoveFromCart);
    on<ClearCartEvent>(_onClearCart);
  }

  void _onAddToCart(AddToCartEvent event, Emitter<CartState> emit) {
    final updated = List<Product>.from(state.cartItems)..add(event.product);
    emit(state.copyWith(cartItems: updated));
  }

  void _onRemoveFromCart(RemoveFromCartEvent event, Emitter<CartState> emit) {
    final updated = List<Product>.from(state.cartItems);
    final idx = updated.lastIndexWhere((p) => p.id == event.product.id);
    if (idx != -1) updated.removeAt(idx);
    emit(state.copyWith(cartItems: updated));
  }

  void _onClearCart(ClearCartEvent event, Emitter<CartState> emit) =>
      emit(const CartState());
}
```

---

## 4. BlocProvider & BlocBuilder

### BlocProvider (main.dart)
```dart
BlocProvider<CartBloc>(
  create: (context) => CartBloc(),
  child: MaterialApp(...),
)
```
`BlocProvider` ditempatkan di root app agar `CartBloc` dapat diakses dari semua halaman.

### BlocBuilder
```dart
BlocBuilder<CartBloc, CartState>(
  builder: (context, state) {
    return Text('${state.totalItems}'); // Otomatis rebuild saat state berubah
  },
)

// Dispatch event:
context.read<CartBloc>().add(AddToCartEvent(product));
context.read<CartBloc>().add(RemoveFromCartEvent(product));
```

---

## 5. Screenshot Hasil Pengujian

### Gambar 1 — Tampilan Daftar Produk (Awal)
> Halaman utama menampilkan 7 produk alat olahraga. Setiap produk memiliki emoji, nama, deskripsi, harga, dan tombol **"Tambah"**. Badge keranjang di pojok kanan atas belum muncul karena keranjang masih kosong.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/d4648406-08a0-47e7-837f-2203f82bd56f" />


### Gambar 2 — Badge Keranjang Real-time (4 Item)
> Setelah menambahkan Sepatu Lari Nike (×1) dan Raket Badminton Yonex (×3), badge AppBar menampilkan angka **4** secara real-time. Produk yang sudah ditambahkan menampilkan kontrol **−/qty/+** dan label `x1`, `x3`. Teks **"4 item di keranjang"** muncul di summary bar.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/d3c5a9b4-3df3-4c71-9cc3-34e4c502136c" />


### Gambar 3 — Perubahan State Real-time (2 Item)
> Setelah mengurangi Raket Badminton Yonex dari 3 menjadi 1, badge langsung berubah menjadi **2**. Membuktikan `BlocBuilder` merespons perubahan `CartState` secara *real-time* tanpa reload halaman.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/d9046588-dd5c-486d-bf34-3ae87158f95b" />


### Gambar 4 — Halaman Keranjang
> Halaman keranjang menampilkan produk dengan kuantitas, harga satuan, dan **subtotal**. Bagian bawah menampilkan **Total Item (4)** dan **Total Harga (Rp 3.800.000)** yang diperbarui otomatis oleh `BlocBuilder`.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/6ccb05b0-3dc1-4621-b839-80259ab0996b" />
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/bd9a5e32-8abe-495b-9c53-ab0877796ae2" />

### Gambar 5 — Dialog Checkout Berhasil
> Dialog konfirmasi muncul menampilkan total item dan harga. Setelah "Selesai" ditekan, `ClearCartEvent` dikirim ke `CartBloc` dan keranjang dikosongkan.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/64553832-0fc9-40c6-a7db-ae03b2bbceef" />

### Gambar 6 — Keranjang Kosong (0 Item)
> Setelah checkout, halaman keranjang menampilkan state kosong **(0 item)** — hasil dari `ClearCartEvent` yang memicu `emit(const CartState())` di `CartBloc`.
<img width="1080" height="2400" alt="image" src="https://github.com/user-attachments/assets/93da4431-ccda-4500-8d10-982d0fee6b8d" />


---

## 6. Alur Data BLoC

```
User tap "Tambah"
    │
    ▼
context.read<CartBloc>().add(AddToCartEvent(product))
    │
    ▼
CartBloc._onAddToCart()
  → List baru: [...cartItems, product]
  → emit(CartState(cartItems: updatedList))
    │
    ▼
BlocBuilder rebuild otomatis
  → badge AppBar: state.totalItems
  → kartu produk: state.getQuantity(product)
  → UI real-time tanpa setState()
```

---

## 7. Tabel Fitur

| Fitur | Implementasi |
|-------|-------------|
| 7 produk alat olahraga | `ListView.builder` |
| Tambah ke keranjang | `AddToCartEvent` |
| Hapus dari keranjang | `RemoveFromCartEvent` |
| Hapus semua | `ClearCartEvent` |
| Badge real-time | `BlocBuilder` + `state.totalItems` |
| Kontrol +/− per produk | `BlocBuilder` conditional render |
| Total harga real-time | `BlocBuilder` + `state.totalPrice` |
| Keranjang kosong | `BlocBuilder` conditional render |

---

## 8. Kesimpulan

Implementasi BLoC pada aplikasi Sport Shop berhasil memisahkan **logika bisnis** (`CartBloc`) dari **tampilan UI**. Dengan `BlocProvider`, `BlocBuilder`, dan mekanisme `Event → Bloc → State`, perubahan data keranjang ditampilkan secara **real-time** tanpa `setState()`. Pola ini membuat kode lebih **terstruktur**, **mudah di-maintain**, dan **mudah di-test**.
