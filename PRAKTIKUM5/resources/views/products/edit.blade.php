@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
@push('styles')
<style>
/* Styles sama seperti create, sudah include di sini */
</style>
@endpush

<a href="{{ route('products.index') }}" class="back-link" style="display:inline-flex;align-items:center;gap:6px;color:var(--gray-500);font-size:0.875rem;text-decoration:none;margin-bottom:1.25rem;">← Kembali ke Daftar</a>

<div class="page-header">
    <h1>✏️ Edit Produk</h1>
    <p>Perbarui informasi produk: <strong>{{ $product->name }}</strong></p>
</div>

<div style="background:white;border-radius:14px;border:1px solid var(--gray-200);overflow:hidden;">
    <div style="padding:1.5rem;border-bottom:1px solid var(--gray-100);">
        <div style="font-size:1.1rem;font-weight:700;color:var(--gray-900)">Informasi Produk</div>
        <div style="font-size:0.875rem;color:var(--gray-500);margin-top:2px">Kolom bertanda <span style="color:var(--red-600)">*</span> wajib diisi</div>
    </div>
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf @method('PUT')
        <div style="padding:1.75rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

                <div style="display:flex;flex-direction:column;gap:6px;grid-column:1/-1">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Nama Produk *</label>
                    <input type="text" name="name"
                        style="padding:10px 14px;border:1px solid {{ $errors->has('name') ? 'var(--red-600)' : 'var(--gray-200)' }};border-radius:10px;font-size:0.875rem;outline:none;width:100%"
                        value="{{ old('name', $product->name) }}" placeholder="Nama produk">
                    @error('name')<div style="font-size:0.78rem;color:var(--red-600)">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Kategori *</label>
                    <input type="text" name="category" list="cat-list"
                        style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;width:100%"
                        value="{{ old('category', $product->category) }}">
                    <datalist id="cat-list">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    @error('category')<div style="font-size:0.78rem;color:var(--red-600)">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">SKU / Kode</label>
                    <input type="text" name="sku"
                        style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;width:100%;font-family:monospace"
                        value="{{ old('sku', $product->sku) }}">
                    @error('sku')<div style="font-size:0.78rem;color:var(--red-600)">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Harga *</label>
                    <div style="display:flex">
                        <span style="padding:10px 14px;background:var(--gray-50);border:1px solid var(--gray-200);border-radius:10px 0 0 10px;font-size:0.875rem;color:var(--gray-500)">Rp</span>
                        <input type="number" name="price" min="0" step="500"
                            style="padding:10px 14px;border:1px solid var(--gray-200);border-left:none;border-radius:0 10px 10px 0;font-size:0.875rem;outline:none;width:100%"
                            value="{{ old('price', $product->price) }}">
                    </div>
                    @error('price')<div style="font-size:0.78rem;color:var(--red-600)">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Stok *</label>
                    <input type="number" name="stock" min="0"
                        style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;width:100%"
                        value="{{ old('stock', $product->stock) }}">
                    @error('stock')<div style="font-size:0.78rem;color:var(--red-600)">{{ $message }}</div>@enderror
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Satuan *</label>
                    <select name="unit" style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;background:white;width:100%">
                        @foreach(['pcs','kg','liter','pak','lusin','botol','kaleng','dus','gram','ml'] as $u)
                            <option value="{{ $u }}" {{ old('unit', $product->unit) == $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Status *</label>
                    <select name="status" style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;background:white;width:100%">
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;grid-column:1/-1">
                    <label style="font-size:0.825rem;font-weight:600;color:var(--gray-700)">Deskripsi</label>
                    <textarea name="description" rows="3"
                        style="padding:10px 14px;border:1px solid var(--gray-200);border-radius:10px;font-size:0.875rem;outline:none;width:100%;resize:vertical">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>
        <div style="padding:1.25rem 1.75rem;border-top:1px solid var(--gray-100);display:flex;gap:10px;justify-content:flex-end">
            <a href="{{ route('products.index') }}" style="background:var(--gray-100);color:var(--gray-700);padding:10px 22px;border-radius:10px;font-size:0.875rem;text-decoration:none;font-weight:500">Batal</a>
            <button type="submit" style="background:var(--blue-600);color:white;padding:10px 22px;border-radius:10px;font-size:0.875rem;border:none;cursor:pointer;font-weight:600">💾 Perbarui</button>
        </div>
    </form>
</div>
@endsection