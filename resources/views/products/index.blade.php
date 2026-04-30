@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
<style>
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
.stat-card {
    background: white;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    border: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    gap: 1rem;
}
.stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.stat-icon.blue   { background: var(--blue-50); }
.stat-icon.green  { background: var(--green-100); }
.stat-icon.yellow { background: var(--yellow-100); }
.stat-icon.red    { background: var(--red-100); }
.stat-value { font-size: 1.5rem; font-weight: 700; color: var(--gray-900); }
.stat-label { font-size: 0.78rem; color: var(--gray-500); margin-top: 1px; }
.card {
    background: white;
    border-radius: 14px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
}
.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.card-title { font-size: 1rem; font-weight: 600; color: var(--gray-900); }
.filter-row { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.search-box {
    position: relative;
}
.search-box input {
    padding: 9px 14px 9px 38px;
    border: 1px solid var(--gray-200);
    border-radius: 10px;
    font-size: 0.875rem;
    outline: none;
    width: 220px;
    transition: border-color 0.2s;
}
.search-box input:focus { border-color: var(--blue-500); }
.search-box .search-icon {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 0.9rem;
}
select.filter-select {
    padding: 9px 14px;
    border: 1px solid var(--gray-200);
    border-radius: 10px;
    font-size: 0.875rem;
    outline: none;
    background: white;
    cursor: pointer;
    transition: border-color 0.2s;
}
select.filter-select:focus { border-color: var(--blue-500); }
.btn-primary {
    background: var(--blue-600);
    color: white;
    padding: 9px 18px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-primary:hover { background: var(--blue-700); }
.btn-sm {
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 4px;
}
.btn-edit  { background: var(--blue-50); color: var(--blue-700); }
.btn-edit:hover { background: var(--blue-100); }
.btn-del   { background: var(--red-100); color: var(--red-600); }
.btn-del:hover { background: #fecaca; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-500);
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-100);
}
tbody tr { border-bottom: 1px solid var(--gray-100); transition: background 0.15s; }
tbody tr:hover { background: var(--blue-50); }
tbody tr:last-child { border-bottom: none; }
td { padding: 13px 16px; font-size: 0.875rem; color: var(--gray-700); vertical-align: middle; }
.product-name { font-weight: 600; color: var(--gray-900); }
.product-sku  { font-size: 0.75rem; color: var(--gray-400); margin-top: 1px; font-family: monospace; }
.badge {
    display: inline-flex; align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-cat    { background: var(--blue-50); color: var(--blue-700); }
.badge-active { background: var(--green-100); color: var(--green-600); }
.badge-inactive { background: var(--gray-100); color: var(--gray-500); }
.badge-low  { background: var(--red-100); color: var(--red-600); }
.price-cell { font-weight: 600; color: var(--blue-700); }
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--gray-400);
}
.empty-state .icon { font-size: 3rem; margin-bottom: 1rem; }
.empty-state p { font-size: 0.9rem; }
.pagination { padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; color: var(--gray-500); border-top: 1px solid var(--gray-100); }
/* Modal */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 999;
    align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    max-width: 420px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    text-align: center;
}
.modal-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--gray-900); }
.modal-desc  { font-size: 0.875rem; color: var(--gray-500); margin-bottom: 1.5rem; }
.modal-actions { display: flex; gap: 10px; justify-content: center; }
.btn-cancel { background: var(--gray-100); color: var(--gray-700); padding: 10px 22px; border-radius: 10px; font-size: 0.875rem; border: none; cursor: pointer; font-weight: 500; }
.btn-cancel:hover { background: var(--gray-200); }
.btn-danger { background: var(--red-600); color: white; padding: 10px 22px; border-radius: 10px; font-size: 0.875rem; border: none; cursor: pointer; font-weight: 600; }
.btn-danger:hover { background: #b91c1c; }
@media (max-width: 768px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="page-header">
    <h1>📦 Inventori Produk</h1>
    <p>Kelola stok dan produk Toko Pak Cokomi & Mas Wowo</p>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">📦</div>
        <div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Total Produk</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div><div class="stat-value">{{ $stats['active'] }}</div><div class="stat-label">Produk Aktif</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">⚠️</div>
        <div><div class="stat-value">{{ $stats['low_stock'] }}</div><div class="stat-label">Stok Menipis</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">💰</div>
        <div><div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</div><div class="stat-label">Total Nilai Stok</div></div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Produk</div>
        <div class="filter-row">
            <form method="GET" action="{{ route('products.index') }}" style="display:flex;gap:10px;flex-wrap:wrap">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                </div>
                <select name="category" class="filter-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="btn-primary">Filter</button>
                @if(request()->hasAny(['search','category','status']))
                    <a href="{{ route('products.index') }}" class="btn-cancel" style="text-decoration:none;display:inline-flex;align-items:center">Reset</a>
                @endif
            </form>
            <a href="{{ route('products.create') }}" class="btn-primary">+ Tambah Produk</a>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="empty-state">
            <div class="icon">🗂️</div>
            <p>Tidak ada produk ditemukan.<br>Coba ubah filter atau tambah produk baru.</p>
        </div>
    @else
    <div style="overflow-x:auto">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th style="text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $i => $product)
            <tr>
                <td style="color:var(--gray-400);font-size:0.8rem">{{ $products->firstItem() + $i }}</td>
                <td>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-sku">{{ $product->sku ?? '—' }}</div>
                </td>
                <td><span class="badge badge-cat">{{ $product->category }}</span></td>
                <td class="price-cell">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <span class="{{ $product->stock < 10 ? 'badge badge-low' : '' }}">
                        {{ $product->stock }} {{ $product->unit }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $product->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                        {{ $product->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td style="text-align:center">
                    <div style="display:flex;gap:6px;justify-content:center">
                        <a href="{{ route('products.edit', $product) }}" class="btn-sm btn-edit">✏️ Edit</a>
                        <button class="btn-sm btn-del" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')">🗑️ Hapus</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="pagination">
        <span>Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk</span>
        {{ $products->links() }}
    </div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <div class="modal-title">Hapus Produk?</div>
        <div class="modal-desc">Apakah kamu yakin ingin menghapus produk <strong id="deleteProductName"></strong>? Tindakan ini tidak bisa dibatalkan.</div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">Ya, Hapus!</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteProductName').textContent = name;
    document.getElementById('deleteForm').action = '/products/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection