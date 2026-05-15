import 'package:flutter/material.dart';

void main() {
  runApp(const WisataNusantaraApp());
}

// ════════════════════════════════════════════════════════════
// APP ROOT
// ════════════════════════════════════════════════════════════
class WisataNusantaraApp extends StatelessWidget {
  const WisataNusantaraApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Wisata Nusantara',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        useMaterial3: true,
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF006B6B),
        ),
        scaffoldBackgroundColor: const Color(0xFFF0F4F3),
      ),
      home: const HomeScreen(),
    );
  }
}

// ════════════════════════════════════════════════════════════
// DATA
// ════════════════════════════════════════════════════════════

/// Data untuk GridView — 6 destinasi wisata Indonesia
const List<Map<String, dynamic>> destinasiList = [
  {
    'name': 'Bali',
    'emoji': '🌊',
    'tag': 'Pantai',
    'color': Color(0xFF29B6F6),
  },
  {
    'name': 'Raja Ampat',
    'emoji': '🐠',
    'tag': 'Bahari',
    'color': Color(0xFF26C6DA),
  },
  {
    'name': 'Borobudur',
    'emoji': '🏛️',
    'tag': 'Budaya',
    'color': Color(0xFFFFA726),
  },
  {
    'name': 'Komodo',
    'emoji': '🦎',
    'tag': 'Alam',
    'color': Color(0xFF66BB6A),
  },
  {
    'name': 'Labuan Bajo',
    'emoji': '⛵',
    'tag': 'Petualangan',
    'color': Color(0xFFEF5350),
  },
  {
    'name': 'Bromo',
    'emoji': '🌋',
    'tag': 'Gunung',
    'color': Color(0xFFAB47BC),
  },
];

/// Data untuk ListView (3 item: A, B, C)
const List<Map<String, String>> kategoriList = [
  {
    'label': 'A',
    'title': 'Wisata Pantai',
    'desc': 'Nikmati keindahan pesisir Nusantara yang memukau',
  },
  {
    'label': 'B',
    'title': 'Wisata Budaya',
    'desc': 'Jelajahi warisan leluhur dan tradisi bangsa',
  },
  {
    'label': 'C',
    'title': 'Wisata Alam',
    'desc': 'Petualangan di alam bebas Indonesia nan hijau',
  },
];

/// Data untuk ListView.builder — kuliner Nusantara
const List<Map<String, String>> kulinerList = [
  {'nama': 'Rendang', 'asal': 'Sumatera Barat'},
  {'nama': 'Nasi Goreng', 'asal': 'Jawa'},
  {'nama': 'Soto Betawi', 'asal': 'Jakarta'},
  {'nama': 'Gudeg', 'asal': 'Yogyakarta'},
  {'nama': 'Pempek', 'asal': 'Palembang'},
  {'nama': 'Coto Makassar', 'asal': 'Sulawesi Selatan'},
  {'nama': 'Papeda', 'asal': 'Papua'},
];

/// Data untuk ListView.separated — spot terpopuler
const List<Map<String, String>> popularSpots = [
  {'nama': 'Tanah Lot', 'lokasi': 'Bali', 'rating': '4.9'},
  {'nama': 'Candi Prambanan', 'lokasi': 'Yogyakarta', 'rating': '4.8'},
  {'nama': 'Danau Toba', 'lokasi': 'Sumatera Utara', 'rating': '4.7'},
  {'nama': 'Gili Trawangan', 'lokasi': 'Lombok', 'rating': '4.6'},
  {'nama': 'Kepulauan Derawan', 'lokasi': 'Kalimantan Timur', 'rating': '4.8'},
];

