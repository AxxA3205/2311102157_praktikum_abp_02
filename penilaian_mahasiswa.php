<?php
// =============================================
// DATA MAHASISWA (Array Asosiatif)
// =============================================
$mahasiswa = [
    [
        "nama"        => "Ahmad Fauzi",
        "nim"         => "2210101001",
        "nilai_tugas" => 85,
        "nilai_uts"   => 78,
        "nilai_uas"   => 82,
    ],
    [
        "nama"        => "Budi Santoso",
        "nim"         => "2210101002",
        "nilai_tugas" => 70,
        "nilai_uts"   => 65,
        "nilai_uas"   => 60,
    ],
    [
        "nama"        => "Citra Dewi",
        "nim"         => "2210101003",
        "nilai_tugas" => 90,
        "nilai_uts"   => 88,
        "nilai_uas"   => 92,
    ],
    [
        "nama"        => "Dian Pratiwi",
        "nim"         => "2210101004",
        "nilai_tugas" => 60,
        "nilai_uts"   => 55,
        "nilai_uas"   => 58,
    ],
    [
        "nama"        => "Eko Wahyudi",
        "nim"         => "2210101005",
        "nilai_tugas" => 75,
        "nilai_uts"   => 80,
        "nilai_uas"   => 77,
    ],
    [
        "nama"        => "Fitri Handayani",
        "nim"         => "2210101006",
        "nilai_tugas" => 95,
        "nilai_uts"   => 91,
        "nilai_uas"   => 94,
    ],
];

// =============================================
// FUNCTION: Hitung Nilai Akhir
// Bobot: Tugas 20%, UTS 40%, UAS 40%
// =============================================
function hitungNilaiAkhir($tugas, $uts, $uas) {
    return ($tugas * 0.20) + ($uts * 0.40) + ($uas * 0.40);
}

// =============================================
// FUNCTION: Tentukan Grade
// =============================================
function tentukanGrade($nilai) {
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 75) {
        return "B";
    } elseif ($nilai >= 70) {
        return "C";
    } elseif ($nilai >= 60) {
        return "D";
    } else {
        return "E";
    }
}

// =============================================
// FUNCTION: Status Kelulusan (passing grade >= 70)
// =============================================
function tentukanStatus($nilai) {
    return ($nilai >= 70) ? "Lulus" : "Tidak Lulus";
}

// =============================================
// PROSES DATA: Loop semua mahasiswa
// =============================================
$total_nilai   = 0;
$nilai_tertinggi = 0;
$nama_tertinggi  = "";
$hasil = [];

foreach ($mahasiswa as $mhs) {
    $nilai_akhir = hitungNilaiAkhir(
        $mhs["nilai_tugas"],
        $mhs["nilai_uts"],
        $mhs["nilai_uas"]
    );
    $grade  = tentukanGrade($nilai_akhir);
    $status = tentukanStatus($nilai_akhir);

    $hasil[] = [
        "nama"        => $mhs["nama"],
        "nim"         => $mhs["nim"],
        "nilai_tugas" => $mhs["nilai_tugas"],
        "nilai_uts"   => $mhs["nilai_uts"],
        "nilai_uas"   => $mhs["nilai_uas"],
        "nilai_akhir" => round($nilai_akhir, 2),
        "grade"       => $grade,
        "status"      => $status,
    ];

    $total_nilai += $nilai_akhir;

    if ($nilai_akhir > $nilai_tertinggi) {
        $nilai_tertinggi = $nilai_akhir;
        $nama_tertinggi  = $mhs["nama"];
    }
}

