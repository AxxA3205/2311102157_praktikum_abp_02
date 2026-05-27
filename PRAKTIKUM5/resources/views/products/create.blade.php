@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<style>
.back-link { display:inline-flex;align-items:center;gap:6px;color:var(--gray-500);font-size:0.875rem;text-decoration:none;margin-bottom:1.25rem; }
.back-link:hover { color:var(--blue-600); }
.form-card { background:white;border-radius:14px;border:1px solid var(--gray-200);overflow:hidden; }
.form-header { padding:1.5rem;border-bottom:1px solid var(--gray-100); }
.form-header h2 { font-size:1.1rem;font-weight:700;color:var(--gray-900); }
.form-header p { font-size:0.875rem;color:var(--gray-500);margin-top:2px; }
.form-body { padding:1.75rem; }
.form-grid { display:grid;grid-template-columns:1fr 1fr;gap:1.25rem; }
.form-group { display:flex;flex-direction:column;gap:6px; }
.form-group.full { grid-column:1/-1; }
label { font-size:0.825rem;font-weight:600;color:var(--gray-700); }
.form-control {
    padding:10px 14px;
    border:1px solid var(--gray-200);
    border-radius:10px;
    font-size:0.875rem;
    outline:none;
    transition:border-color 0.2s,box-shadow 0.2s;
    width:100%;
    background:white;
    color:var(--gray-800);
}
.form-control:focus { border-color:var(--blue-500);box-shadow:0 0 0 3px rgba(59,130,246,0.12); }
.form-control.is-invalid { border-color:var(--red-600); }
textarea.form-control { resize:vertical;min-height:100px; }
.invalid-feedback { font-size:0.78rem;color:var(--red-600);margin-top:2px; }
.form-footer { padding:1.25rem 1.75rem;border-top:1px solid var(--gray-100);display:flex;gap:10px;justify-content:flex-end; }
.input-group { display:flex; }
.input-group .form-control { border-radius:10px 0 0 10px; }
.input-addon { padding:10px 14px;background:var(--gray-50);border:1px solid var(--gray-200);border-left:none;border-radius:0 10px 10px 0;font-size:0.875rem;color:var(--gray-500);white-space:nowrap; }
@media (max-width:640px) { .form-grid { grid-template-columns:1fr; } }
</style>

<a href="{{ route('products.index') }}" class="back-link">← Kembali ke Daftar</a>

<div class="page-header">
    <h1>➕ Tambah Produk Baru</h1>
    <p>Isi detail produk yang ingin ditambahkan ke inventori</p>
</div>

<div class="form-card">
    <div class="form-header">
        <h2>Informasi Produk</h2>
        <p>Kolom bertanda <span style="color:var(--red-600)">*</span> wajib diisi</p>
    </div>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="form-body">
            <div class="form-grid">
                <div class="form-group full">
                    <label>Nama Produk <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Contoh: Beras Premium 5kg">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Kategori <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="category" list="category-list"
                           class="form-control @error('category') is-invalid @enderror"
                           value="{{ old('category') }}" placeholder="Pilih atau ketik baru">
                    <datalist id="category-list">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>SKU / Kode Produk</label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                           value="{{ old('sku') }}" placeholder="Contoh: PRD-001-BR" style="font-family:monospace">
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Harga <span style="color:var(--red-600)">*</span></label>
                    <div class="input-group">
                        <span class="input-addon" style="border-left:1px solid var(--gray-200);border-right:none;border-radius:10px 0 0 10px">Rp</span>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               style="border-radius:0 10px 10px 0;border-left:none"
                               value="{{ old('price') }}" placeholder="0" min="0" step="500">
                    </div>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Stok <span style="color:var(--red-600)">*</span></label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', 0) }}" min="0">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Satuan <span style="color:var(--red-600)">*</span></label>
                    <select name="unit" class="form-control @error('unit') is-invalid @enderror">
                        @foreach(['pcs','kg','liter','pak','lusin','botol','kaleng','dus','gram','ml'] as $u)
                            <option value="{{ $u }}" {{ old('unit') == $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                    @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Status <span style="color:var(--red-600)">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status','active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              placeholder="Deskripsi singkat produk (opsional)">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('products.index') }}" class="btn-cancel" style="text-decoration:none;display:inline-flex;align-items:center">Batal</a>
            <button type="submit" class="btn-primary">💾 Simpan Produk</button>
        </div>
    </form>
</div>
@endsection