// ════════════════════════════════════════════════════════════
// HOME SCREEN
// ════════════════════════════════════════════════════════════
class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // 1. STACK — Hero header bertumpuk
            const StackHeroSection(),
            const SizedBox(height: 20),

            // 2. CONTAINER — Info banner berwarna
            const ContainerSection(),
            const SizedBox(height: 24),

            // 3. GRIDVIEW — 6 destinasi
            const SectionLabel(
              icon: '🗺️',
              title: 'Destinasi Pilihan',
              widgetTag: 'GridView',
            ),
            const GridViewSection(),
            const SizedBox(height: 24),

            // 4. LISTVIEW — 3 kategori (A, B, C)
            const SectionLabel(
              icon: '🏷️',
              title: 'Kategori Wisata',
              widgetTag: 'ListView',
            ),
            const ListViewSection(),
            const SizedBox(height: 24),

            // 5. LISTVIEW.BUILDER — dari array kulinerList
            const SectionLabel(
              icon: '🍜',
              title: 'Kuliner Nusantara',
              widgetTag: 'ListView.builder',
            ),
            const ListViewBuilderSection(),
            const SizedBox(height: 24),

            // 6. LISTVIEW.SEPARATED — spot populer + divider
            const SectionLabel(
              icon: '⭐',
              title: 'Spot Terpopuler',
              widgetTag: 'ListView.separated',
            ),
            const ListViewSeparatedSection(),
            const SizedBox(height: 40),
          ],
        ),
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// 1. STACK WIDGET
// Menampilkan elemen bertumpuk: gradient background,
// lingkaran dekoratif, dan konten teks di atasnya.
// ════════════════════════════════════════════════════════════
class StackHeroSection extends StatelessWidget {
  const StackHeroSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Stack(
      clipBehavior: Clip.none,
      children: [
        // Layer 1: Gradient background
        Container(
          height: 280,
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
              colors: [
                Color(0xFF004D4D),
                Color(0xFF006B6B),
                Color(0xFF00A896),
              ],
            ),
          ),
        ),

        // Layer 2: Lingkaran dekoratif kanan atas (bertumpuk)
        Positioned(
          top: -50,
          right: -50,
          child: Container(
            width: 200,
            height: 200,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: Colors.white.withAlpha(18),
            ),
          ),
        ),

        // Layer 3: Lingkaran dekoratif kiri bawah (bertumpuk)
        Positioned(
          bottom: -30,
          left: -30,
          child: Container(
            width: 150,
            height: 150,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: Colors.white.withAlpha(13),
            ),
          ),
        ),

        // Layer 4: Kotak kecil dekoratif (bertumpuk di atas segalanya)
        Positioned(
          top: 80,
          right: 30,
          child: Container(
            width: 60,
            height: 60,
            decoration: BoxDecoration(
              color: Colors.white.withAlpha(25),
              borderRadius: BorderRadius.circular(16),
            ),
            child: const Center(
              child: Text('🧭', style: TextStyle(fontSize: 28)),
            ),
          ),
        ),

        // Layer 5: Konten utama (paling atas)
        SafeArea(
          child: Padding(
            padding: const EdgeInsets.fromLTRB(24, 20, 24, 24),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Badge negara
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 12,
                    vertical: 6,
                  ),
                  decoration: BoxDecoration(
                    color: Colors.white.withAlpha(40),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(
                      color: Colors.white.withAlpha(60),
                    ),
                  ),
                  child: const Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text('🇮🇩', style: TextStyle(fontSize: 14)),
                      SizedBox(width: 6),
                      Text(
                        'Indonesia',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 16),

                // Judul utama
                const Text(
                  'Wisata\nNusantara',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 38,
                    fontWeight: FontWeight.bold,
                    height: 1.1,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  'Jelajahi keindahan dari Sabang sampai Merauke.',
                  style: TextStyle(
                    color: Colors.white.withAlpha(178),
                    fontSize: 13,
                  ),
                ),
                const SizedBox(height: 20),

                // Badge statistik
                Row(
                  children: [
                    _StatBadge(icon: '🏝️', label: '17.000+ Pulau'),
                    const SizedBox(width: 10),
                    _StatBadge(icon: '🎭', label: '300+ Budaya'),
                  ],
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }
}

