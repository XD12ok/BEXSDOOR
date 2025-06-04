class ShoppingCart extends HTMLElement {
    constructor() {
        super();
        this.cartItems = [];
        this.isLoading = true;
        this.attachShadow({ mode: 'open' });
        this.loadCartData().then(() => this.render());
    }

    async loadCartData() {
        try {
            const response = await fetch('/api/cart-items', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to load cart data');

            const data = await response.json();
            this.cartItems = data.items;
            this.initialSubtotal = data.subtotal;
            this.isLoading = false;
        } catch (error) {
            console.error('Error loading cart:', error);
            this.isLoading = false;
            this.cartItems = [];
        }
    }

    formatRupiah(number) {
        return "Rp " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    calculateSubtotal() {
        return this.cartItems.reduce((total, item) => {
            return item.selected ? total + (item.price * item.quantity) : total;
        }, 0);
    }

    async updateQuantity(itemId, newQuantity) {
        try {
            const response = await fetch(`/api/cart/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQuantity })
            });

            if (!response.ok) throw new Error('Update failed');

            const item = this.cartItems.find(i => i.id === itemId);
            if (item) item.quantity = newQuantity;
            this.updateCart();
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    async removeItem(itemId) {
        try {
            const response = await fetch(`/api/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Delete failed');

            this.cartItems = this.cartItems.filter(i => i.id !== itemId);
            this.updateCart();
        } catch (error) {
            console.error('Error removing item:', error);
        }
    }

    updateCart() {
        this.shadowRoot.getElementById('cartItemsContainer').innerHTML = this.renderCartItems();
        this.shadowRoot.getElementById('subtotalAmount').textContent = this.formatRupiah(this.calculateSubtotal());
    }

    renderCartItems() {
        if (this.isLoading) {
            return '<div class="text-center py-4">Memuat keranjang...</div>';
        }

        if (this.cartItems.length === 0) {
            return '<div class="text-center py-4">Keranjang belanja kosong</div>';
        }

        return this.cartItems.map(item => `
      <div class="flex items-start gap-3 mb-4">
        <input type="checkbox" class="w-4 h-4 mt-1 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
               data-id="${item.id}" ${item.selected ? 'checked' : ''} />
        <img src="${item.image}" alt="${item.name}" class="w-10 h-10 object-cover" width="40" height="40" />
        <div class="text-xs leading-4 text-black flex-1">
          <p class="font-normal">${item.name}</p>
          <p class="text-gray-400 text-[10px] leading-3 mt-0.5">${this.formatRupiah(item.price)}</p>
        </div>
        <div class="flex items-center gap-1">
          <button type="button" data-id="${item.id}" data-action="decrement"
                  class="w-6 h-6 bg-gray-200 text-gray-700 text-xs font-semibold rounded-sm flex items-center justify-center select-none">
            -
          </button>
          <span class="text-xs font-semibold text-black w-4 text-center">${item.quantity}</span>
          <button type="button" data-id="${item.id}" data-action="increment"
                  class="w-6 h-6 bg-gray-200 text-gray-700 text-xs font-semibold rounded-sm flex items-center justify-center select-none">
            +
          </button>
          <button type="button" data-id="${item.id}" data-action="remove"
                  class="w-6 h-6 bg-red-100 text-red-700 text-xs font-semibold rounded-sm flex items-center justify-center select-none ml-2">
            <i class="fas fa-trash text-xs"></i>
          </button>
        </div>
      </div>
    `).join('');
    }

    render() {
        this.shadowRoot.innerHTML = `
      <style>
        /* Previous styles remain the same */
      </style>

      <!-- Overlay -->
      <div id="overlay" class="hidden"></div>

      <!-- Cart Panel -->
      <aside id="cartPanel" aria-label="Shopping Cart">
        <div class="flex justify-between items-center mb-4">
          <h2 class="font-semibold text-black text-base leading-5">Keranjang Belanja</h2>
          <button id="closeCartBtn" aria-label="Close cart" class="text-black text-sm">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form id="cartForm" class="flex flex-col flex-grow">
          <div id="cartItemsContainer" class="flex flex-col gap-6 overflow-y-auto">
            ${this.renderCartItems()}
          </div>

          <div class="border-t border-gray-200 pt-4 mt-6 flex justify-between items-center">
            <span class="font-semibold text-black text-sm leading-5">Subtotal:</span>
            <span id="subtotalAmount" class="font-semibold text-black text-sm leading-5">
              ${this.formatRupiah(this.initialSubtotal || 0)}
            </span>
          </div>

          <div class="mt-6">
            <h2 class="font-medium mb-2">Detail Pelanggan</h2>
            <div class="space-y-3">
              <input type="text" name="name" placeholder="Nama" class="w-full border px-3 py-2 rounded" required />
              <input type="email" name="email" placeholder="Email" class="w-full border px-3 py-2 rounded" required />
              <input type="text" name="phone" placeholder="Nomor Telepon" class="w-full border px-3 py-2 rounded" required />
              <textarea name="address" placeholder="Alamat Lengkap" class="w-full border px-3 py-2 rounded" required></textarea>

              <button type="submit" class="mt-3 w-full bg-black text-white py-3 rounded hover:bg-gray-800">
                Pembayaran
              </button>
            </div>
          </div>
        </form>
      </aside>
    `;


        // Event listeners
        this.shadowRoot.getElementById('closeCartBtn').addEventListener('click', () => this.toggleCart());
        this.shadowRoot.getElementById('overlay').addEventListener('click', () => this.toggleCart());

        // Delegated event listeners
        this.shadowRoot.getElementById('cartItemsContainer').addEventListener('click', async (e) => {
            if (!e.target.closest('[data-action]')) return;

            const button = e.target.closest('[data-action]');
            const itemId = parseInt(button.dataset.id);
            const action = button.dataset.action;
            const item = this.cartItems.find(i => i.id === itemId);

            if (!item) return;

            if (action === 'decrement') {
                const newQty = Math.max(1, item.quantity - 1);
                await this.updateQuantity(itemId, newQty);
            } else if (action === 'increment') {
                const newQty = item.quantity + 1;
                await this.updateQuantity(itemId, newQty);
            } else if (action === 'remove') {
                await this.removeItem(itemId);
            }
        });

        this.shadowRoot.getElementById('cartItemsContainer').addEventListener('change', (e) => {
            if (e.target.matches('input[type="checkbox"]')) {
                const itemId = parseInt(e.target.dataset.id);
                const item = this.cartItems.find(i => i.id === itemId);
                if (item) {
                    item.selected = e.target.checked;
                    this.updateCart();
                }
            }
        });
    }
    toggleCart() {
        const panel = this.shadowRoot.getElementById('cartPanel');
        const overlay = this.shadowRoot.getElementById('overlay');

        const isVisible = !panel.classList.contains('hidden');

        if (isVisible) {
            panel.classList.add('hidden');
            overlay.classList.add('hidden');
        } else {
            panel.classList.remove('hidden');
            overlay.classList.remove('hidden');
        }
    }

}

customElements.define('shopping-cart', ShoppingCart);


// Initialize
document.addEventListener('DOMContentLoaded', () => {
    const cartComponent = document.createElement('shopping-cart');
    document.body.appendChild(cartComponent);

    document.getElementById('openCartBtn').addEventListener('click', () => {
        const cart = document.querySelector('shopping-cart');
        cart.toggleCart()
    });
});
