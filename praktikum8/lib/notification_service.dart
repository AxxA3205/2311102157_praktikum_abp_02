import 'package:flutter_local_notifications/flutter_local_notifications.dart';

/// Service class untuk mengelola semua operasi notifikasi lokal.
/// Menggunakan singleton pattern melalui static methods agar bisa
/// diakses dari mana saja tanpa membuat instance baru.
class NotificationService {
  // Instance plugin notifikasi (FlutterLocalNotificationsPlugin)
  static final FlutterLocalNotificationsPlugin _notificationsPlugin =
      FlutterLocalNotificationsPlugin();

  /// Inisialisasi plugin notifikasi.
  /// Dipanggil sekali saat aplikasi pertama kali dijalankan (di main.dart).
  static Future<void> initialize() async {
    // Pengaturan inisialisasi untuk platform Android
    const AndroidInitializationSettings initializationSettingsAndroid =
        AndroidInitializationSettings('@mipmap/ic_launcher');

    const InitializationSettings initializationSettings =
        InitializationSettings(
      android: initializationSettingsAndroid,
    );

    await _notificationsPlugin.initialize(
      initializationSettings,
      onDidReceiveNotificationResponse: (NotificationResponse response) {
        // Callback ketika user mengetuk notifikasi (bisa dikembangkan)
      },
    );

    // Meminta izin notifikasi (Android 13+)
    await _notificationsPlugin
        .resolvePlatformSpecificImplementation<
            AndroidFlutterLocalNotificationsPlugin>()
        ?.requestNotificationsPermission();
  }

  /// Menampilkan notifikasi lokal.
  /// [source] menentukan teks notifikasi: 'camera' atau 'gallery'
  static Future<void> showNotification({required String source}) async {
    // Detail tampilan notifikasi di Android
    const AndroidNotificationDetails androidNotificationDetails =
        AndroidNotificationDetails(
      'foto_channel_id',   // ID channel (unik per kategori notifikasi)
      'Foto Notifikasi',   // Nama channel (tampil di pengaturan HP)
      channelDescription: 'Notifikasi setelah mengambil atau memilih foto',
      importance: Importance.max,   // Prioritas notifikasi (muncul sebagai heads-up)
      priority: Priority.high,
      showWhen: true,
      icon: '@mipmap/ic_launcher',
    );

    const NotificationDetails notificationDetails =
        NotificationDetails(android: androidNotificationDetails);

    // Menentukan isi pesan berdasarkan sumber foto
    final String title =
        source == 'camera' ? '📷 Foto Berhasil Diambil!' : '🖼️ Foto Dipilih!';
    final String body = source == 'camera'
        ? 'Foto dari kamera berhasil diambil dan ditampilkan.'
        : 'Foto dari galeri berhasil dipilih dan ditampilkan.';

    await _notificationsPlugin.show(
      0,      // ID notifikasi (0 = selalu replace notifikasi sebelumnya)
      title,
      body,
      notificationDetails,
    );
  }
}
