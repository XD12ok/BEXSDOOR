@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex justify-center">
        <div class="w-full max-w-4xl bg-white p-6 shadow-lg rounded-lg mt-6">
            <div class=" flex justify-between mb-5">
                <h1 class="text-xl font-bold mb-4">Keranjang Belanja</h1>
                <a href="{{route('orders.history')}}">
                    <button class="bg-black rounded-2xl text-white py-2 px-4 rounded hover:bg-gray-800">
                        Riwayat belanja
                    </button>
                </a>

            </div>

            <!-- ✅ DAFTAR PRODUK -->
            @foreach($cartItems as $item)
                <div class="flex items-start gap-4 border-b pb-4 mb-4">
                    <!-- Checkbox -->
                    <div class="pt-6">
                        <input type="checkbox"
                               class="item-checkbox mt-2"
                               data-price="{{ $item->product->price }}"
                               data-quantity="{{ $item->quantity }}"
                               data-product-id="{{ $item->product->id }}"
                               data-id="{{ $item->id }}"
                               value="{{ $item->id }}">
                    </div>

                    <!-- Gambar -->
                    @if($item->product->image)
                        <img src="data:image/jpeg;base64,{{ base64_encode($item->product->image) }}"
                             alt="Produk" class="w-20 h-20 object-cover rounded">
                    @endif

                    <!-- Info Produk dan Kuantitas -->
                    <div class="flex-1">
                        <div class="font-semibold">{{ $item->product->name }}</div>
                        <div class="text-sm text-gray-600">
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                        </div>

                        <!-- Tombol kuantitas -->
                        <div class="flex items-center mt-2 space-x-2">
                            <button type="button" class="quantity-btn bg-gray-200 hover:bg-gray-300 rounded w-7 h-7" data-id="{{ $item->id }}" data-action="decrement">−</button>
                            <input type="text" readonly value="{{ $item->quantity }}" class="w-8 text-center border rounded quantity-value" data-id="{{ $item->id }}">
                            <button type="button" class="quantity-btn bg-gray-200 hover:bg-gray-300 rounded w-7 h-7" data-id="{{ $item->id }}" data-action="increment">+</button>
                        </div>
                    </div>

                    <!-- ✅ Tombol Hapus (bukan bagian form utama) -->
                    <div>
                        <button
                            type="button"
                            onclick="if(confirm('Hapus item ini?')) document.getElementById('delete-form-{{ $item->id }}').submit();"
                            class="text-red-600 hover:text-red-800 font-bold ml-2"
                        ><span class="material-symbols-outlined">
                                                                        delete
                                                                </span></button>

                        <form id="delete-form-{{ $item->id }}"
                              action="{{ route('cart.remove', $item->id) }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Subtotal -->
            <div class="text-right font-semibold text-lg mt-4">
                Subtotal: Rp <span id="subtotal">0</span>
            </div>

            <!-- ✅ FORM CHECKOUT -->
            <div class="mt-6">
                <h2 class="font-medium mb-2">Detail Pelanggan</h2>
                <form id="checkout-form">
                    @csrf
                    <div class="space-y-3">
                        <input type="text" name="name" placeholder="Nama Penerima" class="w-full border px-3 py-2 rounded"
                               value="{{ old('name', $orders->name ?? Auth::user()->name) }}" required>

                        <input type="email" name="email" placeholder="Email" class="w-full border px-3 py-2 rounded"
                               value="{{ old('email', $orders->email ?? Auth::user()->email) }}" required>

                        <input type="text" name="phone" placeholder="Nomor Telp" class="w-full border px-3 py-2 rounded"
                               value="{{ old('phone', Auth::user()->phone ?? '') }}" required>

                        <input type="text" name="kecamatan" placeholder="Kecamatan" class="w-full border px-3 py-2 rounded"
                               value="{{ old('kecamatan',Auth::user()->kecamatan ?? '') }}" required>

                        <input type="text" name="kelurahan" placeholder="Kelurahan" class="w-full border px-3 py-2 rounded"
                               value="{{ old('kelurahan',Auth::user()->kelurahan ?? '') }}" required>

                        <input type="text" name="kode_pos" placeholder="Kode Pos" class="w-full border px-3 py-2 rounded"
                               value="{{ old('kode_pos',Auth::user()->kode_pos ?? '') }}" required>

                        <textarea name="alamat" placeholder="Alamat lengkap" class="w-full border px-3 py-2 rounded" required>{{ old('alamat',Auth::user()->alamat ?? '') }}</textarea>

                        <div class="text-sm mx-auto w-fit text-gray-500 text-center">Pastikan formulir diisi dengan benar dan tepat!</div>

                        <button type="button" id="pay-button" class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">
                            Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script>
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const itemId = this.dataset.id;
                    const action = this.dataset.action;
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/cart/updateQuantity/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'PATCH',
                            [action]: true
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update quantity input
                                document.querySelector(`.quantity-value[data-id="${itemId}"]`).value = data.quantity;

                                // Update subtotal
                                updateSubtotal();
                            }
                        });
                });
            });

            function updateSubtotal() {
                let subtotal = 0;

                document.querySelectorAll('.item-checkbox').forEach(cb => {
                    if (cb.checked) {
                        const id = cb.value;
                        const qty = parseInt(document.querySelector(`.quantity-value[data-id="${id}"]`).value) || 0;
                        const price = parseInt(cb.dataset.price) || 0;
                        subtotal += price * qty;
                    }
                });

                document.getElementById('subtotal').textContent = subtotal.toLocaleString('id-ID');
            }

            document.querySelectorAll('.item-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    updateSubtotal();
                });
            });

            //midtrans
            document.getElementById('pay-button').addEventListener('click', function () {
                const selectedItems = [];

                document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                    const id = cb.value;
                    const quantity = parseInt(document.querySelector(`.quantity-value[data-id="${id}"]`).value) || 1;

                    selectedItems.push({
                        product_id: parseInt(cb.dataset.productId),
                        quantity: quantity
                    });
                });

                if (selectedItems.length === 0) {
                    alert("Pilih produk terlebih dahulu.");
                    return;
                }

                // Ambil data dari form
                const form = document.getElementById('checkout-form');
                const formData = new FormData(form);
                const payload = {
                    items: selectedItems,
                    name: formData.get('name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    alamat: formData.get('alamat'),
                    kecamatan: formData.get('kecamatan'),
                    kelurahan: formData.get('kelurahan'),
                    kode_pos: formData.get('kode_pos'),
                };

                fetch("{{ route('checkout.process') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(errRes => {
                                throw new Error(errRes.error || 'Server error');
                            });
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.midtrans && data.midtrans.token) {
                            snap.pay(data.midtrans.token, {
                                onSuccess: function(result) {
                                    window.location.href = "/orders/history";
                                },
                                onPending: function(result) {
                                    window.location.href = "/orders/history";
                                },
                                onError: function(result) {
                                    alert('Terjadi kesalahan pembayaran!');
                                }
                            });
                        } else {
                            alert("Gagal melakukan transaksi");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error: ' + err.message);
                    });

            });


        </script>

    @endpush
@endsection
