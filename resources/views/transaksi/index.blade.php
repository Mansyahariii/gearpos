@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Point of Sales')

@push('styles')
<style>
    .product-card {
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    .product-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    .product-card.selected {
        border-color: var(--primary-color);
        background: rgba(13, 110, 253, 0.05);
    }
    .cart-item {
        padding: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .cart-total {
        background: #f8fafc;
        padding: 1rem;
        font-size: 1.25rem;
    }
    .qty-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="row">
    <!-- Product List -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-box-seam me-2"></i>Pilih Barang</span>
                <input type="text" id="searchProduct" class="form-control form-control-sm w-50" placeholder="Cari barang...">
            </div>
            <div class="card-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="row g-3" id="productGrid">
                    @foreach($barangs as $barang)
                    <div class="col-6 col-md-4 product-item" data-name="{{ strtolower($barang->nama_barang) }}">
                        <div class="product-card card h-100" onclick="addToCart({{ $barang->barang_id }}, '{{ $barang->nama_barang }}', {{ $barang->harga_jual }}, {{ $barang->stok }})">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-1">{{ $barang->nama_barang }}</h6>
                                <small class="text-muted">{{ $barang->kategori->nama_kategori ?? '' }}</small>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <strong class="text-primary">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</strong>
                                    <span class="badge {{ $barang->stok < 10 ? 'bg-warning' : 'bg-success' }}">
                                        {{ $barang->stok }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cart -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-cart3 me-2"></i>Keranjang
            </div>
            <div class="card-body p-0" style="max-height: 40vh; overflow-y: auto;">
                <div id="cartItems">
                    <div class="text-center py-5 text-muted" id="emptyCart">
                        <i class="bi bi-cart display-1"></i>
                        <p class="mt-2">Keranjang kosong</p>
                    </div>
                </div>
            </div>
            <div class="cart-total d-flex justify-content-between align-items-center">
                <span>Total:</span>
                <strong id="cartTotal">Rp 0</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select id="paymentMethod" class="form-select">
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary w-100 btn-lg" onclick="processTransaction()" id="btnProcess" disabled>
                    <i class="bi bi-check-circle me-2"></i>Proses Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <i class="bi bi-check-circle-fill text-success display-1"></i>
                <h4 class="mt-3">Transaksi Berhasil!</h4>
                <p class="text-muted mb-4">Total: <strong id="modalTotal"></strong></p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="#" id="btnCetak" class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-printer me-1"></i>Cetak Faktur
                    </a>
                    <button type="button" class="btn btn-primary" onclick="newTransaction()">
                        <i class="bi bi-plus me-1"></i>Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cart = [];

function addToCart(id, nama, harga, stok) {
    const existing = cart.find(item => item.id === id);
    
    if (existing) {
        if (existing.jumlah < stok) {
            existing.jumlah++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        cart.push({ id, nama, harga, stok, jumlah: 1 });
    }
    
    renderCart();
}

function updateQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.jumlah += delta;
        if (item.jumlah > item.stok) {
            alert('Stok tidak mencukupi!');
            item.jumlah = item.stok;
        }
        if (item.jumlah <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
    }
    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(i => i.id !== id);
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    const btnProcess = document.getElementById('btnProcess');
    
    if (cart.length === 0) {
        container.innerHTML = `<div class="text-center py-5 text-muted" id="emptyCart">
            <i class="bi bi-cart display-1"></i>
            <p class="mt-2">Keranjang kosong</p>
        </div>`;
        btnProcess.disabled = true;
    } else {
        let html = '';
        cart.forEach(item => {
            const subtotal = item.harga * item.jumlah;
            html += `
                <div class="cart-item d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <strong>${item.nama}</strong>
                        <div class="text-muted small">Rp ${numberFormat(item.harga)} x ${item.jumlah}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary qty-btn" onclick="updateQty(${item.id}, -1)">-</button>
                            <span class="btn btn-outline-secondary qty-btn" style="pointer-events:none">${item.jumlah}</span>
                            <button class="btn btn-outline-secondary qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                        </div>
                        <strong>Rp ${numberFormat(subtotal)}</strong>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.id})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
        btnProcess.disabled = false;
    }
    
    updateTotal();
}

function updateTotal() {
    const total = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    document.getElementById('cartTotal').textContent = 'Rp ' + numberFormat(total);
}

function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function processTransaction() {
    if (cart.length === 0) return;
    
    const btn = document.getElementById('btnProcess');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    
    const items = cart.map(item => ({
        barang_id: item.id,
        jumlah: item.jumlah
    }));
    
    fetch('{{ route("transaksi.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            items: items,
            metode_pembayaran: document.getElementById('paymentMethod').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('modalTotal').textContent = 'Rp ' + numberFormat(data.total);
            document.getElementById('btnCetak').href = '/transaksi/' + data.transaksi_id;
            new bootstrap.Modal(document.getElementById('successModal')).show();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Proses Transaksi';
    });
}

function newTransaction() {
    cart = [];
    renderCart();
    bootstrap.Modal.getInstance(document.getElementById('successModal')).hide();
}

// Search functionality
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item => {
        const name = item.dataset.name;
        item.style.display = name.includes(search) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
