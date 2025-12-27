@extends('layouts.app')

@section('title', 'Tambah Stok')
@section('page-title', 'Tambah Stok Barang')

@push('styles')
<style>
    .item-row { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
</style>
@endpush

@section('content')
<form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-seam me-2"></i>Pilih Barang</span>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addItem()">
                        <i class="bi bi-plus me-1"></i>Tambah Baris
                    </button>
                </div>
                <div class="card-body p-0" id="itemsContainer">
                    <!-- Items will be added here -->
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Ringkasan</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Item:</span>
                        <strong id="totalItems">0</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Harga:</span>
                        <strong id="totalHarga">Rp 0</strong>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan Pembelian
                    </button>
                    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
const barangs = @json($barangs);
let itemIndex = 0;

function addItem() {
    const container = document.getElementById('itemsContainer');
    const html = `
        <div class="item-row" id="item-${itemIndex}">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Barang</label>
                    <select name="items[${itemIndex}][barang_id]" class="form-select" required onchange="updateHarga(${itemIndex})">
                        <option value="">Pilih Barang</option>
                        ${barangs.map(b => `<option value="${b.barang_id}" data-harga="${b.harga_beli}">${b.nama_barang}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="items[${itemIndex}][jumlah]" class="form-control" 
                           min="1" value="1" required onchange="calculateTotal()">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="items[${itemIndex}][harga_beli]" class="form-control harga-input" 
                           min="0" value="0" required onchange="calculateTotal()">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="removeItem(${itemIndex})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    itemIndex++;
    calculateTotal();
}

function removeItem(index) {
    document.getElementById(`item-${index}`).remove();
    calculateTotal();
}

function updateHarga(index) {
    const select = document.querySelector(`[name="items[${index}][barang_id]"]`);
    const hargaInput = document.querySelector(`[name="items[${index}][harga_beli]"]`);
    const option = select.selectedOptions[0];
    if (option && option.dataset.harga) {
        hargaInput.value = option.dataset.harga;
    }
    calculateTotal();
}

function calculateTotal() {
    const rows = document.querySelectorAll('.item-row');
    let totalItems = 0;
    let totalHarga = 0;
    
    rows.forEach(row => {
        const jumlah = parseInt(row.querySelector('[name*="jumlah"]')?.value || 0);
        const harga = parseFloat(row.querySelector('[name*="harga_beli"]')?.value || 0);
        totalItems += jumlah;
        totalHarga += jumlah * harga;
    });
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalHarga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
}

// Add initial row
addItem();
</script>
@endpush
@endsection