class _StatBadge extends StatelessWidget {
  final String icon;
  final String label;
  const _StatBadge({required this.icon, required this.label});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 7),
      decoration: BoxDecoration(
        color: Colors.white.withAlpha(45),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Colors.white.withAlpha(70)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(icon, style: const TextStyle(fontSize: 13)),
          const SizedBox(width: 6),
          Text(
            label,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 12,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// 2. CONTAINER WIDGET
// Kotak berwarna berisi konten info singkat.
// ════════════════════════════════════════════════════════════
class ContainerSection extends StatelessWidget {
  const ContainerSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: const Color(0xFFFFFBF0),
          borderRadius: BorderRadius.circular(20),
          border: Border.all(color: const Color(0xFFFFE082)),
          boxShadow: [
            BoxShadow(
              color: const Color(0xFFFFC107).withAlpha(40),
              blurRadius: 12,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Row(
          children: [
            // Ikon kotak berwarna di dalam Container
            Container(
              width: 58,
              height: 58,
              decoration: BoxDecoration(
                color: const Color(0xFFFFC107),
                borderRadius: BorderRadius.circular(16),
              ),
              child: const Center(
                child: Text('🌟', style: TextStyle(fontSize: 30)),
              ),
            ),
            const SizedBox(width: 16),
            const Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Destinasi Impian Kamu',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 15,
                      color: Color(0xFF1A1A2E),
                    ),
                  ),
                  SizedBox(height: 4),
                  Text(
                    'Temukan tempat terbaik untuk liburan tak terlupakan bersama orang tersayang.',
                    style: TextStyle(fontSize: 12, color: Color(0xFF6B6B6B)),
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

// ════════════════════════════════════════════════════════════
// 3. GRIDVIEW WIDGET
// Menampilkan 6 destinasi dalam grid 2 kolom.
// shrinkWrap + NeverScrollableScrollPhysics agar tidak
// konflik dengan SingleChildScrollView di luar.
// ════════════════════════════════════════════════════════════
class GridViewSection extends StatelessWidget {
  const GridViewSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: GridView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        itemCount: destinasiList.length,
        gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: 2,
          crossAxisSpacing: 12,
          mainAxisSpacing: 12,
          childAspectRatio: 1.05,
        ),
        itemBuilder: (context, index) {
          final d = destinasiList[index];
          final color = d['color'] as Color;
          return Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: color.withAlpha(25),
              borderRadius: BorderRadius.circular(18),
              border: Border.all(color: color.withAlpha(70)),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  d['emoji'] as String,
                  style: const TextStyle(fontSize: 34),
                ),
                const Spacer(),
                Text(
                  d['name'] as String,
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 15,
                    color: Color(0xFF1A1A2E),
                  ),
                ),
                const SizedBox(height: 6),
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 10,
                    vertical: 4,
                  ),
                  decoration: BoxDecoration(
                    color: color,
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Text(
                    d['tag'] as String,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 10,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// 4. LISTVIEW WIDGET
// 3 item (A, B, C) — horizontal scroll card.
// ════════════════════════════════════════════════════════════
class ListViewSection extends StatelessWidget {
  const ListViewSection({super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 115,
      child: ListView(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        children: kategoriList.map((k) {
          return Container(
            width: 210,
            margin: const EdgeInsets.only(right: 12),
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [Color(0xFF006B6B), Color(0xFF00A896)],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(18),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  k['label']!,
                  style: TextStyle(
                    color: Colors.white.withAlpha(100),
                    fontSize: 26,
                    fontWeight: FontWeight.bold,
                    height: 1,
                  ),
                ),
                const Spacer(),
                Text(
                  k['title']!,
                  style: const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                    fontSize: 13,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  k['desc']!,
                  style: TextStyle(
                    color: Colors.white.withAlpha(178),
                    fontSize: 10,
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          );
        }).toList(),
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// 5. LISTVIEW.BUILDER WIDGET
// Membangun list dari array kulinerList secara otomatis.
// ════════════════════════════════════════════════════════════
class ListViewBuilderSection extends StatelessWidget {
  const ListViewBuilderSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(18),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(13),
              blurRadius: 10,
              offset: const Offset(0, 2),
            ),
          ],
        ),
        child: ListView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          itemCount: kulinerList.length,
          itemBuilder: (context, index) {
            final k = kulinerList[index];
            return Padding(
              padding: const EdgeInsets.symmetric(vertical: 7),
              child: Row(
                children: [
                  // Nomor urut dalam Container berwarna
                  Container(
                    width: 38,
                    height: 38,
                    decoration: BoxDecoration(
                      color: const Color(0xFF006B6B).withAlpha(25),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Center(
                      child: Text(
                        '${index + 1}',
                        style: const TextStyle(
                          color: Color(0xFF006B6B),
                          fontWeight: FontWeight.bold,
                          fontSize: 14,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 14),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        k['nama']!,
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.w600,
                          color: Color(0xFF1A1A2E),
                        ),
                      ),
                      Text(
                        k['asal']!,
                        style: const TextStyle(
                          fontSize: 11,
                          color: Color(0xFF9E9E9E),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// 6. LISTVIEW.SEPARATED WIDGET
// List dengan garis pembatas (Divider) antar item.
// ════════════════════════════════════════════════════════════
class ListViewSeparatedSection extends StatelessWidget {
  const ListViewSeparatedSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(18),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(13),
              blurRadius: 10,
              offset: const Offset(0, 2),
            ),
          ],
        ),
        child: ListView.separated(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          itemCount: popularSpots.length,
          // separatorBuilder: garis pembatas antar item
          separatorBuilder: (context, index) => const Divider(
            height: 1,
            thickness: 1,
            color: Color(0xFFF0F0F0),
          ),
          itemBuilder: (context, index) {
            final spot = popularSpots[index];
            return Padding(
              padding: const EdgeInsets.symmetric(vertical: 12),
              child: Row(
                children: [
                  // Ikon lokasi
                  Container(
                    width: 40,
                    height: 40,
                    decoration: BoxDecoration(
                      color: const Color(0xFFE0F5F5),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(
                      Icons.location_on_rounded,
                      color: Color(0xFF006B6B),
                      size: 20,
                    ),
                  ),
                  const SizedBox(width: 12),

                  // Nama & lokasi
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          spot['nama']!,
                          style: const TextStyle(
                            fontWeight: FontWeight.w700,
                            fontSize: 13,
                            color: Color(0xFF1A1A2E),
                          ),
                        ),
                        const SizedBox(height: 2),
                        Text(
                          spot['lokasi']!,
                          style: const TextStyle(
                            fontSize: 11,
                            color: Color(0xFF9E9E9E),
                          ),
                        ),
                      ],
                    ),
                  ),

                  // Rating bintang
                  Row(
                    children: [
                      const Icon(
                        Icons.star_rounded,
                        color: Color(0xFFFFC107),
                        size: 16,
                      ),
                      const SizedBox(width: 3),
                      Text(
                        spot['rating']!,
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF1A1A2E),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }
}

// ════════════════════════════════════════════════════════════
// REUSABLE WIDGETS
// ════════════════════════════════════════════════════════════

/// Label judul section dengan badge nama widget
class SectionLabel extends StatelessWidget {
  final String icon;
  final String title;
  final String widgetTag;

  const SectionLabel({
    super.key,
    required this.icon,
    required this.title,
    required this.widgetTag,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(16, 0, 16, 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Text(icon, style: const TextStyle(fontSize: 16)),
              const SizedBox(width: 8),
              Text(
                title,
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF1A1A2E),
                ),
              ),
            ],
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 9, vertical: 4),
            decoration: BoxDecoration(
              color: const Color(0xFF006B6B).withAlpha(25),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Text(
              widgetTag,
              style: const TextStyle(
                fontSize: 10,
                color: Color(0xFF006B6B),
                fontWeight: FontWeight.w700,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
