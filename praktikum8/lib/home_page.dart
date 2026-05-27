import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'notification_service.dart';

/// Halaman utama aplikasi.
/// Menggunakan StatefulWidget karena state (foto) dapat berubah
/// saat user mengambil atau memilih foto baru.
class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  // Menyimpan path file foto yang dipilih/diambil. Null = belum ada foto.
  File? _selectedImage;

  // Instansi ImagePicker untuk mengakses kamera dan galeri
  final ImagePicker _picker = ImagePicker();

  // Menyimpan sumber foto terakhir untuk ditampilkan sebagai label
  String? _imageSource;

  /// Membuka kamera dan mengambil foto secara langsung.
  Future<void> _pickFromCamera() async {
    try {
      // XFile adalah representasi file lintas platform dari image_picker
      final XFile? photo = await _picker.pickImage(
        source: ImageSource.camera,   // Membuka aplikasi kamera
        imageQuality: 85,             // Kompresi kualitas gambar (0-100)
        maxWidth: 1080,               // Batas lebar maksimal gambar
      );

      if (photo != null) {
        // setState memperbarui UI dengan foto baru yang dipilih
        setState(() {
          _selectedImage = File(photo.path);
          _imageSource = 'Kamera';
        });

        // Tampilkan notifikasi setelah foto berhasil diambil
        await NotificationService.showNotification(source: 'camera');
      }
    } catch (e) {
      _showErrorSnackBar('Gagal membuka kamera: $e');
    }
  }

  /// Membuka galeri dan memilih foto yang sudah ada.
  Future<void> _pickFromGallery() async {
    try {
      final XFile? image = await _picker.pickImage(
        source: ImageSource.gallery,  // Membuka galeri foto
        imageQuality: 85,
        maxWidth: 1080,
      );

      if (image != null) {
        setState(() {
          _selectedImage = File(image.path);
          _imageSource = 'Galeri';
        });

        // Tampilkan notifikasi setelah foto berhasil dipilih
        await NotificationService.showNotification(source: 'gallery');
      }
    } catch (e) {
      _showErrorSnackBar('Gagal membuka galeri: $e');
    }
  }

  /// Menampilkan pesan error menggunakan SnackBar di bagian bawah layar.
  void _showErrorSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.red.shade700,
        behavior: SnackBarBehavior.floating,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;

    // Scaffold menyediakan struktur halaman dasar (AppBar, Body, dll)
    return Scaffold(
      backgroundColor: colorScheme.surface,
      appBar: AppBar(
        backgroundColor: colorScheme.primary,
        foregroundColor: colorScheme.onPrimary,
        title: const Text(
          'Praktikum 8 - Kamera & Notifikasi',
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
        ),
      ),

      // SingleChildScrollView agar halaman bisa di-scroll jika konten panjang
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            const SizedBox(height: 8),

            // ===== SECTION: TOMBOL AKSI =====
            _buildSectionTitle('Pilih Sumber Foto', colorScheme),
            const SizedBox(height: 16),

            // Tombol Kamera
            _buildActionButton(
              icon: Icons.camera_alt_rounded,
              label: 'Buka Kamera',
              subtitle: 'Ambil foto langsung dengan kamera',
              color: colorScheme.primary,
              onTap: _pickFromCamera,
            ),
            const SizedBox(height: 12),

            // Tombol Galeri
            _buildActionButton(
              icon: Icons.photo_library_rounded,
              label: 'Pilih dari Galeri',
              subtitle: 'Pilih foto yang sudah tersimpan',
              color: colorScheme.secondary,
              onTap: _pickFromGallery,
            ),

            const SizedBox(height: 28),
            const Divider(),
            const SizedBox(height: 16),

            // ===== SECTION: TAMPILAN FOTO =====
            _buildSectionTitle('Hasil Foto', colorScheme),
            const SizedBox(height: 16),

            // Menampilkan foto atau placeholder jika belum ada foto
            _buildImageDisplay(colorScheme),
          ],
        ),
      ),
    );
  }

  /// Widget untuk judul setiap section.
  Widget _buildSectionTitle(String title, ColorScheme colorScheme) {
    return Text(
      title,
      style: TextStyle(
        fontSize: 18,
        fontWeight: FontWeight.w700,
        color: colorScheme.onSurface,
        letterSpacing: 0.3,
      ),
    );
  }

  /// Widget tombol aksi dengan ikon, label, dan subtitle.
  /// Menggunakan Material + InkWell untuk efek ripple saat ditekan.
  Widget _buildActionButton({
    required IconData icon,
    required String label,
    required String subtitle,
    required Color color,
    required VoidCallback onTap,
  }) {
    return Material(
      color: color,
      borderRadius: BorderRadius.circular(16),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(16),
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 18),
          child: Row(
            children: [
              // Container lingkaran sebagai background ikon
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  shape: BoxShape.circle,
                ),
                child: Icon(icon, color: Colors.white, size: 28),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      label,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 16,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                    const SizedBox(height: 2),
                    Text(
                      subtitle,
                      style: TextStyle(
                        color: Colors.white.withValues(alpha: 0.85),
                        fontSize: 12,
                      ),
                    ),
                  ],
                ),
              ),
              const Icon(Icons.arrow_forward_ios, color: Colors.white, size: 16),
            ],
          ),
        ),
      ),
    );
  }

  /// Widget untuk menampilkan foto atau placeholder.
  /// Menggunakan AnimatedSwitcher agar ada animasi fade saat foto berganti.
  Widget _buildImageDisplay(ColorScheme colorScheme) {
    return AnimatedSwitcher(
      duration: const Duration(milliseconds: 400),
      child: _selectedImage == null
          ? _buildPlaceholder(colorScheme)       // Tampilkan placeholder
          : _buildImageCard(colorScheme),         // Tampilkan foto
    );
  }

  /// Placeholder yang tampil sebelum foto dipilih.
  Widget _buildPlaceholder(ColorScheme colorScheme) {
    return Container(
      key: const ValueKey('placeholder'),
      height: 280,
      decoration: BoxDecoration(
        color: colorScheme.surfaceContainerHighest,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(
          color: colorScheme.outline.withValues(alpha: 0.3),
          width: 2,
          strokeAlign: BorderSide.strokeAlignInside,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.image_outlined,
            size: 72,
            color: colorScheme.onSurfaceVariant.withValues(alpha: 0.4),
          ),
          const SizedBox(height: 12),
          Text(
            'Belum ada foto',
            style: TextStyle(
              fontSize: 16,
              color: colorScheme.onSurfaceVariant.withValues(alpha: 0.6),
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            'Tekan tombol di atas untuk memulai',
            style: TextStyle(
              fontSize: 13,
              color: colorScheme.onSurfaceVariant.withValues(alpha: 0.4),
            ),
          ),
        ],
      ),
    );
  }

  /// Card yang menampilkan foto yang sudah dipilih beserta label sumbernya.
  Widget _buildImageCard(ColorScheme colorScheme) {
    return Container(
      key: const ValueKey('image'),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.1),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(20),
        child: Column(
          children: [
            // Image.file menampilkan gambar dari file lokal di perangkat
            Image.file(
              _selectedImage!,
              fit: BoxFit.cover,          // Gambar memenuhi area tanpa distorsi
              width: double.infinity,
              height: 320,
            ),
            // Label sumber foto di bagian bawah gambar
            Container(
              width: double.infinity,
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
              color: colorScheme.primaryContainer,
              child: Row(
                children: [
                  Icon(
                    _imageSource == 'Kamera'
                        ? Icons.camera_alt_rounded
                        : Icons.photo_library_rounded,
                    size: 18,
                    color: colorScheme.onPrimaryContainer,
                  ),
                  const SizedBox(width: 8),
                  Text(
                    'Sumber: $_imageSource',
                    style: TextStyle(
                      color: colorScheme.onPrimaryContainer,
                      fontWeight: FontWeight.w600,
                      fontSize: 14,
                    ),
                  ),
                  const Spacer(),
                  // Chip kecil sebagai badge konfirmasi
                  Container(
                    padding:
                        const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: Colors.green.shade600,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Row(
                      children: [
                        Icon(Icons.check, color: Colors.white, size: 12),
                        SizedBox(width: 4),
                        Text(
                          'Berhasil',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 11,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