$rata_rata = round($total_nilai / count($mahasiswa), 2);
$jumlah_lulus      = count(array_filter($hasil, fn($h) => $h["status"] === "Lulus"));
$jumlah_tidak_lulus = count($hasil) - $jumlah_lulus;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --red:       #e53935;
            --red-dark:  #b71c1c;
            --red-light: #ffebee;
            --sidebar:   #1a1f2e;
            --sidebar-hover: #252b3d;
            --sidebar-active: #2d3452;
            --bg:        #f0f2f7;
            --white:     #ffffff;
            --text:      #2d3452;
            --text-muted:#7b8396;
            --border:    #e4e7ef;
            --green:     #2e7d32;
            --green-bg:  #e8f5e9;
            --danger:    #c62828;
            --danger-bg: #ffebee;
            --yellow:    #f57f17;
            --yellow-bg: #fff8e1;
            --shadow:    0 2px 12px rgba(30,40,80,.08);
            --shadow-lg: 0 8px 32px rgba(30,40,80,.13);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--sidebar);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 22px 24px 18px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .sidebar-logo .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: var(--red);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: #fff;
        }
        .logo-text { font-size: 15px; font-weight: 700; color: #fff; letter-spacing: .3px; }
        .logo-sub  { font-size: 10px; color: rgba(255,255,255,.4); letter-spacing: .5px; text-transform: uppercase; }

        .sidebar-section-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 18px 24px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all .18s;
            border-left: 3px solid transparent;
            cursor: pointer;
        }
        .nav-item:hover { background: var(--sidebar-hover); color: #fff; }
        .nav-item.active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: var(--red);
        }
        .nav-item .nav-icon { font-size: 15px; width: 20px; text-align: center; }

        /* ── MAIN ── */
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0;
            z-index: 50;
            box-shadow: var(--shadow);
        }
        .topbar-left { display: flex; align-items: center; gap: 8px; }
        .breadcrumb { font-size: 13px; color: var(--text-muted); }
        .breadcrumb span { color: var(--text); font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .user-badge {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 600; color: var(--text);
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: var(--red);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px; font-weight: 700;
        }

        /* ── CONTENT ── */
        .content { padding: 28px; flex: 1; }

        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap; gap: 12px;
        }
        .page-title { font-size: 20px; font-weight: 700; color: var(--text); }
        .page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        .btn-red {
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            font-family: inherit;
            transition: background .18s, box-shadow .18s;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(229,57,53,.25);
        }
        .btn-red:hover { background: var(--red-dark); box-shadow: 0 4px 14px rgba(229,57,53,.35); }

        /* ── STAT CARDS ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px 22px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid var(--border);
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: var(--shadow-lg); }
        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-icon.red    { background: #ffebee; }
        .stat-icon.green  { background: #e8f5e9; }
        .stat-icon.blue   { background: #e3f2fd; }
        .stat-icon.yellow { background: #fff8e1; }
        .stat-label { font-size: 11px; color: var(--text-muted); font-weight: 600; letter-spacing: .4px; text-transform: uppercase; }
        .stat-value { font-size: 22px; font-weight: 700; color: var(--text); margin-top: 2px; font-family: 'JetBrains Mono', monospace; }
        .stat-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .table-card-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        .table-card-title {
            font-size: 14px; font-weight: 700; color: var(--text);
            display: flex; align-items: center; gap: 8px;
        }
        .table-card-title::before {
            content: '';
            display: inline-block;
            width: 4px; height: 16px;
            background: var(--red);
            border-radius: 2px;
        }
        .table-meta { font-size: 12px; color: var(--text-muted); }

        .search-box {
            display: flex; align-items: center; gap: 8px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 13px;
            color: var(--text-muted);
            background: var(--bg);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        thead th {
            background: #f7f8fb;
            padding: 11px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f9fafc; }
        tbody td {
            padding: 13px 16px;
            vertical-align: middle;
        }

        .nim-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--text-muted);
            background: var(--bg);
            padding: 2px 7px;
            border-radius: 4px;
        }

        .nilai-num {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            font-size: 13px;
        }

        .nilai-akhir-num {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 14px;
            color: var(--text);
        }

        .grade-badge {
            display: inline-flex;
            align-items: center; justify-content: center;
            width: 30px; height: 30px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
        }
        .grade-A { background: #e8f5e9; color: #1b5e20; }
        .grade-B { background: #e3f2fd; color: #0d47a1; }
        .grade-C { background: #fff8e1; color: #e65100; }
        .grade-D { background: #fce4ec; color: #880e4f; }
        .grade-E { background: #ffebee; color: #b71c1c; }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .3px;
        }
        .status-lulus      { background: var(--green-bg);  color: var(--green); }
        .status-tidak-lulus { background: var(--danger-bg); color: var(--danger); }

        /* ── SUMMARY ROW ── */
        .summary-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 20px;
        }
        .summary-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px 22px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        .summary-card h4 {
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; color: var(--text-muted); margin-bottom: 14px;
            display: flex; align-items: center; gap: 6px;
        }
        .summary-card h4::before {
            content: '';
            display: inline-block; width: 4px; height: 14px;
            background: var(--red); border-radius: 2px;
        }
        .summary-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed var(--border);
            font-size: 13px;
        }
        .summary-item:last-child { border-bottom: none; }
        .summary-item .label { color: var(--text-muted); }
        .summary-item .val   { font-weight: 700; font-family: 'JetBrains Mono', monospace; }

        .highlight-box {
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
            border-radius: 10px;
            padding: 14px 18px;
            color: #fff;
            margin-top: 10px;
        }
        .highlight-box .hl-label { font-size: 11px; opacity: .8; font-weight: 500; }
        .highlight-box .hl-name  { font-size: 15px; font-weight: 700; margin-top: 2px; }
        .highlight-box .hl-val   { font-size: 22px; font-weight: 700; font-family: 'JetBrains Mono', monospace; margin-top: 4px; }

        .bobot-info {
            display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px;
        }
        .bobot-chip {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
        }
        .bobot-chip strong { color: var(--text); }

        /* ── FOOTER ── */
        .content-footer {
            padding: 16px 28px;
            border-top: 1px solid var(--border);
            background: var(--white);
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
        }

        /* ── NO BADGE ── */
        .no-cell { color: var(--text-muted); font-size: 12px; }

        @media (max-width: 1100px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .summary-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-badge">
            <div class="logo-icon">S</div>
            <div>
                <div class="logo-text">SPN</div>
                <div class="logo-sub">Sistem Penilaian</div>
            </div>
        </div>
    </div>
    <div class="sidebar-section-title">Data Master</div>
    <a class="nav-item active" href="#">
        <span class="nav-icon">👥</span> Data Mahasiswa
    </a>
</aside>

<!-- ── MAIN ── -->
<div class="main">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-left">
            <div class="breadcrumb">
                <span>Data Mahasiswa</span> &rsaquo; Penilaian
            </div>
        </div>
        <div class="topbar-right">
            <div class="user-badge">
                <div class="user-avatar">A</div>
                Admin
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <div class="page-title">Data Penilaian Mahasiswa</div>
                <div class="page-subtitle">Rekap nilai akhir, grade, dan status kelulusan seluruh mahasiswa</div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon red">👥</div>
                <div>
                    <div class="stat-label">Total Mahasiswa</div>
                    <div class="stat-value"><?= count($hasil) ?></div>
                    <div class="stat-sub">terdaftar</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">✅</div>
                <div>
                    <div class="stat-label">Lulus</div>
                    <div class="stat-value"><?= $jumlah_lulus ?></div>
                    <div class="stat-sub">mahasiswa</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">❌</div>
                <div>
                    <div class="stat-label">Tidak Lulus</div>
                    <div class="stat-value"><?= $jumlah_tidak_lulus ?></div>
                    <div class="stat-sub">mahasiswa</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">📈</div>
                <div>
                    <div class="stat-label">Rata-rata Kelas</div>
                    <div class="stat-value"><?= $rata_rata ?></div>
                    <div class="stat-sub">nilai akhir</div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-card-header">
                <div class="table-card-title">Tabel Nilai Mahasiswa</div>
                <div class="table-meta">
                    Menampilkan <?= count($hasil) ?> data &bull; Passing Grade: ≥ 70
                </div>
            </div>

            <!-- Bobot Info -->
            <div style="padding: 12px 22px; border-bottom: 1px solid var(--border);">
                <div class="bobot-info">
                    <span class="bobot-chip">Rumus: <strong>NA = (Tugas×20%) + (UTS×40%) + (UAS×40%)</strong></span>
                    <span class="bobot-chip">A ≥ 85 &nbsp;|&nbsp; B ≥ 75 &nbsp;|&nbsp; C ≥ 70 &nbsp;|&nbsp; D ≥ 60 &nbsp;|&nbsp; E &lt; 60</span>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th style="text-align:center">Tugas (20%)</th>
                            <th style="text-align:center">UTS (40%)</th>
                            <th style="text-align:center">UAS (40%)</th>
                            <th style="text-align:center">Nilai Akhir</th>
                            <th style="text-align:center">Grade</th>
                            <th style="text-align:center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hasil as $i => $row): ?>
                        <tr>
                            <td class="no-cell"><?= $i + 1 ?></td>
                            <td><span class="nim-code"><?= htmlspecialchars($row["nim"]) ?></span></td>
                            <td style="font-weight:600"><?= htmlspecialchars($row["nama"]) ?></td>
                            <td style="text-align:center">
                                <span class="nilai-num"><?= $row["nilai_tugas"] ?></span>
                            </td>
                            <td style="text-align:center">
                                <span class="nilai-num"><?= $row["nilai_uts"] ?></span>
                            </td>
                            <td style="text-align:center">
                                <span class="nilai-num"><?= $row["nilai_uas"] ?></span>
                            </td>
                            <td style="text-align:center">
                                <span class="nilai-akhir-num"><?= $row["nilai_akhir"] ?></span>
                            </td>
                            <td style="text-align:center">
                                <span class="grade-badge grade-<?= $row["grade"] ?>">
                                    <?= $row["grade"] ?>
                                </span>
                            </td>
                            <td style="text-align:center">
                                <?php if ($row["status"] === "Lulus"): ?>
                                    <span class="status-badge status-lulus">✔ Lulus</span>
                                <?php else: ?>
                                    <span class="status-badge status-tidak-lulus">✘ Tidak Lulus</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-row">
            <div class="summary-card">
                <h4>Statistik Kelas</h4>
                <div class="summary-item">
                    <span class="label">Total Mahasiswa</span>
                    <span class="val"><?= count($hasil) ?> orang</span>
                </div>
                <div class="summary-item">
                    <span class="label">Rata-rata Kelas</span>
                    <span class="val"><?= $rata_rata ?></span>
                </div>
                <div class="summary-item">
                    <span class="label">Jumlah Lulus</span>
                    <span class="val" style="color:var(--green)"><?= $jumlah_lulus ?> orang</span>
                </div>
                <div class="summary-item">
                    <span class="label">Jumlah Tidak Lulus</span>
                    <span class="val" style="color:var(--danger)"><?= $jumlah_tidak_lulus ?> orang</span>
                </div>
                <div class="summary-item">
                    <span class="label">Persentase Lulus</span>
                    <span class="val"><?= round($jumlah_lulus / count($hasil) * 100) ?>%</span>
                </div>
            </div>

            <div class="summary-card">
                <h4>Nilai Tertinggi</h4>
                <div class="highlight-box">
                    <div class="hl-label">🏆 Mahasiswa Terbaik</div>
                    <div class="hl-name"><?= htmlspecialchars($nama_tertinggi) ?></div>
                    <div class="hl-val"><?= round($nilai_tertinggi, 2) ?></div>
                </div>

                <div style="margin-top:14px;">
                    <div class="summary-item">
                        <span class="label">Grade Tertinggi yang Dicapai</span>
                        <span class="val"><?= tentukanGrade($nilai_tertinggi) ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Passing Grade</span>
                        <span class="val">≥ 70</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Bobot Perhitungan</span>
                        <span class="val" style="font-size:11px;font-family:inherit">20 / 40 / 40</span>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /content -->

    <div class="content-footer">
        Sistem Penilaian Mahasiswa &copy; <?= date('Y') ?> &mdash; Pertemuan 3 PHP Assignment
    </div>

</div><!-- /main -->

</body>
</html>
