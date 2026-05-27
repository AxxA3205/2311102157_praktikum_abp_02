import 'package:flutter/material.dart';
import 'notification_service.dart';
import 'home_page.dart';

void main() async {
  // Memastikan Flutter engine sudah siap sebelum menjalankan kode async
  WidgetsFlutterBinding.ensureInitialized();

  // Inisialisasi notifikasi sebelum aplikasi berjalan
  await NotificationService.initialize();

  runApp(const MyApp());
}

/// Widget root aplikasi.
/// MaterialApp menyediakan tema, navigasi, dan konfigurasi dasar aplikasi.
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Praktikum 8',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF6C63FF),
          brightness: Brightness.light,
        ),
        useMaterial3: true,
        appBarTheme: const AppBarTheme(
          centerTitle: true,
          elevation: 0,
        ),
      ),
      home: const HomePage(),
    );
  }
}
